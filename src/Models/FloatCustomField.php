<?php

namespace OnrampLab\CustomFields\Models;

use Parental\HasParent;

class FloatCustomField extends CustomField
{
    use HasParent;

    public function getValidationRule(): array
    {
        $rules = ['numeric'];
        $rules[] = $this->required ? 'required' : 'nullable';
        return [
            $this->key => $rules,
        ];
    }

    public function parseValue($value): float
    {
        return (float) $value;
    }

}
