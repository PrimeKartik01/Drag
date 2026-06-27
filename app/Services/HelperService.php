<?php

namespace App\Services;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class HelperService
{
    public function checkPermission(string $ability, string $table)
    {
        if (!Gate::check($ability, $table)) {

            Session::flash('error', 'You are not authorized to perform this action.');

            return redirect()->route('admin.dashboard');
        }

        return null;
    }
}
