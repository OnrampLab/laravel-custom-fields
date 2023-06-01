<?php

namespace OnrampLab\CustomFields\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OnrampLab\CustomFields\Database\Factories\CustomFieldValueFactory;

class CustomFieldValue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'custom_field_id',
        'value',
        'customizable_id',
        'customizable_type',
    ];

    protected static function newFactory(): Factory
    {
        return CustomFieldValueFactory::new();
    }

    public function customField(): BelongsTo
    {
        return $this->belongsTo(CustomField::class);
    }
}
