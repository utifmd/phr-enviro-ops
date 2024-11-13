<?php

namespace App\Livewire\Forms;

use App\Models\PlanTrip;
use Illuminate\Support\Collection;
use Livewire\Form;

class PlanTripForm extends Form
{
    public ?PlanTrip $planTripModel;
    public Collection $tripPlans;

    public $start_from = '';
    public $finish_to = '';
    public $trip_type = '';
    public $actual_start = '';
    public $actual_finish = '';
    public $km_start = '';
    public $km_end = '';
    public $km_actual = '';
    public $km_contract = '';
    public $start_working_date = '';
    public $end_working_date = '';
    public $total_standby_hour = '';
    public $total_working_hour = '';
    public $job_ticket_number = '';
    public $post_id = '';

    public function rules(): array
    {
        return [
			'start_from' => 'required|string',
			'finish_to' => 'required|string',
			'trip_type' => 'required|string',
			'post_id' => 'required|string',
        ];
    }

    public function setPlanTripModel(PlanTrip $planTripModel): void
    {
        $this->planTripModel = $planTripModel;

        $this->start_from = $this->planTripModel->start_from;
        $this->finish_to = $this->planTripModel->finish_to;
        $this->trip_type = $this->planTripModel->trip_type;
        $this->actual_start = $this->planTripModel->actual_start;
        $this->actual_finish = $this->planTripModel->actual_finish;
        $this->km_start = $this->planTripModel->km_start;
        $this->km_end = $this->planTripModel->km_end;
        $this->km_actual = $this->planTripModel->km_actual;
        $this->km_contract = $this->planTripModel->km_contract;
        $this->start_working_date = $this->planTripModel->start_working_date;
        $this->end_working_date = $this->planTripModel->end_working_date;
        $this->total_standby_hour = $this->planTripModel->total_standby_hour;
        $this->total_working_hour = $this->planTripModel->total_working_hour;
        $this->job_ticket_number = $this->planTripModel->job_ticket_number;
        $this->post_id = $this->planTripModel->post_id;
    }

    public function store(): void
    {
        $this->planTripModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->planTripModel->update($this->validate());

        $this->reset();
    }

    public function setTripPlans(Collection $tripPlans): void
    {
        $this->tripPlans = $tripPlans;
    }
}
