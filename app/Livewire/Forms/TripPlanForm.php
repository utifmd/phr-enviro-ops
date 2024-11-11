<?php

namespace App\Livewire\Forms;

use App\Models\TripPlan;
use Illuminate\Support\Collection;
use Livewire\Form;

class TripPlanForm extends Form
{
    public Collection $tripPlans;
    public ?TripPlan $tripPlanModel;

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
			'trip_type' => 'string',
			'job_ticket_number' => 'string',
			'post_id' => 'required|string',
        ];
    }

    public function setTripPlanModel(TripPlan $tripPlanModel): void
    {
        $this->tripPlanModel = $tripPlanModel;

        $this->start_from = $this->tripPlanModel->start_from;
        $this->finish_to = $this->tripPlanModel->finish_to;
        $this->trip_type = $this->tripPlanModel->trip_type;
        $this->actual_start = $this->tripPlanModel->actual_start;
        $this->actual_finish = $this->tripPlanModel->actual_finish;
        $this->km_start = $this->tripPlanModel->km_start;
        $this->km_end = $this->tripPlanModel->km_end;
        $this->km_actual = $this->tripPlanModel->km_actual;
        $this->km_contract = $this->tripPlanModel->km_contract;
        $this->start_working_date = $this->tripPlanModel->start_working_date;
        $this->end_working_date = $this->tripPlanModel->end_working_date;
        $this->total_standby_hour = $this->tripPlanModel->total_standby_hour;
        $this->total_working_hour = $this->tripPlanModel->total_working_hour;
        $this->job_ticket_number = $this->tripPlanModel->job_ticket_number;
        $this->post_id = $this->tripPlanModel->post_id;
    }

    public function store(): void
    {
        $this->tripPlanModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->tripPlanModel->update($this->validate());

        $this->reset();
    }

    public function setTripPlans(Collection $tripPlans): void
    {
        $this->tripPlans = $tripPlans;
    }
}
