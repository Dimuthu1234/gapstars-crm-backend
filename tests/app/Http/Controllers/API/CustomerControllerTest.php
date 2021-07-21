<?php


namespace Tests\App\Http\Controllers\API;

use Domain\User\Actions\CreateCustomerAction;
use Domain\User\Actions\DeleteCustomerAction;
use Domain\User\Actions\EditCustomerAction;
use Domain\User\DataTransferObjects\CustomerFormData;
use Domain\User\Models\Customer;
use Tests\TestCase;
use Domain\User\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function can_store_customer()
    {
        $this->actingAs(User::factory()->create());

        $this->mock(CreateCustomerAction::class)
            ->expects('__invoke')
            ->with(CustomerFormData::class);

        $response = $this->postJson(route('customer.store'), [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
        ]);

        $response->assertOk();
    }

    /** @test */
    public function cannot_store_customer_without_providing_any_information_of_customer()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->postJson(route('customer.store'));

        $response->assertStatus(422);
    }

    /** @test */
    public function unauthenticated_user_cannot_store_customer()
    {
        $response = $this->postJson(route('customer.store'), [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
        ]);

        $response->assertUnauthorized();
    }

    /** @test */
    public function can_delete_customer()
    {
        $this->actingAs(User::factory()->create());
        $customer = Customer::factory()->create();

        $this->mock(DeleteCustomerAction::class)
            ->expects('__invoke')
            ->with(Customer::class);

        $response = $this->deleteJson(route('customer.destroy', $customer));

        $response->assertNoContent();
    }

    /** @test */
    public function can_edit_customer()
    {
        $this->actingAs(User::factory()->create());
        $customer = Customer::factory()->create();

        $this->mock(EditCustomerAction::class)
            ->expects('__invoke')
            ->with(Customer::class, CustomerFormData::class);

        $response = $this->putJson(route('customer.update', $customer), [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
        ]);

        $response->assertOk();
    }
}
