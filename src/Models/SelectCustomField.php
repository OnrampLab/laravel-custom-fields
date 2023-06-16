<?php

namespace OnrampLab\CustomFields\Models;

use Illuminate\Validation\Rule;
use Parental\HasParent;

class SelectCustomField extends CustomField
{
    use HasParent;

    public function getValidationRule(): array
    {
        $options = $this->available_options->pluck('value')->toArray();
        return [
            $this->key => [Rule::in($options)]
        ];
    }
    public function parseValue($value): string
    {
        return $value;
    }
}
