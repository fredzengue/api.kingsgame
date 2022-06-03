<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Models\Withdrawall;
use Exception;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class WithdrawallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Withdrawall::all();
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
            Withdrawall::create($request->all());
            return response()->json([
                'success' => 'the withdrawall is made succefully'
            ], 200);
        } catch (\Throwable $th) {

            return response()->json([
                'error' => self::validateField($th)
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Withdrawall  $withdrawall
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $withdrawall = Withdrawall::find($id);
        if ($withdrawall) {
            return $withdrawall;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Withdrawall  $withdrawall
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Withdrawall $withdrawall)
    {
        try {
            $withdrawall->update($request->all());
            return response()->json([
                'success' => 'withdrawall updated'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => self::validateField($th)
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Withdrawall  $withdrawall
     * @return \Illuminate\Http\Response
     */
    public function destroy(Withdrawall $withdrawall)
    {
        $withdrawall->delete();
    }
    private function validateField($th)
    {

        switch ($th->errorInfo[1]) {
            case 1364:
                //fields required
                $message = $th->errorInfo[2];
                break;
            case 1265:
                //field error type
                $message = "the field " . self::findErrorField($th->errorInfo[2],"/\'(.+)\'/") . " must be a int";
                break;
            case 1452:
                //foreign not found
                $message = self::findErrorField($th->errorInfo[2],"/withdrawalls\_(.+)\_id\_foreign/") . " not found";
                break;
            case 1062:
                //field unique
                $message = 'this payment has been used to another withdrawall';
                break;


            default:
                return response()->json([
                    'error' => 'Something when wrong'
                ], 400);
                break;
        }
        return $message;
    }
    private function findErrorField($text,$regex)
    {
        preg_match($regex, $text, $matches);
        return $matches[1];
    }
}
