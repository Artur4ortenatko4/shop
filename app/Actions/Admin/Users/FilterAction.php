<?php

namespace App\Actions\Admin\Users;

use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class FilterAction
{
    use AsAction;

    public function handle($filters)
    {
        $query = User::query();

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['email'])) {
            $query->where('email', 'like', '%' . $filters['email'] . '%');
        }

        if (!empty($filters['role'])) {
            $query->whereIn('role', $filters['role']);
        }

        if (!empty($filters['date'])) {
            $query->whereDate('created_at', $filters['date']);
        }

        return $query;
    }
}
