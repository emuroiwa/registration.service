<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
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

            $data = User::all();

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::debug(__METHOD__ . ' bof');
        try {
            //validate
            $request->validate([
                'user_id' => 'required|numeric',
                'product_sku' => 'required|string',
            ]);

            $user = User::find($request['user_id']);
            $product_sku = $request['product_sku'];
            $res = $user->purchase()->attach($product_sku);

        } catch (Exception $exception) {
            Log::error(__METHOD__ . ' ' . $exception->getMessage());
            return response()->json([
                "status" => 'failure',
                "data" => $exception->getMessage()
            ], 400);
        }
        Log::debug(__METHOD__ . ' eof');

        return response()->json([
            "status" => 'success',
            "data" => $res
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        Log::debug(__METHOD__ . ' bof');
        try {
        $purchases = $user->join('purchases', 'users.id', '=', 'purchases.user_id')
                    ->join('products','products.sku', '=', 'purchases.product_sku')
                    ->select('products.sku','products.name')
                    ->get();
        } catch (Exception $exception) {
            Log::error(__METHOD__ . ' ' . $exception->getMessage());
            return response()->json([
                "status" => 'failure',
                "data" => $exception->getMessage()
            ], 400);
        }
        Log::debug(__METHOD__ . ' eof');

        return response()->json([
            "status" => 'success',
            "data" => $purchases
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($sku, User $user)
    {
        Log::debug(__METHOD__ . ' bof');
        try {

            $res = $user->purchase()->detach($sku);

        } catch (Exception $exception) {
            Log::error(__METHOD__ . ' ' . $exception->getMessage());
            return response()->json([
                "status" => 'failure',
                "data" => $exception->getMessage()
            ], 400);
        }
        Log::debug(__METHOD__ . ' eof');

        return response()->json([
            "status" => 'success',
            "data" => $res
        ], 200);
    }
}
