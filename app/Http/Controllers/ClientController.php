<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(){
        $clients = Client::all();

        return $this->successResponse($clients);
    }

    /**
     * Create an specific client.
     *
     * @return Illuminate\Http\Response
     */
    public function store(Request $request){
        $rules = [
            'name' => 'required|max:255',
            'lastname' => 'required|max:255',
            'age' => 'required|numeric|min:1|max:110',
            'birthdate' =>'required|date_format:d-m-Y',
        ];

        $this->validate($request, $rules);

        $author = Client::create($request->all());

        return $this->successResponse($author, Response::HTTP_CREATED);
    }

    public function getAgeAverage(){
        $clients= Client::all();

        $clientsExistError = $this->clientsExistControll($clients);
        if(!empty($clientsExistError)){
            return $clientsExistError; 
        }      

        $ageAverage = $this->calculateAverage($clients);
        
        return $this->successResponse([$ageAverage]);
    }

    public function getMeanDeviation(){
        $clients= Client::all();

        $clientsExistError = $this->clientsExistControll($clients);
        if(!empty($clientsExistError)){
            return $clientsExistError; 
        } 

        $meanDeviation= $this->calculateMeanDeviation($clients);
        
        return $this->successResponse([$meanDeviation]);
    }

    public function getListWithProbabilityDeath(){
        $clients= Client::all();

        $clientsExistError = $this->clientsExistControll($clients);
        if(!empty($clientsExistError)){
            return $clientsExistError; 
        } 

        $probabilityOfYearsForLive = $this->calculateAverage($clients) + $this->calculateMeanDeviation($clients);

        $clients->map(function ($client) use ($probabilityOfYearsForLive) {
            $dateOfBirthdate = Carbon::createFromFormat('Y-m-d', $client->birthdate);
            $probableDateOfDeath = $dateOfBirthdate->addYears($probabilityOfYearsForLive)->format('Y-m-d');
            $client['probableDateOfDeath'] = $probableDateOfDeath;
            
            return $client;   
        });

        return $this->successResponse($clients);
    }


    private function clientsExistControll(Collection $clients){
        $output = [];
        $clientsCount = $clients->count();
        if(!$clientsCount){
            $output = $this->errorResponse("Count of clients is zero", Response::HTTP_INTERNAL_SERVER_ERROR); 
        }

        return $output;
    }

    private function calculateAverage(Collection $clients) : float{
        $ageAverage =  $clients->avg('age');
        
        return $ageAverage;
    } 

    private function calculateMeanDeviation(Collection $clients) : float{
        $ageAverage = $this->calculateAverage($clients);
        $clientsCount = $clients->count();
        $sum =  $clients->sum(function($client) use ($ageAverage){
            return pow(($client['age'] - $ageAverage), 2);
        });
        $meanDeviation= sqrt($sum / $clientsCount);

        return $meanDeviation;
    }

}
