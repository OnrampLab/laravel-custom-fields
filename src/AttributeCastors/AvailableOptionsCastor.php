<?php

namespace OnrampLab\CustomFields\AttributeCastors;

use InvalidArgumentException;
use OnrampLab\CustomFields\Models\CustomField;
use Illuminate\Support\Collection;
use OnrampLab\CustomFields\ValueObjects\AvailableOption;

class AvailableOptionsCastor
{
    /**
     * Cast the given value.
     *
     * @param  CustomField  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return Collection<AvailableOption>
     */
    public function get($model, $key, $value, $attributes)
    {
        $data = json_decode(data_get($attributes, 'available_options') ?? '[]', true);

        return Collection::make($data)
            ->map(function (array $option) {
                return new AvailableOption($option);
            });
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  CustomField  $model
     * @param  string  $key
     * @param  Collection|array  $value
     * @param  array  $attributes
     * @return array
     */
    public function set($model, $key, $value, $attributes)
    {
        $value = Collection::make($value);
        $isValid = $value->every(function ($option) {
            return $option instanceof AvailableOption;
        });

        if (!$isValid) {
            throw new InvalidArgumentException('This given value is not an AvailableOption instance.');
        }

        return [
            'available_options' => json_encode($value->toArray()),
        ];
    }
}
