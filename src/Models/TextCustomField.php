<?php

namespace OnrampLab\CustomFields\Models;

use Parental\HasParent;

class TextCustomField extends CustomField
{
    use HasParent;

    public function getValidationRule($autoTransform = false): array
    {
        if (!$autoTransform) {
            $rules = ['string'];
        }

        $rules[] = $this->required ? 'required' : 'nullable';
        return [
            $this->key => $rules,
        ];
    }

    public function parseValue($value, $autoTransform = false): string
    {
        if ($autoTransform) {
            return (string) $value;
        }

        return $value;
    }
}
