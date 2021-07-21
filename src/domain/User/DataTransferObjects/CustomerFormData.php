<?php

namespace Domain\User\DataTransferObjects;

use Carbon\Carbon;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;
use Support\Casters\DateCaster;

class CustomerFormData extends DataTransferObject
{
    /**
     * Description of the post.
     *
     * @var string|null
     */
    public ?string $firstName;

    /**
     * Description of the post.
     *
     * @var string|null
     */
    public ?string $lastName;

    /**
     * Description of the post.
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
