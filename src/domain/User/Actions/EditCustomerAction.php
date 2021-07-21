<?php

namespace Domain\User\Actions;

use App\Http\Resources\CustomerResource;
use Domain\User\Models\Customer;
use Exception;
use Illuminate\Support\Facades\DB;
use Domain\User\DataTransferObjects\CustomerFormData;

class EditCustomerAction
{
    /**
     * Update customer action.
     *
     * @param Customer $customer
     * @param CustomerFormData $customerFormData
     *
     * @return CustomerResource
     *
     * @throws Exception
     */
    public function __invoke(
        Customer $customer,
        CustomerFormData $customerFormData
    ): CustomerResource {
        try {
            DB::beginTransaction();

            $customer->first_name = $customerFormData->firstName;
            $customer->last_name = $customerFormData->lastName;
            $customer->email = $customerFormData->email;

            $customer->save();

            $customer->deletePhoneNumbers();

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
