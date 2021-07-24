<?php

namespace Domain\User\Actions;

use Domain\User\Models\User;
use Exception;
use Domain\User\Models\Customer;
use Illuminate\Support\Facades\DB;

class DeleteUserAction
{
    /**
     * Action of deleting user.
     *
     * @param User $user
     */
    public function __invoke(User $user)
    {
        try {
            DB::beginTransaction();

            $user->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
