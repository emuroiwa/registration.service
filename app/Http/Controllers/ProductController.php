<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::debug(__METHOD__ . ' bof');
        try {

            $data = Product::all();

        } catch (ModelNotFoundException $exception) {
            Log::error(__METHOD__ . ' ' . $exception->getMessage());
            return response()->json([
                "status" => 'failure',
                "data" => $exception->getMessage()
            ], 400);
        }
        Log::debug(__METHOD__ . ' eof');

        return response()->json([
            "status" => 'success',
            "data" => $data
        ], 200);

    }
}
