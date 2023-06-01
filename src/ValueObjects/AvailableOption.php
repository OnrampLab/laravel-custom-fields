<?php

namespace OnrampLab\CustomFields\ValueObjects;

use JsonSerializable;

class AvailableOption implements JsonSerializable
{
    public string $name;

    public string $value;

    /**
     * create object
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->value = $data['value'];
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'value' => $this->value,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
