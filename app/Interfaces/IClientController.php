<?php

namespace App\Interfaces;

use Illuminate\Http\Request;


/**
 * Description of IClient
 *
 * @author Diego Yanacon
 */
interface IClientController{
    
    /**
     * @OA\Get(
     * path="/clients",
     * summary="Show a list of clients",
     * tags={"Clients"},
     * @OA\Response(
     *     response="200", 
     *         description="Show list of clients with theirs information"
     *     ),
     * )
    */
    public function index();

    /**
     * @OA\Post(
     * path="/clients",
     * summary="Create a new client",
     * description="Create a new client",
     * tags={"Clients"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Client data",
     *    @OA\JsonContent(
     *       required={"name","lastname","age","birthdate"},
     *       @OA\Property(property="name", type="string", format="string", example="Alberto", maxLength=255),
     *       @OA\Property(property="lastname", type="string", format="string", example="Perez", maxLength=255),
     *       @OA\Property(property="age", type="integer", example="37"),
     *		 @OA\Property(property="birthdate", type="date", example="1985-03-01"),
     *    ),
     * ),
     * @OA\Response(
     *      response="201", 
     *      description="Creation success data"
     *    ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong data input",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrond data. Please try again")
     *        )
     *     )
     * )
    */

    public function store(Request $request);

    /**
     * @OA\Get(
     * path="/clients/age-average",
     * summary="Show years old average of all clients",
     * tags={"Clients"},
     *     @OA\Response(
     *          response="200", 
     *          description="Show a number that represent the average from years old of all clients"
     *      ),
     *      @OA\Response(
     *          response="500", 
     *          description="Count of clients is zero"
     *      ),
     * )
    */
    public function getAgeAverage();

    /**
     * @OA\Get(
     * path="/clients/mean-deviation",
     * summary="Show the mean deviation from years old of all clients",
     * tags={"Clients"},
     *     @OA\Response(
     *          response="200", 
     *          description="Show a number that represent the mean deviation from years old of all clients"
     *      ),
     *      @OA\Response(
     *          response="500", 
     *          description="Count of clients is zero"
     *      ),
     * )
    */
    public function getMeanDeviation();

    /**
     * @OA\Get(
     * path="/clients/list-with-probability-of-death",
     * summary="Show a list of clients with theirs probably date of death",
     * tags={"Clients"},
     *     @OA\Response(
     *          response="200", 
     *          description="Show a list of clients with theirs probably date of death (calculated from the add between the avergage and mean deviation yaers old)"
     *      ),
     *      @OA\Response(
     *          response="500", 
     *          description="Count of clients is zero"
     *      ),
     * )
    */
    public function getListWithProbabilityDeath();

    /**
     * @OA\Get(
     * path="/clients/generate-migration",
     * summary="Generate new fictitious clients in the database",
     * tags={"Clients"},
     *     @OA\Response(
     *          response="200", 
     *          description="Clean the database, and generate fifty new fictitious clients for do testing"
     *      ),
     *      @OA\Response(
     *          response="500", 
     *          description="Something went wrong"
     *      ),
     * )
    */
    public function generateMigration();

}
