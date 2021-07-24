<?php

namespace Domain\User\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class CustomerFormData extends DataTransferObject
{
    /**
     * First name of the customer.
     *
     * @var string|null
     */
    public ?string $firstName;

    /**
     * Last name of the customer.
     *
     * @var string|null
     */
    public ?string $lastName;

    /**
     * Email of the customer.
     *
     * @var string|null
     */
    public ?string $email;

    /**
     * Phone numbers of the customer.
     *
     * @var PhoneNumberFormData[]|null
     */
    public ?array $phoneNumbers;

    /**
     * Indicate whether there are phone numbers in the customer.
     *
     * @return bool
     */
    public function hasPhoneNumbers(): bool
    {
        return ! empty($this->phoneNumbers);
    }
}
