<?php

namespace OnrampLab\CustomFields\Tests\Classes;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OnrampLab\CustomFields\Concerns\Contextable;

class Account extends Model
{
    use HasFactory;
    use Contextable;

    protected $guarded = [];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    protected static function newFactory(): Factory
    {
        return AccountFactory::new();
    }
}
