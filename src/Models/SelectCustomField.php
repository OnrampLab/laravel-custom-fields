<?php

namespace OnrampLab\CustomFields\Models;

use Illuminate\Validation\Rule;
use Parental\HasParent;

class SelectCustomField extends CustomField
{
    use HasParent;

    public function getValidationRule($autoTransform = false): array
    {
        $options = $this->available_options->pluck('value')->toArray();
        $rules = [Rule::in($options)];
        $rules[] = $this->required ? 'required' : 'nullable';
        return [
            $this->key => $rules,
        ];
    }
    public function parseValue($value, $autoTransform = false): string
    {
        return $value;
    }
}
