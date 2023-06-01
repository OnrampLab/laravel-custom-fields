<?php

namespace OnrampLab\CustomFields\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use OnrampLab\CustomFields\Models\CustomField;
use OnrampLab\CustomFields\Models\CustomFieldValue;

class CustomFieldValueFactory extends Factory
{
    protected $model = CustomFieldValue::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'custom_field_id' => CustomField::factory(),
            'value' => $this->faker->word(),
            'customizable_id' => $this->faker->randomNumber(),
            'customizable_type' => $this->faker->word(),
        ];
    }
}
