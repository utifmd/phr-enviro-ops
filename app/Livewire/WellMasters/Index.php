<?php

namespace App\Livewire\WellMasters;

use App\Service\Contracts\IWellService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected IWellService $service;
    protected LengthAwarePaginator $wellMaters;

    #[\Livewire\Attributes\Session]
    public $querySearch;

    public function boot(IWellService $service): void
    {
        $this->service = $service;
    }

    public function mount(): void
    {
        $this->wellMaters = $this->service->pagedWellMaster($this->querySearch);
    }

    public function hydrate(): void
    {
        $this->mount();
    }

    public function search(): void
    {
        $this->wellMaters = $this->service->pagedWellMaster($this->querySearch);
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
        $wellMasters = $this->wellMaters;

        return view('livewire.well-master.index', compact('wellMasters'))
            ->with('i', $this->getPage() * $wellMasters->perPage());
    }
}
