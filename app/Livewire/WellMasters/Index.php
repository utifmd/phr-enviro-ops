<?php

namespace App\Livewire\WellMasters;

use App\Service\Contracts\IWellService;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    private IWellService $service;

    #[\Livewire\Attributes\Session]
    #[Validate('required|string|min:2')]
    public $querySearch;

    public function booted(IWellService $service): void
    {
        $this->service = $service;
    }

    public function search(): void
    {
        $this->service->pagedWellMaster($this->querySearch);
    }

    public function delete(string $wellMasterId): void
    {
        $this->service->removeWellMasterBy($wellMasterId);

        $this->redirectRoute('well-masters.index', navigate: true);
    }

    /*public function onWellNamePressed(WellMaster $wellMaster): void
    {
        Session::put(WellMaster::WELL_MASTER_NAME, $wellMaster);
        Session::save();

        $this->redirectRoute('posts.create', navigate: true);
    }*/

    #[Layout('layouts.app')]
    public function render(): View
    {
        $wellMasters = $this->service->pagedWellMaster($this->querySearch);

        return view('livewire.well-master.index', compact('wellMasters'))
            ->with('i', $this->getPage() * $wellMasters->perPage());
    }
}
