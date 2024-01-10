<?php

namespace OnrampLab\CustomFields\Models;

use Carbon\Carbon;
use Parental\HasParent;

class DateTimeCustomField extends CustomField
{
    use HasParent;

    public function getValidationRule(): array
    {
        $rules = ['date'];
        $rules[] = $this->required ? 'required' : 'nullable';
        return [
            $this->key => $rules,
        ];
    }
    public function parseValue($value): string
    {
        return Carbon::parse($value)->toDateTimeString();
    }
}
