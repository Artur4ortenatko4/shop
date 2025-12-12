<?php

namespace App\Actions\Admin\Users;

use Lorisleiva\Actions\Concerns\AsAction;

class SortAction
{
    use AsAction;

    public function handle($request, $query)
    {
        if ($request->has('reset_sort')) {
            return $query->latest();
        }

        $sortField = $request->input('sort', 'name');
        return $query->orderBy($sortField);
    }
}
