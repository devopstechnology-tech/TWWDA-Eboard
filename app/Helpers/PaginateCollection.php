<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class PaginateCollection
{
    public static function paginate(Collection $results, $page = 1, $showPerPage = 15): LengthAwarePaginator
    {
        $page = $page ?? Paginator::resolveCurrentPage('page');

        $totalPageNumber = $results->count();

        return self::paginator(
            $results->forPage($page, $showPerPage),
            $totalPageNumber,
            $showPerPage,
            $page,
            [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => 'page',
            ]
        );

    }

    protected static function paginator(Collection $items, $total, $perPage, $currentPage, array $options): LengthAwarePaginator
    {
        return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
            'items',
            'total',
            'perPage',
            'currentPage',
            'options'
        ));
    }
}
