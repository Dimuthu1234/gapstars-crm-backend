<?php

namespace Domain\User\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

/**
 * @template T of Post
 * @extends Builder<T>
 */
class UserQueryBuilder extends Builder
{
    /**
     * Query search box for users.
     *
     * @param $request
     *
     * @return $this
     */
    public function whereSearch($request): self
    {
        return $this->where(
            fn ($query) => $query->where('name', 'Like', '%'.$request.'%')
                ->orWhere('email', 'Like', '%'.$request.'%')
        );
    }
}
