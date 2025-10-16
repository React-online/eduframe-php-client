<?php

namespace Eduframe\Traits;

trait Storable
{
    use BaseTrait;

    /**
     * @throws \Eduframe\Exceptions\ApiException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function save(): static|bool
    {
        if ($this->exists()) {
            return $this->update();
        }

        return $this->insert();
    }

    /**
     * @throws \Eduframe\Exceptions\ApiException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function insert(): static
    {
        $result = $this->connection()->post($this->getEndpoint(), $this->json());

        return $this->selfFromResponse($result);
    }

    /**
     * @throws \Eduframe\Exceptions\ApiException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(): static|bool
    {
        $result = $this->connection()->patch($this->getEndpoint() . '/' . urlencode($this->id), $this->json());

        if ($result === 200) {
            return true;
        }

        return $this->selfFromResponse($result);
    }
}
