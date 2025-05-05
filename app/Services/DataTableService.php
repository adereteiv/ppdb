<?php

namespace App\Services;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class DataTableService
{
    /**
     * Create a new class instance.
     */
    public function initDataTable(Request $request, Builder $query, array $allowedSorts, ?Closure $searchCallback = null, ?Closure $sortCallback = null)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $sort = $request->input('sort', $allowedSorts[0]);
        $sort = in_array($sort, $allowedSorts) ? $sort : $allowedSorts[0];

        $order = $request->input('order', 'desc');
        $order = in_array($order, ['asc', 'desc']) ? $order : 'desc';

        if ($search && $searchCallback) {
            $searchCallback($query, $search);
        }

        if ($sortCallback) {
            $sortCallback($query, $sort, $order);
        } else {
            $query->orderBy($sort, $order); // fallback
        }

        return $query->paginate($perPage)->appends($request->all());
    }
}
