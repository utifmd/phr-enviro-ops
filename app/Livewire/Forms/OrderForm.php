<?php

namespace App\Livewire\Forms;

use App\Models\Order;
use Livewire\Form;

class OrderForm extends Form
{
    public ?Order $orderModel;

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
    public $change = '';
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
            'change' => 'required|string',
            'post_id' => 'required|',
            'yard' => 'required|string',
            'trip' => 'required|integer',
        ];
    }

    public function setOrderModel(Order $orderModel): void
    {
        $this->orderModel = $orderModel;

        $this->status = $this->orderModel->status;
        $this->description = $this->orderModel->description;
        $this->req_qty = $this->orderModel->req_qty;
        $this->rem_qty = $this->orderModel->rem_qty;
        $this->sch_qty = $this->orderModel->sch_qty;
        $this->uom = $this->orderModel->uom;
        $this->required_date = $this->orderModel->required_date;
        $this->pick_up_from = $this->orderModel->pick_up_from;
        $this->destination = $this->orderModel->destination;
        $this->wr_number = $this->orderModel->wr_number;
        $this->rig_name = $this->orderModel->rig_name;
        $this->pic = $this->orderModel->pic;
        $this->change = $this->orderModel->change;
        $this->post_id = $this->orderModel->post_id;
        $this->yard = $this->orderModel->yard;
        $this->trip = $this->orderModel->trip;
    }

    public function store(): void
    {
        $this->orderModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->orderModel->update($this->validate());

        $this->reset();
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
}
