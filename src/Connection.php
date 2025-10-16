<?php

namespace Eduframe;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Eduframe\Exceptions\ApiException;

const PRODUCTION = 'production';
const TESTING = 'testing';
const STAGING = 'staging';

class Connection
{
    private string $apiUrl = 'https://api.eduframe.nl/api/v1';

    private ?string $accessToken = null;

    private ?Client $client = null;

    private array $clientConfig;

    protected array $middleWares = [];

    private string $stage = PRODUCTION;

    public function __construct(array $clientConfig = [])
    {
        $this->clientConfig = $clientConfig;
    }

    private function client(): Client
    {
        if ($this->client) {
            return $this->client;
        }

        $handlerStack = HandlerStack::create();
        foreach ($this->middleWares as $middleWare) {
            $handlerStack->push($middleWare);
        }

        $defaultClientConfig = [
            'http_errors' => true,
            'handler'     => $handlerStack,
            'expect'      => false,
        ];

        $clientConfig = array_merge($defaultClientConfig, $this->clientConfig);

        $this->client = new Client($clientConfig);

        return $this->client;
    }

    public function insertMiddleWare(callable $middleWare): void
    {
        $this->middleWares[] = $middleWare;
    }

    public function connect(): Client
    {
        return $this->client();
    }

    private function createRequest(
        string $method = 'GET',
        string $endpoint = '',
        ?string $body = null,
        array $params = [],
        array $headers = []
    ): Request {
        // Add default json headers to the request
        $headers = array_merge($headers, [
            'Accept' => 'application/json',
        ]);

        // Add content type when [POST PATCH PUT] request
        if (in_array($method, ['POST', 'PATCH', 'PUT'])) {
            $headers = array_merge($headers, [
                'Content-Type' => 'application/json'
            ]);
        }

        // If we have a token, sign the request
        if (!empty($this->accessToken)) {
            $headers['Authorization'] = 'Bearer ' . $this->accessToken;
        }

        // Create param string
        if (!empty($params)) {
            $endpoint .= '?' . http_build_query($params);
        }

        // Create the request
        return new Request($method, $endpoint, $headers, $body);
    }

    /**
     * @throws ApiException
     */
    private function createRequestNoJson(
        string $method = 'GET',
        string $endpoint = '',
        ?string $body = null,
        array $params = [],
        array $headers = []
    ): Request {
        // Add default json headers to the request
        $headers = array_merge($headers, [
            'Content-type' => 'application/x-www-form-urlencoded'
        ]);

        // If access token is not set or token has expired, acquire new token
        if (empty($this->accessToken)) {
            throw new ApiException('No access token set.');
        }

        // If we have a token, sign the request
        if (!empty($this->accessToken)) {
            $headers['Authorization'] = 'Bearer ' . $this->accessToken;
        }

        // Create param string
        if (!empty($params)) {
            $endpoint .= '?' . http_build_query($params);
        }

        // Create the request
        return new Request($method, $endpoint, $headers, $body);
    }

    /**
     * @throws ApiException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(string $url, array $params = [], bool $fetchAll = false): array
    {
        try {
            $request  = $this->createRequest('GET', $this->formatUrl($url, 'get'), null, $params);
            $response = $this->client()->send($request);

            $json = $this->parseResponse($response);

            if ($fetchAll === true) {
                while ($nextParams = $this->getNextParams($response->getHeaderLine('Link'))) {
                    $request  = $this->createRequest('GET', $this->formatUrl($url, 'get'), null, $nextParams);
                    $response = $this->client()->send($request);
                    $json = array_merge($json, $this->parseResponse($response));
                }
            }

            return $json;
        } catch (Exception $e) {
            throw $this->parseExceptionForErrorMessages($e);
        }
    }

    /**
     * @throws ApiException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post(string $url, string $body): array
    {
        try {
            $request = $this->createRequest('POST', $this->formatUrl($url, 'post'), $body);
            $response = $this->client()->send($request);

            return $this->parseResponse($response);
        } catch (Exception $e) {
            throw $this->parseExceptionForErrorMessages($e);
        }
    }

    /**
     * @throws ApiException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function patch(string $url, string $body): array
    {
        try {
            $request  = $this->createRequest('PUT', $this->formatUrl($url, 'patch'), $body);
            $response = $this->client()->send($request);

            return $this->parseResponse($response);
        } catch (Exception $e) {
            throw $this->parseExceptionForErrorMessages($e);
        }
    }

    /**
     * @throws ApiException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(string $url, ?string $body = null): array
    {
        try {
            $request  = $this->createRequestNoJson('DELETE', $this->formatUrl($url, 'delete'), $body);
            $response = $this->client()->send($request);

            return $this->parseResponse($response);
        } catch (Exception $e) {
            throw $this->parseExceptionForErrorMessages($e);
        }
    }

    /**
     * @throws ApiException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function upload(string $url, array $options): array
    {
        try {
            $request = $this->createRequestNoJson('POST', $this->formatUrl($url, 'post'), null);

            $response = $this->client()->send($request, $options);

            return $this->parseResponse($response);
        } catch (Exception $e) {
            throw $this->parseExceptionForErrorMessages($e);
        }
    }

    public function setAccessToken(string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @throws ApiException
     */
    private function parseResponse(Response $response): array
    {
        try {
            Psr7\Message::rewindBody($response);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\RuntimeException $e) {
            throw new ApiException($e->getMessage());
        }
    }

    private function getNextParams(string $headerLine): array|false
    {
        $links = Psr7\Header::parse($headerLine);

        foreach ($links as $link) {
            if (isset($link['rel']) && $link['rel'] === 'next') {
                $query = parse_url(trim($link[0], '<>'), PHP_URL_QUERY);
                parse_str($query, $params);

                return $params;
            }
        }

        return false;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    private function parseExceptionForErrorMessages(Exception $exception): ApiException
    {
        if (!$exception instanceof BadResponseException) {
            return new ApiException($exception->getMessage(), 0, $exception);
        }

        $response = $exception->getResponse();

        if (null === $response) {
            return new ApiException('Response is NULL.', 0, $exception);
        }

        Psr7\Message::rewindBody($response);
        $responseBody        = $response->getBody()->getContents();
        $decodedResponseBody = json_decode($responseBody, true);

        if (null !== $decodedResponseBody && isset($decodedResponseBody['error']['message']['value'])) {
            $errorMessage = $decodedResponseBody['error']['message']['value'];
        } else {
            $errorMessage = $responseBody;
        }

        return new ApiException(
            'Error ' . $response->getStatusCode() . ': ' . $errorMessage,
            $response->getStatusCode(),
            $exception
        );
    }

    private function formatUrl(string $url, string $method = 'get'): string
    {
        if ($this->stage === TESTING) {
            return 'https://api.testing.eduframe.dev/api/v1' . '/' . $url;
        } elseif ($this->stage === STAGING) {
            return 'https://api.edufra.me/api/v1' . '/' . $url;
        }

        return $this->apiUrl  . '/' . $url;
    }

    public function setTesting(bool $testing): void
    {
        if ($testing) {
            $this->stage = TESTING;
        } else {
            $this->stage = PRODUCTION;
        }
    }

    public function getStage(): string
    {
        return $this->stage;
    }

    public function setStage(string $stage): void
    {
        $this->stage = $stage;
    }
}
