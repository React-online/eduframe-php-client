<?php

namespace Eduframe;

use JsonSerializable;
use StdClass;

abstract class Resource implements JsonSerializable
{
    public const NESTING_TYPE_ARRAY_OF_OBJECTS = 0;
    public const NESTING_TYPE_NESTED_OBJECTS = 1;

    protected array $attributes = [];

    protected array $fillable = [];

    protected string $endpoint = '';

    protected string $primaryKey = 'id';

    protected string $namespace = '';

    protected array $singleNestedEntities = [];

    /**
     * Array containing the name of the attribute that contains nested objects as key and an array with the entity name
     * and json representation type
     *
     * JSON representation of an array of objects (NESTING_TYPE_ARRAY_OF_OBJECTS) : [ {}, {} ]
     * JSON representation of nested objects (NESTING_TYPE_NESTED_OBJECTS): { "0": {}, "1": {} }
     */
    protected array $multipleNestedEntities = [];

    public function __construct(protected Connection $connection, array $attributes = []) {
        $this->fill($attributes);
    }

    public function connection(): Connection {
        return $this->connection;
    }

    public function attributes(): array {
        return $this->attributes;
    }

    protected function fill(array $attributes): void {
        foreach ($this->fillableFromArray($attributes) as $key => $value) {
            if ($this->isFillable($key)) {
                $this->setAttribute($key, $value);
            }
        }
    }

    protected function fillableFromArray(array $attributes): array {
        if (count($this->fillable) > 0) {
            return array_intersect_key($attributes, array_flip($this->fillable));
        }

        return $attributes;
    }

    protected function isFillable(string $key): bool {
        return in_array($key, $this->fillable, true);
    }

    protected function setAttribute(string $key, mixed $value): void {
        $this->attributes[$key] = $value;
    }

    public function __get(string $key): mixed {
        return $this->attributes[$key] ?? null;
    }

    public function __set(string $key, mixed $value): void {
        if ($this->isFillable($key)) {
            $this->setAttribute($key, $value);
        }
    }

    public function exists(): bool {
        if (!array_key_exists($this->primaryKey, $this->attributes)) {
            return false;
        }

        return !empty($this->attributes[$this->primaryKey]);
    }

    public function json(): string {
        $array = $this->getArrayWithNestedObjects();

        return json_encode($array);
    }

    public function jsonWithNamespace(): string {
        if ($this->namespace !== '') {
            return json_encode([$this->namespace => $this->getArrayWithNestedObjects()], JSON_FORCE_OBJECT);
        }

        return $this->json();
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array {
        return $this->attributes();
    }

    private function getArrayWithNestedObjects(bool $useAttributesAppend = true): array {
        $result = [];
        $multipleNestedEntities = $this->getMultipleNestedEntities();

        foreach ($this->attributes as $attributeName => $attributeValue) {
            if (!is_object($attributeValue)) {
                $result[$attributeName] = $attributeValue;
            }

            if (array_key_exists($attributeName, $this->getSingleNestedEntities())) {
                $attributeNameToUse = $useAttributesAppend ? $attributeName . '_attributes' : $attributeName;
                $result[$attributeNameToUse] = $attributeValue->attributes;
            }

            if (array_key_exists($attributeName, $multipleNestedEntities)) {
                $attributeNameToUse = $useAttributesAppend ? $attributeName . '_attributes' : $attributeName;
                $result[$attributeNameToUse] = [];

                foreach ($attributeValue as $attributeEntity) {
                    $result[$attributeNameToUse][] = $attributeEntity->attributes;
                }

                if ($multipleNestedEntities[$attributeName]['type'] === self::NESTING_TYPE_NESTED_OBJECTS) {
                    $result[$attributeNameToUse] = (object) $result[$attributeNameToUse];
                }

                if (
                    $multipleNestedEntities[$attributeName]['type'] === self::NESTING_TYPE_NESTED_OBJECTS
                    && empty($result[$attributeNameToUse])
                ) {
                    $result[$attributeNameToUse] = new StdClass();
                }
            }
        }

        return $result;
    }

    public function makeFromResponse(array $response): static {
        $entity = new static($this->connection);
        $entity->selfFromResponse($response);

        return $entity;
    }

    public function selfFromResponse(array $response): static {
        $this->fill($response);

        foreach ($this->getSingleNestedEntities() as $key => $value) {
            if (isset($response[$key])) {
                $entityName = $value;
                $this->$key = new $entityName($this->connection, $response[$key]);
            }
        }

        foreach ($this->getMultipleNestedEntities() as $key => $value) {
            if (isset($response[$key])) {
                $entityName = $value['entity'];
                $instantiatedEntity = new $entityName($this->connection);
                $this->$key = $instantiatedEntity->collectionFromResult($response[$key]);
            }
        }

        return $this;
    }

    public function collectionFromResult(array $result): array {
        // If we have one result which is not an assoc array, make it the first element of an array for the
        // collectionFromResult function so we always return a collection from filter
        if ((bool) count(array_filter(array_keys($result), 'is_string'))) {
            $result = [$result];
        }

        $collection = [];
        foreach ($result as $r) {
            $collection[] = $this->makeFromResponse($r);
        }

        return $collection;
    }

    public function getSingleNestedEntities(): array {
        return $this->singleNestedEntities;
    }

    public function getMultipleNestedEntities(): array {
        return $this->multipleNestedEntities;
    }

    public function __debugInfo(): array {
        $result = [];
        foreach ($this->fillable as $attribute) {
            $result[$attribute] = $this->$attribute;
        }
        return $result;
    }

    public function getEndpoint(): string {
        return $this->endpoint;
    }

    public function __isset(string $name): bool {
        return (isset($this->attributes[$name]) && null !== $this->attributes[$name]);
    }
}
