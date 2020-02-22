<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        try {
            $input = $request->all();

            $brands = Brand::search($input)
                ->filter($input)
                ->sort($input)
                ->paginates($input);

            return response()->json([
                'success' => true,
                'data' => $brands,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Bad request',
                'exception' => $th,
            ], 400);
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
        try {
            $brand = new Brand();
            $brand->fill($request->all());
            $brand->save();

            return response()->json($brand, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Bad request',
                'exception' => $th,
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $brand = Brand::where('id', $id)->first();
        if ($brand) {
            $products = $brand->products()->get();
        }
        if ($brand) {
            return response()->json([
                'id' => $brand->id,
                'nome' => $brand->nome,
                'products' => $products,

            ]);
        } else {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $brand = Brand::find($id);

        if (!$brand) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        try {

            $brand->fill($request->all());
            $brand->save();

            return response()->json($brand);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Bad request',
                'exception' => $th,
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);

        if (!$brand) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        try {
            $brand->delete();
            return response()->json([
                'message' => 'Deleted successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Bad request',
                'exception' => $th,
            ], 400);
        }
    }
}
