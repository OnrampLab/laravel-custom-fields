<?php

namespace OnrampLab\CustomFields\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use OnrampLab\CustomFields\Models\CustomField;

class CustomFieldFactory extends Factory
{
    protected $model = CustomField::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'friendly_name' => $this->faker->word(),
            'key' => $this->faker->slug(),
            'type' => $this->faker->randomElement(['text', 'integer']),
            'available_options' => [],
            'required' => $this->faker->boolean(),
            'default_value' => $this->faker->optional()->word,
            'description' => $this->faker->optional()->paragraph,
            'model_class' => $this->faker->word(),
            'contextable_id' => $this->faker->randomNumber(),
            'contextable_type' => $this->faker->word(),
        ];
    }
}
