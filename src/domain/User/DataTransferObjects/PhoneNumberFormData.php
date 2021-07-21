<?php

namespace Domain\User\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class PhoneNumberFormData extends DataTransferObject
{
    /**
     * File name of the photo.
     *
     * @var integer|null
     */
    public $customerId;

    /**
     * File name of the photo.
     *
     * @var string
     */
    public $number;
}
