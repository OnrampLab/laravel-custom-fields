<?php

namespace OnrampLab\CustomFields\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OnrampLab\CustomFields\AttributeCastors\AvailableOptionsCastor;
use OnrampLab\CustomFields\Database\Factories\CustomFieldFactory;
use Parental\HasChildren;

class CustomField extends Model
{
    use HasFactory;
    use HasChildren;

    public const TYPE_TEXT = 'text';
    public const TYPE_INTEGER = 'integer';
    public const TYPE_FLOAT = 'float';
    public const TYPE_DATETIME = 'datetime';
    public const TYPE_SELECT = 'select';
    public const TYPE_BOOLEAN = 'boolean';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'friendly_name',
        'key',
        'type',
        'available_options',
        'required',
        'default_value',
        'description',
        'model_class',
        'contextable_type',
        'contextable_id'
    ];

    protected $casts = [
        'required' => 'boolean',
        'available_options' => AvailableOptionsCastor::class,
    ];

    protected array $childTypes = [
        CustomField::TYPE_TEXT => TextCustomField::class,
        CustomField::TYPE_INTEGER => IntegerCustomField::class,
        CustomField::TYPE_FLOAT => FloatCustomField::class,
        CustomField::TYPE_DATETIME => DateTimeCustomField::class,
        CustomField::TYPE_SELECT => SelectCustomField::class,
        CustomField::TYPE_BOOLEAN => BooleanCustomField::class
    ];

    protected static function newFactory(): Factory
    {
        return CustomFieldFactory::new();
    }

    public function values(): HasMany
    {
        return $this->hasMany(CustomFieldValue::class);
    }

    public function getValidationRule(): array
    {
        return [];
    }

    public function parseValue($value): mixed
    {
        return $value;
    }
}
