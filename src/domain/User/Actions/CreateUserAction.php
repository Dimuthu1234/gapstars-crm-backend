<?php

namespace Domain\User\Actions;

use App\Http\Resources\UserResource;
use Domain\User\DataTransferObjects\UserFormData;
use Domain\User\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateUserAction
{
    /**
     * Store user action.
     *
     * @param UserFormData $userFormData
     *
     * @return UserResource
     *
     * @throws Exception
     */
    public function __invoke(UserFormData $userFormData): UserResource
    {
        try {
            DB::beginTransaction();

            /** @var User $user */
            $user = User::create([
                'name' => $userFormData->name,
                'email' => $userFormData->email,
                'password' => Hash::make($userFormData->password)
            ]);

            DB::commit();

            return new UserResource($user);
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
