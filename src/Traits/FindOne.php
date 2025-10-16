<?php

namespace Eduframe\Traits;

trait FindOne
{
    use BaseTrait;

    /**
     * @throws \Eduframe\Exceptions\ApiException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function find(string|int $id, array $params = []): static
    {
        $result = $this->connection()->get($this->getEndpoint() . '/' . urlencode($id), $params);

        return $this->makeFromResponse($result);
    }
}
