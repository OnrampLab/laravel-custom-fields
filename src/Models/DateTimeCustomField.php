<?php

namespace OnrampLab\CustomFields\Models;

use Carbon\Carbon;
use Parental\HasParent;

class DateTimeCustomField extends CustomField
{
    use HasParent;

    public function getValidationRule($autoTransform = false): array
    {
        $rules = ['date'];
        $rules[] = $this->required ? 'required' : 'nullable';
        return [
            $this->key => $rules,
        ];
    }
    public function parseValue($value, $autoTransform = false): string
    {
        return Carbon::parse($value)->toDateTimeString();
    }
}
