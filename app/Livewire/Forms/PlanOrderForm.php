<?php

namespace App\Livewire\Forms;

use App\Models\PlanOrder;
use Livewire\Form;

class PlanOrderForm extends Form
{
    public ?PlanOrder $planOrder;

    public $status = '';
    public $description = '';
    public $req_qty = '';
    public $rem_qty = '';
    public $sch_qty = '';
    public $uom = '';
    public $required_date = '';
    public $pick_up_from = '';
    public $destination = '';
    public $wr_number = '';
    public $rig_name = '';
    public $pic = '';
    public $charge = '';
    public $post_id = '';
    public $yard = '';
    public $trip = '';

    public function rules(): array
    {
        return [
            'status' => 'required|string',
            'description' => 'required|string',
            'req_qty' => 'required|integer',
            'rem_qty' => 'required|integer',
            'sch_qty' => 'required|integer',
            'uom' => 'required|string',
            'required_date' => 'required|date',
            'pick_up_from' => 'required|string',
            'destination' => 'required|string',
            'wr_number' => 'required|string',
            'rig_name' => 'required|string',
            'pic' => 'required|string',
            'charge' => 'required|string',
            'post_id' => 'required|',
            'yard' => 'required|string',
            'trip' => 'required|integer',
        ];
    }

    public function setPlanOrder(PlanOrder $planOrder): void
    {
        $this->planOrder = $planOrder;

        $this->status = $this->planOrder->status;
        $this->description = $this->planOrder->description;
        $this->req_qty = $this->planOrder->req_qty;
        $this->rem_qty = $this->planOrder->rem_qty;
        $this->sch_qty = $this->planOrder->sch_qty;
        $this->uom = $this->planOrder->uom;
        $this->required_date = $this->planOrder->required_date;
        $this->pick_up_from = $this->planOrder->pick_up_from;
        $this->destination = $this->planOrder->destination;
        $this->wr_number = $this->planOrder->wr_number;
        $this->rig_name = $this->planOrder->rig_name;
        $this->pic = $this->planOrder->pic;
        $this->charge = $this->planOrder->charge;
        $this->post_id = $this->planOrder->post_id;
        $this->yard = $this->planOrder->yard;
        $this->trip = $this->planOrder->trip;
    }

    public function store(): void
    {
        $this->planOrder->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->planOrder->update($this->validate());
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function setUom(string $uom): void
    {
        $this->uom = $uom;
    }

    public function setYard(string $yard): void
    {
        $this->yard = $yard;
    }

    public function onSchQtyChange(): void
    {
        $this->trip = $this->sch_qty;
    }
}
