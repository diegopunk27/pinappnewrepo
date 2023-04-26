<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface ClientRepositoryInterface 
{
    public function getAllClients();
    public function createClient(array $orderDetails);
    public function calculateAverage(Collection $clients) : float;
    public function calculateMeanDeviation(Collection $clients) : float;
    public function generateClientListWithDateOfDeath(Collection $clients);
}