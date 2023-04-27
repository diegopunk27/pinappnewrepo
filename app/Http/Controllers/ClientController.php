<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Artisan;
use App\Interfaces\ClientRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\IClientController;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ClientController extends Controller implements IClientController
{
    use ApiResponser;

    /** @var ClientRepositoryInterface */
    private $repository;

    
    public function __construct(ClientRepositoryInterface $repository) {
        $this->repository = $repository;     
    }

    public function index(){
        $clients = $this->repository->getAllClients();

        return $this->successResponse($clients);
    }

    public function store(Request $request){
        $rules = [
            'name' => 'required|max:255',
            'lastname' => 'required|max:255',
            'age' => 'required|numeric|min:1|max:110',
            'birthdate' =>'required|date_format:Y-m-d',
        ];

        $this->validate($request, $rules);

        $newClient = $this->repository->createClient($request->all());

        return $this->successResponse($newClient, Response::HTTP_CREATED);
    }

    public function getAgeAverage(){
        $clients = $this->repository->getAllClients();

        $clientsExistError = $this->clientsExistControl($clients);
        if(!empty($clientsExistError)){
            return $clientsExistError; 
        }      

        $ageAverage = $this->repository->calculateAverage($clients);
        
        return $this->successResponse([$ageAverage]);
    }

    public function getMeanDeviation(){
        $clients = $this->repository->getAllClients();

        $clientsExistError = $this->clientsExistControl($clients);
        if(!empty($clientsExistError)){
            return $clientsExistError; 
        } 

        $meanDeviation= $this->repository->calculateMeanDeviation($clients);
        
        return $this->successResponse([$meanDeviation]);
    }

    public function getListWithProbabilityDeath(){
        $clients = $this->repository->getAllClients();

        $clientsExistError = $this->clientsExistControl($clients);
        if(!empty($clientsExistError)){
            return $clientsExistError; 
        } 

        $clientListWithDateOfDeath = $this->repository->generateClientListWithDateOfDeath($clients);

        return $this->successResponse($clientListWithDateOfDeath);
    }

    public function generateMigration(){
        try {
            Artisan::call('migrate:fresh --seed');
        } catch (\Error $th) {
            return $this->errorResponse($th, Response::HTTP_INTERNAL_SERVER_ERROR); 
        }

        return $this->successResponse(["Migration ok"]);
    }


    private function clientsExistControl(Collection $clients){
        $output = [];
        $clientsCount = $clients->count();
        if(!$clientsCount){
            $output = $this->errorResponse("Count of clients is zero", Response::HTTP_INTERNAL_SERVER_ERROR); 
        }

        return $output;
    }

}
