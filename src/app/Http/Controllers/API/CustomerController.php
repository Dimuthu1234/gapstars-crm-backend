<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerFormRequest;
use App\Http\Requests\UpdateCustomerFormRequest;
use App\Http\Resources\CustomerCollection;
use Domain\User\Actions\CreateCustomerAction;
use Domain\User\Actions\DeleteCustomerAction;
use Domain\User\Actions\EditCustomerAction;
use Domain\User\DataTransferObjects\CustomerFormData;
use Domain\User\DataTransferObjects\PhoneNumberFormData;
use Domain\User\Models\Customer;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return CustomerCollection
     */
    public function index(Request $request): CustomerCollection
    {
        $customers = Customer::query()
            ->with(['phoneNumbers'])
            ->whereSearch($request->get('search'))
            ->get();
        return new CustomerCollection($customers);
    }

    /**
     * Store Customer data.
     *
     * @param CustomerFormRequest $customerFormRequest
     * @param CreateCustomerAction $createCustomerAction
     *
     * @return JsonResponse
     *
     */
    public function store(
        CustomerFormRequest $customerFormRequest,
        CreateCustomerAction $createCustomerAction
    ) {
        try {
            return response()->json(
                $createCustomerAction(
                    new CustomerFormData(
                        firstName: $customerFormRequest->first_name,
                        lastName: $customerFormRequest->last_name,
                        email: $customerFormRequest->email,
                        phoneNumbers: $customerFormRequest->phone_numbers
                        ? array_map(fn ($phoneNumber) => new PhoneNumberFormData(
                            customerId: null,
                            number: $phoneNumber['value'],
                        ), $customerFormRequest->phone_numbers)
                        : null,
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
     * @param UpdateCustomerFormRequest $updateCustomerFormRequest
     * @param Customer $customer
     * @param EditCustomerAction $editCustomerAction
     *
     * @return JsonResponse
     */
    public function update(
        UpdateCustomerFormRequest $updateCustomerFormRequest,
        Customer $customer,
        EditCustomerAction $editCustomerAction,
    ) {
        try {
            return response()->json(
                $editCustomerAction(
                    $customer,
                    new CustomerFormData(
                        firstName: $updateCustomerFormRequest->first_name,
                        lastName: $updateCustomerFormRequest->last_name,
                        email: $updateCustomerFormRequest->email,
                        phoneNumbers: $updateCustomerFormRequest->phone_numbers
                        ? array_map(fn ($phoneNumber) => new PhoneNumberFormData(
                            customerId: null,
                            number: $phoneNumber['value'],
                        ), $updateCustomerFormRequest->phone_numbers)
                        : null,
                    )
                ),
                200
            );
        } catch (UnknownProperties | Exception $exception) {
            return response()
                ->json(['error' => $exception->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Customer $customer
     * @param DeleteCustomerAction $deleteCustomerAction
     *
     * @return Response
     *
     * @throws Exception
     */
    public function destroy(Customer $customer, DeleteCustomerAction $deleteCustomerAction)
    {
        $deleteCustomerAction($customer);

        return response()->noContent();
    }
}
