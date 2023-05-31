<?php

namespace OnrampLab\CustomFields\Models;

use Parental\HasParent;

class FloatCustomField extends CustomField
{
    use HasParent;

    public function getValidationRule(): array
    {
        return [
            $this->key => ['numeric'],
        ];
    }
}
