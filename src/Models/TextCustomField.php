<?php

namespace OnrampLab\CustomFields\Models;

use Parental\HasParent;

class TextCustomField extends CustomField
{
    use HasParent;

    public function getValidationRule(): array
    {
        return [
            $this->key => ['string'],
        ];
    }

    public function parseValue($value): string
    {
        return $value;
    }
}
