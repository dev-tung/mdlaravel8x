<?php

namespace App\Repositories;

use App\Models\Payment;

class PaymentRepository
{
    public function getAll()
    {
        return Payment::with(['order', 'user'])->latest()->paginate(20);
    }

    public function find($id)
    {
        return Payment::with(['order', 'user'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Payment::create($data);
    }

    public function update($id, array $data)
    {
        $payment = $this->find($id);
        $payment->update($data);
        return $payment;
    }

    public function delete($id)
    {
        $payment = $this->find($id);
        return $payment->delete();
    }
}
