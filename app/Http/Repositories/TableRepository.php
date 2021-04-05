<?php namespace App\Http\Repositories;

use Illuminate\Database\Eloquent\Builder;

class TableRepository {

    public static function paginate(Builder $query, array $pagination_options = [
        'rows_per_page' => 5,
        'page_number' => 1
    ]) {

        return $query->paginate($pagination_options['rows_per_page'], ['*'], 'page', $pagination_options['page_number']);
    }
}