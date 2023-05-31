<?php

namespace OnrampLab\CustomFields\Tests\Unit\Concerns;

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
    public function custom_field_values_relationship_should_work(): void
    {
        $customFieldValues = $this->user->customFieldValues;
        $this->assertCount(1, $customFieldValues);
        $this->assertEquals($this->user->id, $customFieldValues->first()->customizable_id);
        $this->assertEquals(get_class($this->user), $customFieldValues->first()->customizable_type);
    }
}
