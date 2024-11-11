<?php

namespace App\Livewire\Actions;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class GetStep
{
    private Authenticatable $currentUser;
    // private int $route;

    public function __construct(?User $user = null, ?int $route = null)
    {
        $this->currentUser = $user ?? \auth()->user(); // $this->route = $route;
    }

    public function getStepAt(): int
    {
        $currentPost = $this->currentUser->currentPost ?? false;

        if (!$currentPost) return 0;
        return $currentPost->step_at ?? 0; //$stepAt;
    }

    public function getSteps(): array
    {
        $currentPost = $this->currentUser->currentPost ?? false;

        if (!$currentPost) return []; // return in_array($this->route, $doneSteps);
        return explode(";", $currentPost->steps);
    }
}
