<?php

namespace OnrampLab\CustomFields\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use OnrampLab\CustomFields\Models\CustomField;

/**
 * @mixin Model
 */
trait Contextable
{
    /**
     * Retrieve model's custom fields
     */
    public function customFields(): MorphMany
    {
        return $this->morphMany(CustomField::class, 'contextable');
    }
}
