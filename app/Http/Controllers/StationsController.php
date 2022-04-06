<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchStations;
use App\Http\Requests\StoreStation;
use App\Http\Requests\UpdateStation;
use App\Http\Resources\Station as StationResource;
use App\Http\Resources\StationCollection;
use App\Models\Station;
use App\Services\StationService;

class StationsController extends Controller
{
    protected StationService $stationService;

    public function __construct(StationService $stationService)
    {
        $this->stationService = $stationService;
    }

    /**
     * Display a listing of the resource.
     *
	 * @OA\Get (
	 *     path="/stations/search",
	 *     operationId="SearchStationsList",
	 *     tags={"stations"},
	 *     summary="Store new station",
	 *     description="Get list of stations.",
	 *     @OA\Parameter(ref="#/components/parameters/PerPage"),
	 *     @OA\Parameter(ref="#/components/parameters/Page"),
	 *     @OA\Response(
	 *         response=200,
	 *         ref="#/components/responses/StationCollectionResponse"
	 *     )
	 * )
     *
     * @return \Illuminate\Http\Response
     */
    public function search(SearchStations $request)
    {
        $latitude = (float) $request->input('latitude');
        $longitude = (float) $request->input('longitude');
        $companyId = $request->input('company_id');
        $distance = (float) $request->input('distance', 2);

        $stations = $this->stationService->nearestStations($latitude, $longitude, $distance, $companyId);

        return new StationCollection($stations);
    }

    /**
     * Display a listing of the resource.
     *
	 * @OA\Get (
	 *     path="/stations",
	 *     operationId="GetStationsList",
	 *     tags={"stations"},
	 *     summary="Store new station",
	 *     description="Get list of stations.",
	 *     @OA\Parameter(ref="#/components/parameters/PerPage"),
	 *     @OA\Parameter(ref="#/components/parameters/Page"),
	 *     @OA\Response(
	 *         response=200,
	 *         ref="#/components/responses/StationResponse"
	 *     )
	 * )
	 *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginatedStations = $this->stationService->paginatedList();

        return new StationCollection($paginatedStations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/stations",
     *     operationId="StoreStation",
     *     tags={"stations"},
     *     summary="Store new station",
     *     description="Returns station data",
     * 	   @OA\RequestBody(
     *         required=true,
     *         ref="#/components/schemas/StoreStationRequest"
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         ref="#/components/responses/StationResponse"
     *     ),
     * 	   @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
 	 *     @OA\Response (
	 *         response=422,
	 *         description="Unprocessable Entity.",
	 *         @OA\JsonContent(
	 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
	 *             @OA\Property(
	 *                 property="errors",
	 *                 type="object",
	 *                 ref="#/components/schemas/InvalidStoreStationRequest"
	 *             )
	 *         )
	 *     )
     * )
	 *
     * @param  \Illuminate\Http\StoreStation $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStation $request)
    {
        $dto = $request->dto();

        $station = $this->stationService->create($dto);

        return new StationResource($station);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/stations/{id}",
     *     operationId="getStationById",
     *     tags={"stations"},
     *     summary="Get station information",
     *     description="Returns station data",
     * 	   @OA\Parameter(
     *         name="id",
     *         description="Station id",
     *         required=true,
     *         in="path",
     * 	   @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     * 	   @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *    @OA\JsonContent(ref="#/components/responses/StationResponse")),
     *    @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *    @OA\Response(
     *         response=404,
     *         description="Resource Not Found"
     *     )
     * )
	 *
     * @param  Station $station
     * @return \Illuminate\Http\Response
     */
    public function show(Station $station)
    {
        return new StationResource($station);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/stations/{id}",
     *     operationId="updateStation",
     *     tags={"stations"},
     *     summary="Update existing station",
     *     description="Returns updated station data",
     *     @OA\Parameter(
     *         name="id",
     *         description="Station id",
     *         required=true,
     *         in="path",
     *     @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *     @OA\JsonContent(ref="#/components/schemas/UpdateStationRequest")),
     *     @OA\Response(
     *         response=202,
     *         description="Successful operation",
     *     @OA\JsonContent(ref="#/components/responses/StationResponse")),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
 	 *     @OA\Response (
	 *         response=422,
	 *         description="Unprocessable Entity.",
	 *         @OA\JsonContent(
	 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
	 *             @OA\Property(
	 *                 property="errors",
	 *                 type="object",
	 *                 ref="#/components/schemas/InvalidUpdateStationRequest"
	 *             )
	 *         )
	 *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource Not Found"
     *     )
     * )
	 *
     * @param  \Illuminate\Http\UpdateStation $request
     * @param  Station                        $station
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStation $request, Station $station)
    {
        $dto = $request->dto();

        $this->stationService->update($station, $dto);

        return new StationResource($station);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/stations/{id}",
     *     operationId="deleteStation",
     *     tags={"stations"},
     *     summary="Delete existing station",
     *     description="Deletes a record and returns no content",
     *     @OA\Parameter(
     *         name="id",
     *         description="Station id",
     *         required=true,
     *         in="path",
     *     @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Successful operation",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource Not Found"
     *     )
     * )
	 *
     * @param  Station $station
     * @return \Illuminate\Http\Response
     */
    public function destroy(Station $station)
    {
        $this->stationService->delete($station);

        return response()->json([]);
    }
}
