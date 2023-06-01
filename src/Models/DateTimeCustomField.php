<?php

namespace OnrampLab\CustomFields\Models;

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
}
