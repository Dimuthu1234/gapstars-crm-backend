<?php

namespace Domain\User\DataTransferObjects;

use Carbon\Carbon;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;
use Support\Casters\DateCaster;

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

    /**
     * confirm password of the user.
     *
     * @var Carbon|null
     */
    #[CastWith(DateCaster::class)]
    public ?Carbon $dateOfBirth;

    /**
     * confirm password of the user.
     *
     * @var string|null
     */
    public ?string $telephone;

    /**
     * confirm password of the user.
     *
     * @var string|null
     */
    public ?string $town;

    /**
     * confirm password of the user.
     *
     * @var string|null
     */
    public ?string $country;
}
