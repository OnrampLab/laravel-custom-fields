<?php

namespace OnrampLab\CustomFields\Models;

use Parental\HasParent;

class TextCustomField extends CustomField
{
    use HasParent;

    public function getValidationRule(): array
    {
        $rules = ['string'];
        $rules[] = $this->required ? 'required' : 'nullable';
        return [
            $this->key => $rules,
        ];
    }

    public function parseValue($value): string
    {
        return $value;
    }
}
