<?php

namespace Domain\User\Actions;

use App\Http\Resources\CustomerResource;
use Domain\User\Models\Customer;
use Exception;
use Illuminate\Support\Facades\DB;
use Domain\User\DataTransferObjects\CustomerFormData;

class CreateCustomerAction
{
    /**
     * Store customer action.
     *
     * @param CustomerFormData $customerFormData
     *
     * @return CustomerResource
     *
     * @throws Exception
     */
    public function __invoke(CustomerFormData $customerFormData): CustomerResource
    {
        try {
            DB::beginTransaction();

            /** @var Customer $customer */
            $customer = Customer::create([
                'first_name' => $customerFormData->firstName,
                'last_name' => $customerFormData->lastName,
                'email' => $customerFormData->email
            ]);

            if ($customerFormData->hasPhoneNumbers()) {
                $customer->savePhoneNumber($customerFormData->phoneNumbers);
            }

            DB::commit();

            return new CustomerResource($customer);
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
