<?php

namespace Eduframe\Traits;

trait BaseTrait
{
    abstract protected function connection(): \Eduframe\Connection;

    abstract protected function getEndpoint(): string;

    abstract protected function collectionFromResult(array $result): array;

    abstract protected function makeFromResponse(array $response): static;
}
