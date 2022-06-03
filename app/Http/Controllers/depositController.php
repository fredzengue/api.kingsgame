<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;

class depositController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Deposit::all();
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
            Deposit::create($request->all());
            return response()->json(
                ['sucess' => 'Deposit made successfuly !'], 200
            );
        } catch (\Throwable $th) {
            return response()->json(['error' => self::validateField($th)], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $deposit = Deposit::find($id);

        if ($deposit){
            return $deposit;
        }
        return response()->json(
            ['error' => 'deposit not found'], 500
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deposit $deposit)
    {
      if ($deposit->update($request->all())) {
          # code...
          return response()->json(
              ['sucess' => 'Deposit update successfuly !'], 200
          );
      }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deposit $deposit)
    {
        //
    }

    private function validateField($th){
        switch ($th->errorInfo[1]) {
            case 1364:
                $message = $th->errorInfo[2];
                break;
            case 1265:
                $message = 'the field ' .self::findError($th->errorInfo[2], "/\'(.+)\'/"). " must be a int";
                break;
            case 1452:
                    $message = self::findError($th->errorInfo[2], "/deposits\_(.+)\_id\_foreign/") . " not found";
                break;
            case 1062:
                $message = "this payment has been used to another desposit";
                break;
            default:
                return response()->json(['error' => 'something when wrong'], 400);
                break;
        }

        return $message;
    }

    private function findError ($text, $regex) {
        preg_match($regex, $text, $matches);
        return $matches[1];
    }


    // private function validateField ($request) {
    //     if ($request->user_id == ''){
    //         return response()->json(
    //             ['error' => 'the field user_id required'], 500
    //         );
    //     };
    //     if ($request->payment_id == ''){
    //         return response()->json(
    //             ['error' => 'the field payment_id required'], 500
    //         );
    //     };
    //     if ($request->amount == ''){
    //         return response()->json(
    //             ['error' => 'the field amount required'], 500
    //         );
    //     };
    //     if ($request->status == ''){
    //         return response()->json(
    //             ['error' => 'the field status required'], 500
    //         );
    //     };

    //     // //integer validation

    //     // if (!is_int($request->user_id)){
    //     //     return response() -> json(
    //     //         ['error' => 'the field user_id is integer'], 500
    //     //     );
    //     // };
    //     // if (!is_int($request->payment_id)){
    //     //     return response() -> json(
    //     //         ['error' => 'the field payment_id is integer'], 500
    //     //     );
    //     // };
    //     // if (!is_nu($request->amount)){
    //     //     return response() -> json(
    //     //         ['error' => 'the field amount is integer'], 500
    //     //     );
    //     // };

    //     //foreign

    //     if (!User::find($request->user_id)){
    //         return response()->json(
    //             ['error' => 'user_id is not found'], 500
    //         );
    //     };
    //     if (!Payment::find($request->payment_id)){
    //         return response()->json(
    //             ['error' => 'payment_id is not found'], 500
    //         );
    //     };

    //     if (Deposit::where('payment_id',$request->payment_id)){
    //         return response()->json(
    //             ['error' => ' this payment has been used to another deposit'], 500
    //         );
    //     };
    // }
}
