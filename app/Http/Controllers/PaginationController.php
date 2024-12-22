<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;


class PaginationController extends Controller
{
    public static function paginate( array $data, int $pages = 3 ){
        
        $currentPage = request('page',1);
        $perPage =$pages;
        $items = collect($data);

        return new LengthAwarePaginator(
            $items->forPage($currentPage,$perPage),
            $items->count(),
            $perPage,
            $currentPage,
            ['path'=> request()->url(), 'query'=> request()->query()]
        );

    }
}
