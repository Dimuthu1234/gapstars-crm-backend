<?php

namespace Domain\User\Models;

use Domain\User\Factories\CustomerFactory;
use Domain\User\QueryBuilders\CustomerQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class Customer extends Model
{
    use HasPhoneNumber;
    use HasFactory;

    protected $guarded = [];

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param Builder $query
     *
     * @return CustomerQueryBuilder
     */
    public function newEloquentBuilder($query): CustomerQueryBuilder
    {
        return new CustomerQueryBuilder($query);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return CustomerFactory::new();
    }
}
