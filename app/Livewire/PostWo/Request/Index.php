<?php

namespace App\Livewire\PostWo\Request;

use App\Service\Contracts\IWellService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected IWellService $service;
    public ?string $idsWellName = null;

    public function mount(?string $idsWellName = null): void
    {
        $this->idsWellName = $idsWellName;
    }

    public function booted(IWellService $service): void
    {
        $this->service = $service;
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        $posts = $this->service->pagedWellPost(true, $this->idsWellName);
        return view('livewire.post-fac-report.request.index', compact('posts'))->with(
            'i', $this->posts->perPage() * $this->getPage()
        );
    }
}
