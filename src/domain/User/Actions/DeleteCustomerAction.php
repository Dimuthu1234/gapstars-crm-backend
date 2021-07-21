<?php

namespace Domain\User\Actions;

use Exception;
use Domain\User\Models\Customer;
use Illuminate\Support\Facades\DB;

class DeleteCustomerAction
{
    /**
     * Action of deleting customer.
     *
     * @param Customer $customer
     *
     * @throws Exception
     */
    public function __invoke(Customer $customer)
    {
        try {
            DB::beginTransaction();

            $customer->deletePhoneNumbers();

            $customer->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
