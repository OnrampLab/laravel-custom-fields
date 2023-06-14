<?php

namespace OnrampLab\CustomFields\Models;

use Parental\HasParent;

class BooleanCustomField extends CustomField
{
    use HasParent;

    public function getValidationRule(): array
    {
        return [
            $this->key => ['boolean'],
        ];
    }

    public function parseValue($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

}
