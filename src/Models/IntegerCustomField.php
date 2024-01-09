<?php

namespace OnrampLab\CustomFields\Models;

use Parental\HasParent;

class IntegerCustomField extends CustomField
{
    use HasParent;

    public function getValidationRule(): array
    {
        $rules = ['integer'];
        $rules[] = $this->required ? 'required' : 'nullable';
        return [
            $this->key => $rules,
        ];
    }

    public function parseValue($value): int
    {
        return (int) $value;
    }

}
