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
    protected array $validatedCustomFieldValues = [];

    /**
     * Boot Model Observer.
     */
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
        $tableColumns = $this->getTableColumns();
        $modelAttributes = Collection::make($this->getAttributes());
        $this->setRawAttributes($modelAttributes->only($tableColumns)->toArray());
        if ($customFields->isEmpty()) {
            return;
        }
        $modelAttributeKeys = $modelAttributes->keys();
        $customFieldColumns = $modelAttributeKeys->diff($tableColumns);
        $customFieldsRules = $customFields->flatMap(function (CustomField $field) {
            return $field->getValidationRule();
        })->all();
        $customFieldValues = $modelAttributes->only($customFieldColumns)->toArray();
        $validator = Validator::make($customFieldValues, $customFieldsRules);
        $this->validatedCustomFieldValues = $validator->validate();
    }


    /**
     * Get the custom fields associated with the model.
     */
    public function getCustomFields(): Collection
    {
        $context = $this->getCustomFieldContext();
        $query = CustomField::query();
        $query->where('model_class', get_class($this));

        if (is_null($context)) {
            $customFields = $query->get();
        } else {
            $customFields = $query
                ->where('contextable_type', $context->getMorphClass())
                ->where('contextable_id', $context->id)
                ->get();
        }

        return $customFields;
    }

    /**
     * Get the context model associated with the model.
     */
    public function getCustomFieldContext(): ?Model
    {
        return null;
    }

    /**
     * Save the custom field values.
     */
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
                    'customizable_type' => $this->getMorphClass(),
                    'customizable_id' => $this->id
                ];
                $values = ['value' => $value];
                CustomFieldValue::updateOrCreate($constraints, $values);
            }
        });
    }

    /**
     * Load custom field values and set them as model attributes.
     */
    public function loadCustomFieldValues(): void
    {
        if (! $this->customFieldValues) {
            return;
        }

        $this->customFieldValues->each(function (CustomFieldValue $customFieldValue) {
            $attribute = $customFieldValue->customField->key;
            $this->setAttribute($attribute, $customFieldValue->customField->parseValue($customFieldValue->value));
        });
    }

    /**
     * Get the table columns of the model.
     */
    protected function getTableColumns(): Collection
    {
        return Collection::make(Schema::getColumnListing($this->getTable()));
    }
}
