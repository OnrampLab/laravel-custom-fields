<?php

namespace OnrampLab\CustomFields\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use OnrampLab\CustomFields\Database\Factories\CustomFieldFactory;

class CustomField extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'friendly_name',
        'field_key',
        'field_type',
        'required',
        'default_value',
        'description',
        'model',
        'context_type',
        'context_id'
    ];

    protected static function newFactory(): Factory
    {
        return CustomFieldFactory::new();
    }
}
