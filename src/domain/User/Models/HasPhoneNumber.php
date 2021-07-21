<?php

namespace Domain\User\Models;

use Illuminate\Support\Facades\Storage;
use Domain\User\DataTransferObjects\PhoneNumberFormData;

trait HasPhoneNumber
{
    /**
     * define relationship to the phone numbers.
     *
     * @return mixed
     */
    public function phoneNumbers()
    {
        return $this->hasMany(PhoneNumber::class, 'customer_id');
    }

    /**
     * save phone numbers in the database.
     *
     * @param PhoneNumberFormData $phoneNumberData
     */
    public function savePhoneNumber($phoneNumberData)
    {
        foreach ($phoneNumberData as $phoneNumber) {
            $this->phoneNumbers()->create([
                'customer_id' => $this->id,
                'number' => $phoneNumber->number
            ]);
        }
    }

    /**
     * Delete all phone numbers
     */
    public function deletePhoneNumbers()
    {
        foreach ($this->phoneNumbers as $phoneNumber) {
            $phoneNumber->delete();
        }
    }
}
