<?php namespace App\Repositories;


interface InvoicePaymentRepository
{
    public function getAll();

    public function createPayment(array $data);
}