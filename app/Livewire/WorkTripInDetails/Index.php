<?php

namespace App\Livewire\WorkTripInDetails;

use App\Models\WorkTripDetail;
use App\Models\WorkTripDetailIn;
use App\Utils\ActNameEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
class Index extends Component
{
    use WithPagination;
    protected LengthAwarePaginator $detailsByArea;
    public string $date;

    public function mount(): void
    {
        $this->date = date('Y-m-d');
        $this->initWorkTripDetails();
    }

    public function hydrate(): void
    {
        $this->initWorkTripDetails();
    }

    private function initWorkTripDetails(): void
    {
        $this->detailsByArea = $this->detailsBuilderBy($this->date)->paginate();
    }
    private function detailsBuilderBy(?string $date = null): Builder
    {
        $builder = WorkTripDetail::query();

        if (!is_null($date)) {
            $builder->whereBetween('created_at', [
                Carbon::parse($date)->startOfDay(),
                Carbon::parse($date)->endOfDay(),
            ]);
        }
        $userAreaName = auth()->user()->area_name;
        return $builder
            ->where('type', ActNameEnum::Incoming->value)
            ->where('area_name', $userAreaName)
            ->orderByDesc('created_at');
    }
    public function onDateChange(): void
    {
        $this->initWorkTripDetails();
    }
    public function delete(WorkTripDetailIn $workTripDetail): void
    {
        $workTripDetail->delete();

        $this->redirectRoute('work-trip-in-details.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        $workTripDetails = $this->detailsByArea;

        return view('livewire.work-trip-in-detail.index', compact('workTripDetails'))
            ->with('i', $this->getPage() * $workTripDetails->perPage());
    }
}
