<?php

namespace App\Http\Modules\UnitOfMeasures\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\UnitOfMeasures\Repositories\UnitOfMeasureRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UnitOfMeasureController extends Controller
{

    protected $UnitOfMeasureRepository;

    public function __construct(UnitOfMeasureRepository $UnitOfMeasureRepository)
    {
        $this->UnitOfMeasureRepository = $UnitOfMeasureRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            return response()->json(['res' => true, 'data' => $this->UnitOfMeasureRepository->getAllActives(), 'message' => 'Ok'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['res' => true, 'data' => $th->getMessage(), 'message' => 'Error'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
