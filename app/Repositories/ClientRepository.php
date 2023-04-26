<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Client;
use App\Interfaces\ClientRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ClientRepository implements ClientRepositoryInterface 
{
    public function getAllClients() 
    {
        return Client::all();
    }

    public function createClient(array $orderDetails) 
    {
        return Client::create($orderDetails);
    }

    public function calculateAverage(Collection $clients) : float{
        $ageAverage =  $clients->avg('age');
        
        return $ageAverage;
    }

    public function calculateMeanDeviation(Collection $clients) : float{
        $ageAverage = $this->calculateAverage($clients);
        $clientsCount = $clients->count();
        $sum =  $clients->sum(function($client) use ($ageAverage){
            return pow(($client['age'] - $ageAverage), 2);
        });
        $meanDeviation= sqrt($sum / $clientsCount);

        return $meanDeviation;
    }

    public function generateClientListWithDateOfDeath(Collection $clients){
        $probabilityOfYearsForLive = $this->calculateAverage($clients) + $this->calculateMeanDeviation($clients);

        $clients->map(function ($client) use ($probabilityOfYearsForLive){
            $dateOfBirthdate = Carbon::createFromFormat('Y-m-d', $client->birthdate);
            $probableDateOfDeath = $dateOfBirthdate->addYears($probabilityOfYearsForLive)->format('Y-m-d');
            $client['probableDateOfDeath'] = $probableDateOfDeath;
            return $client;   
        });

        return $clients;
    }

}