<?php

namespace Domain\User\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

/**
 * @template T of Post
 * @extends Builder<T>
 */
class CustomerQueryBuilder extends Builder
{
    /**
     * Query search box for customers.
     *
     * @param $request
     *
     * @return $this
     */
    public function whereSearch($request): self
    {
        return $this->with('phoneNumbers')
            ->where(
                fn ($query) => $query->where('first_name', 'Like', '%'.$request.'%')
                ->orWhere('last_name', 'Like', '%'.$request.'%')
                ->orWhere('email', 'Like', '%'.$request.'%')
                ->orWhereHas(
                    'phoneNumbers',
                    fn ($query) => $query->where('number', 'Like', '%'.$request.'%')
                )
            );
    }
}
