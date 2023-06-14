<?php

namespace OnrampLab\CustomFields\Models;

use Carbon\Carbon;
use Parental\HasParent;

class DateTimeCustomField extends CustomField
{
    use HasParent;

    public function getValidationRule(): array
    {
        return [
            $this->key => ['date'],
        ];
    }
    public function parseValue($value): string
    {
        return Carbon::parse($value)->toDateTimeString();
    }
}
