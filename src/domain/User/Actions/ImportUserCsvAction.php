<?php

namespace Domain\User\Actions;

use App\Http\Resources\UserResource;
use Domain\User\DataTransferObjects\UserFormData;
use Domain\User\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ImportUserCsvAction
{
    /**
     * Update user action.
     *
     * @throws Exception
     */
    public function __invoke(
        User $user,
        UserFormData $userFormData
    ): UserResource {
        try {
            DB::beginTransaction();

            $user->name = $userFormData->name;
            $user->email = $userFormData->email;
            $user->password = Hash::make($userFormData->password);
            $user->dob = $userFormData->dateOfBirth;
            $user->telephone = $userFormData->telephone;
            $user->town = $userFormData->town;
            $user->country = $userFormData->country;

            $user->save();

            DB::commit();

            return new UserResource($user);
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
