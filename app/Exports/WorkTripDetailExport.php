<?php

namespace App\Exports;

use App\Repositories\Contracts\IWorkTripRepository;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\{FromView, ShouldAutoSize};

class WorkTripDetailExport implements FromView, ShouldAutoSize
{
    public IWorkTripRepository $wtRepos;
    public string $date, $type;
    public function __construct(
        IWorkTripRepository $wtRepos, string $type, string $date)
    {
        $this->wtRepos = $wtRepos;
        $this->date = $date;
        $this->type = $type;
    }
    /**
     * @inheritDoc
     */
    public function view(): View
    {
        $type = $this->type;
        $date = $this->date;
        $workTripDetails = $this->wtRepos->detailBuilder($date)->where('type', $type)->get();

        return view('livewire.work-trip-detail.tabled', compact('workTripDetails', 'type', 'date'));
    }
}
