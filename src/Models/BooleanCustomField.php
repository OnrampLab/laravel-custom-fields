<?php

namespace OnrampLab\CustomFields\Models;

use Parental\HasParent;

class BooleanCustomField extends CustomField
{
    use HasParent;

    public function getValidationRule(): array
    {
        return [
            $this->key => ['boolean'],
        ];
    }
}
