<?php

namespace App\Livewire\Actions;

use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Support\Facades\Auth;

class GetRouteName
{
    public function __invoke(?User $currentUser = null): string
    {
        $currentUser = $currentUser ?? Auth::user(); // User::query()->find(Auth::id());

        if ($currentPost = $currentUser->currentPost ?? false) {
            return $currentPost->url;
        }
        return WorkOrder::ROUTE_NAME.'.index';
    }
}
