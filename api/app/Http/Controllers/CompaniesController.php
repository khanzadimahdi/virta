<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompany;
use App\Http\Requests\UpdateCompany;
use App\Http\Resources\Company as CompanyResource;
use App\Models\Company;
use App\Services\CompanyService;

class CompaniesController extends Controller
{
    private CompanyService $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    /**
     * Display a listing of the resource.
     *
     * @OA\Get(
     *     path="/companies",
     *     operationId="getCompaniesList",
     *     summary="Get list of companies",
     *     tags={"companies"},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Company")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array")
     *         )
     *     )
     * )
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginatedCompanies = $this->companyService->paginatedList();

        return response()->json($paginatedCompanies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/companies",
     *     operationId="storeCompany",
     *     tags={"companies"},
     *     summary="Store new company",
     *     description="Returns company data",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCompanyRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/CompanyCollection")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     )
     * )
     *
     * @param  \Illuminate\Http\StoreCompany  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompany $request)
    {
        $dto = $request->dto();

        $company = $this->companyService->create($dto);

        return new CompanyResource($company);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/companies/{id}",
     *     operationId="getCompanyById",
     *     tags={"companies"},
     *     summary="Get company information",
     *     description="Returns company data",
     *     @OA\Parameter(
     *         name="id",
     *         description="Company id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Company")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource Not Found"
     *     )
     * )
     *
     * @param  Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return new CompanyResource($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/companies/{id}",
     *     operationId="updateCompany",
     *     tags={"companies"},
     *     summary="Update existing company",
     *     description="Returns updated company data",
     *     @OA\Parameter(
     *         name="id",
     *         description="Company id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCompanyRequest")
     *     ),
     *     @OA\Response(
     *         response=202,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Company")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource Not Found"
     *     )
     * )
     *
     * @param  \Illuminate\Http\UpdateCompany  $request
     * @param  Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompany $request, Company $company)
    {
        $dto = $request->dto();

        $this->companyService->update($company, $dto);

        return new CompanyResource($company);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @OA\Delete(
     *     path="/companies/{id}",
     *     operationId="deleteCompany",
     *     tags={"companies"},
     *     summary="Delete existing company",
     *     description="Deletes a record and returns no content",
     *     @OA\Parameter(
     *         name="id",
     *         description="Company id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
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
     * @param  Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $this->companyService->delete($company);

        return response()->json([]);
    }
}
