<?php

namespace App\Livewire\WorkTripInDetails;

use App\Models\WorkTripInDetail;
use App\Utils\Constants;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
/* TODO:
 * 1.
 * */
class Index extends Component
{
    use WithPagination;
    protected LengthAwarePaginator $inDetailsByArea;
    public string $date;
    public function mount(): void
    {
        $this->date = date('Y-m-d');
        $this->inDetailsByArea = $this->inDetailsBuilderBy()->paginate();
    }
    public function onDateChange(): void
    {
        $this->inDetailsByArea = $this->inDetailsBuilderBy($this->date)->paginate();
    }
    private function inDetailsBuilderBy(?string $date = null): Builder
    {
        $builder = WorkTripInDetail::query();

        if (!is_null($date)) {
            $builder->whereBetween('created_at', [
                Carbon::parse($date)->startOfDay(),
                Carbon::parse($date)->endOfDay(),
            ]);
        }
        return $builder
            ->where('area_name', auth()->user()->area_name)
            ->orderByDesc('created_at');
    }
    public function delete(WorkTripInDetail $workTripDetail): void
    {
        $workTripDetail->delete();

        $this->redirectRoute('work-trip-in-details.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        $workTripDetails = $this->inDetailsByArea;

        return view('livewire.work-trip-in-detail.index', compact('workTripDetails'))
            ->with('i', $this->getPage() * $workTripDetails->perPage());
    }
}
