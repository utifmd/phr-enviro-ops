<?php

namespace App\Livewire\Workorders;

use App\Service\Contracts\IWellService;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class WorkRequest extends Component
{
    use WithPagination;
    private IWellService $service;
    public ?string $idsWellName = null;

    public function booted(IWellService $service): void
    {
        $this->service = $service;
    }

    public function mount(?string $idsWellName = null): void
    {
        $this->idsWellName = $idsWellName;
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        $posts = $this->service->pagedWellPost(true, $this->idsWellName);

        $initialData = [
            'posts' => $posts, 'idsWellName' => $this->idsWellName
        ];
        return view('livewire.post.index', $initialData)
            ->with('i', $posts->perPage() * $this->getPage());
    }
}
