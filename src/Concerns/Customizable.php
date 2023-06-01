<?php

namespace OnrampLab\CustomFields\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use OnrampLab\CustomFields\Models\CustomField;
use OnrampLab\CustomFields\Models\CustomFieldValue;
use OnrampLab\CustomFields\Observers\ModelObserver;

/**
 * @mixin Model
 */
trait Customizable
{
    protected ?array $validatedCustomFieldValues = [];

    public static function bootCustomizable(): void
    {
        static::observe(ModelObserver::class);
    }

    /**
     * Retrieve model's custom field values
     */
    public function customFieldValues(): MorphMany
    {
        return $this->morphMany(CustomFieldValue::class, 'customizable');
    }

    /**
     * Validate custom field values
     */
    public function validateCustomFields(): void
    {
        $customFields = $this->getCustomFields();
        if ($customFields->isEmpty()) {
            return;
        }
        $tableColumns = $this->getTableColumns();
        $modelAttributes = Collection::make($this->getAttributes());
        $modelAttributeKeys = $modelAttributes->keys();
        $customFieldColumns = $modelAttributeKeys->diff($tableColumns);
        $customFieldsRules = $customFields->flatMap(function (CustomField $field) {
            return $field->getValidationRule();
        })->all();

        $customFieldValues = $modelAttributes->only($customFieldColumns)->toArray();
        $validator = Validator::make($customFieldValues, $customFieldsRules);
        $this->validatedCustomFieldValues = $validator->validate();
        $this->setRawAttributes($modelAttributes->only($tableColumns)->toArray());
    }

    protected function getTableColumns(): Collection
    {
        return Collection::make(Schema::getColumnListing($this->getTable()));
    }

    public function getCustomFields(): Collection
    {
        $context = $this->getContext();
        $query = CustomField::query();
        if (is_null($context)) {
            $customFields = $query->get();
        } else {
            $customFields = $query
                ->where('contextable_type', get_class($context))
                ->where('contextable_id', $context->id)
                ->get();
        }

        return $customFields;
    }

    public function getContext(): ?Model
    {
        return null;
    }

    public function saveCustomFieldValues(): void
    {
        $validatedCustomFieldValues = $this->validatedCustomFieldValues;
        if (empty($validatedCustomFieldValues)) {
            return;
        }
        $customFields = $this->getCustomFields();
        $customFields->each(function ($customField) use ($validatedCustomFieldValues) {
            if (array_key_exists($customField->key, $validatedCustomFieldValues)) {
                $value = $validatedCustomFieldValues[$customField->key];
                $constraints = [
                    'custom_field_id' => $customField->id,
                    'customizable_type' => get_class($this),
                    'customizable_id' => $this->id
                ];
                $values = ['value' => $value];
                CustomFieldValue::updateOrCreate($constraints, $values);
            }
        });
    }
}
