<?php

namespace Tests\Domain\User\Actions;

use Domain\User\Actions\CreateCustomerAction;
use Domain\User\DataTransferObjects\CustomerFormData;
use Domain\User\Models\Customer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateCustomerActionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test
     *
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function customer_can_create_text_content_successfully()
    {
        $customerData = new CustomerFormData(
            firstName: $this->faker->firstName,
            lastName: $this->faker->lastName,
            email: $this->faker->email,
        );

        app(CreateCustomerAction::class)($customerData);

        $this->assertCount(1, Customer::all());
    }
}
