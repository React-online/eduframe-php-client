<?php

namespace Eduframe\Traits;

trait FindAll
{
    use BaseTrait;

    /**
     * @throws \Eduframe\Exceptions\ApiException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(): array {
        $result = $this->connection()->get($this->getEndpoint());

        return $this->collectionFromResult($result);
    }

    /**
     * @throws \Eduframe\Exceptions\ApiException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function all(array $params = []): array {
        $result = $this->connection()->get($this->getEndpoint(), $params, true);

        return $this->collectionFromResult($result);
    }
}
