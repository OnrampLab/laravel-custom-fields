<?php

namespace OnrampLab\CustomFields\Tests\Feature\Concerns;


use Illuminate\Validation\ValidationException;
use OnrampLab\CustomFields\Models\CustomField;
use OnrampLab\CustomFields\Tests\Classes\Account;
use OnrampLab\CustomFields\Tests\Classes\User;
use OnrampLab\CustomFields\Tests\TestCase;

class CustomizableTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->account = Account::factory()->create();
        $attributes = [
            'key' => 'zip_code',
            'type' => 'text',
            'model_class' => User::class,
            'contextable_id' => $this->account->id,
            'contextable_type' => get_class($this->account)
        ];
        $this->customField = CustomField::factory()->create($attributes);
        $this->user = User::factory()->create(['account_id' => $this->account->id, 'zip_code' => '12345']);
    }

    /**
     * @test
     */
    public function create_model_should_save_custom_field_value(): void
    {
        $customFieldValue = $this->user->customFieldValues()->where('custom_field_id', $this->customField->id)->first();
        $this->assertEquals($customFieldValue->value, '12345');
        $this->assertEquals($customFieldValue->custom_field_id, $this->customField->id);
        $this->assertEquals($customFieldValue->customizable_type, get_class($this->user));
        $this->assertEquals($customFieldValue->customizable_id, $this->user->id);
    }

    /**
     * @test
     */
    public function update_model_should_update_custom_field_values(): void
    {
        $attributes = ['zip_code' => '67890'];
        $this->user->fill($attributes);
        $this->user->save();
        $customFieldValue = $this->user->customFieldValues()->where('custom_field_id', $this->customField->id)->first();
        $this->assertEquals($customFieldValue->value, '67890');
        $this->assertEquals($customFieldValue->custom_field_id, $this->customField->id);
        $this->assertEquals($customFieldValue->customizable_type, get_class($this->user));
        $this->assertEquals($customFieldValue->customizable_id, $this->user->id);
    }


    /**
     * @test
     */
    public function create_user_with_invalid_custom_field_value_should_throw_exception(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The given data was invalid.');
        User::factory()->create(['account_id' => $this->account->id, 'zip_code' => 123]);
    }
}
