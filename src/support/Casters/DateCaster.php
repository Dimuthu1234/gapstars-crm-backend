<?php

namespace Support\Casters;

use Carbon\Carbon;
use Spatie\DataTransferObject\Caster;

class DateCaster implements Caster
{
    /**
     * Cast value to Carbon date time object.
     *
     * @param mixed $value
     *
     * @return Carbon
     */
    public function cast(mixed $value): Carbon
    {
        return Carbon::parse($value);
    }
}
