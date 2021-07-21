<?php

namespace Domain\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Photo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file_name',
        'customer_id',
    ];

    /**
     * Get the content customer that own this photo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get path of the photo.
     *
     * @return string
     */
    public function path()
    {
        return 'customer/profile/'.$this->file_name;
    }
}
