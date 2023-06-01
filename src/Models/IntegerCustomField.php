<?php

namespace OnrampLab\CustomFields\Models;

use Parental\HasParent;

class IntegerCustomField extends CustomField
{
    use HasParent;

    public function getValidationRule(): array
    {
        return [
            $this->key => ['integer'],
        ];
    }
}
