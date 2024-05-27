<?php

declare(strict_types=1);

namespace App\Traits;

use App\Helpers\PaginateCollection;
use Illuminate\Support\Facades\Auth;

trait IndexResourceTrait
{
    public function indexResource($model, $resource, $filters = [])
    {
        $data = $model::query();
        // Decide whether to include deleted items based on 'includeDeleted' filter
        if (isset($filters['includeDeleted'])) {
            if ($filters['includeDeleted'] === 'only') {
                $data->onlyTrashed();  // Only trashed items
            } elseif ($filters['includeDeleted'] === 'with') {
                $data->withTrashed();  // Both trashed and non-trashed items
            }
            unset($filters['includeDeleted']); // Remove 'includeDeleted' from filters to avoid misinterpretation
        } else {
            $data->whereNull('deleted_at'); // Default to excluding trashed items if no 'includeDeleted' is set
        }
        // Handling 'whereNot' conditions first
        if (isset($filters['whereNot'])) {
            foreach ($filters['whereNot'] as $field => $value) {
                $data->where($field, '!=', $value);
            }
            unset($filters['whereNot']); // Remove 'whereNot' from filters to avoid misinterpretation
        }
        if (isset($filters['with'])) {
            $data->with($filters['with']);
            unset($filters['with']);  // Remove 'with' from filters to avoid conflicts
        }
        // Apply role-based filters if not a super admin
        if (!Auth::user()->hasRole('Super Admin')) {
            foreach ($filters as $column => $value) {
                if (!in_array($column, ['with', 'orderBy'])) {  // Exclude 'with' and 'orderBy' from role-based filtering
                    $data->where($column, $value);
                }
            }
        }
        // If an 'orderBy' filter is provided, apply it for sorting
        if (isset($filters['orderBy'])) {
            $data->orderBy($filters['orderBy']['field'], $filters['orderBy']['direction']);
        } else {
            // Default sorting by 'created_at' if no 'orderBy' is specified
            $data->orderBy('created_at', 'asc');
        }

        $data = $model::appendToQueryFromRequestQueryParameters($data);

        return request('paginate') === 'false' ? $resource::collection($data->get()) :
            $resource::collection(
                PaginateCollection::paginate(
                    results: $data->get(),
                    page: request('page', 1),
                    showPerPage: request('perPage', 15)
                )
            )->response()->getData();
    }
}