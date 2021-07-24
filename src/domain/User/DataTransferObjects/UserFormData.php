<?php

namespace Domain\User\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class UserFormData extends DataTransferObject
{
    /**
     * name of the user.
     *
     * @var string|null
     */
    public ?string $name;

    /**
     * email of the user.
     *
     * @var string|null
     */
    public ?string $email;

    /**
     * password of the user.
     *
     * @var string|null
     */
    public ?string $password;

    /**
     * confirm password of the user.
     *
     * @var string|null
     */
    public ?string $passwordConfirmation;

    /**
     * confirm password of the user.
     *
     * @var int|null
     */
    public ?int $isAdmin;
}
