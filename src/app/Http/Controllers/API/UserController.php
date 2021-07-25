<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportCsvRequest;
use App\Http\Requests\UpdateUserFormRequest;
use App\Http\Requests\UserFormRequest;
use App\Http\Resources\UserCollection;
use Domain\User\Actions\CreateUserAction;
use Domain\User\Actions\DeleteUserAction;
use Domain\User\Actions\EditUserAction;
use Domain\User\Actions\ImportUserCsvAction;
use Domain\User\DataTransferObjects\UserFormData;
use Domain\User\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return UserCollection
     */
    public function index()
    {
        $users = User::query()
            ->whereSearch(request('search'))
            ->get();
        return new UserCollection($users);
    }

    /**
     * Display a listing of the resource.
     *
     * @return UserCollection
     */
    public function allUsers()
    {
        $users = User::query()
            ->whereSearch(request('search'))
            ->get();
        return new UserCollection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserFormRequest $userFormRequest
     * @param CreateUserAction $createUserAction
     * @return JsonResponse
     * @throws Exception
     */
    public function store(
        UserFormRequest $userFormRequest,
        CreateUserAction $createUserAction
    ) {
        try {
            return response()->json(
                $createUserAction(
                    new UserFormData(
                        name: $userFormRequest->name,
                        email: $userFormRequest->email,
                        password: $userFormRequest->password
                    )
                ),
                Response::HTTP_CREATED
            );
        } catch (UnknownProperties | Exception $exception) {
            return response()
                ->json(['error' => $exception->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserFormRequest $updateUserFormRequest
     * @param User $user
     * @param EditUserAction $editUserAction
     *
     * @return JsonResponse
     */
    public function update(
        UpdateUserFormRequest $updateUserFormRequest,
        User $user,
        EditUserAction $editUserAction
    ) {
        try {
            return response()->json(
                $editUserAction(
                    $user,
                    new UserFormData(
                        name: $updateUserFormRequest->name,
                        email: $updateUserFormRequest->email,
                        password: $updateUserFormRequest->password
                    )
                ),
                Response::HTTP_OK
            );
        } catch (UnknownProperties | Exception $exception) {
            return response()
                ->json(['error' => $exception->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @param DeleteUserAction $deleteUserAction
     *
     * @return Response
     *
     * @throws Exception
     */
    public function destroy(User $user, DeleteUserAction $deleteUserAction)
    {
        $deleteUserAction($user);

        return response()->noContent();
    }

    /**
     * Converting CSV file to Array
     * @param string $filename
     * @param string $delimiter
     *
     * @return array|false
     */
    public function csvToArray(string $filename = '', string $delimiter = ','): bool|array
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        return $data;
    }

    /**
     * Check if ALL needles exist
     *
     * @param $needles
     * @param $haystack
     *
     * @return bool
     */
    public function inArrayAll($needles, $haystack): bool
    {
        return empty(array_diff($needles, $haystack));
    }

    /**
     * Import CSV data to User
     *
     * @param ImportCsvRequest $importCsvRequest
     * @param User $user
     * @param ImportUserCsvAction $importUserCsvAction
     *
     * @return JsonResponse
     */
    public function importCsvUserData(
        ImportCsvRequest $importCsvRequest,
        User $user,
        ImportUserCsvAction $importUserCsvAction,
    ): JsonResponse {
        try {
            $userData = $this->csvToArray($importCsvRequest->file('csv_file'));
            $arrayKeys = array_keys($userData);

            if (!$this->inArrayAll(
                ['name', 'email', 'password', 'dob', 'telephone', 'town', 'country'],
                $arrayKeys
            )) {
                return response()->json(
                    ['error' => 'csv does not exists required headers'],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            return response()->json(
                $importUserCsvAction(
                    $user,
                    new UserFormData(
                        name: $userData['name'],
                        email: $userData['email'],
                        password: $userData['password'],
                        dateOfBirth: $userData['dob'],
                        telephone: $userData['telephone'],
                        town: $userData['town'],
                        country: $userData['country']
                    )
                ),
                Response::HTTP_OK
            );
        } catch (UnknownProperties | Exception $exception) {
            return response()
                ->json(['error' => $exception->getMessage()]);
        }
    }
}
