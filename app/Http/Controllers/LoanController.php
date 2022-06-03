<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\User;
use Faker\Provider\ar_EG\Text;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Loan::all();
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
            Loan::create($request->all());
            return response()->json([
                'success' => 'loan is made successfuly'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $this->validatedfield($th->errorInfo)
            ], 200); ;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $loan = Loan::find($id);

        if ($loan) {
            return $loan;
        }
        return response()->json([
            'error' => 'loan not found'
        ], 500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loan $loan)
    {
        try {
            $loan->update($request->all());
            return response()->json([
                'success' => 'loan is made successfuly'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $this->validatedfield($th->errorInfo)
            ], 200); ;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        return $loan->delete();
    }


    private function validatedfield($error)
    {
        switch ($error[1]) {
            case 1364:
                $message= $error[2];
                break;
            case 1265:
                $message= '  the field  ' .$this->findField("/\'(.+)\'/", $error[2]). ' must be a int ';
                break;
            case 1452:
                $message=  $this->findField("/loans\_(.+)\_id\_foreign/", $error[2]). ' not found ';
                break;

            default:
            return response()->json([
                'error' => 'something went wrong'
            ], 400);
                break;
        }
        return $message;
    }
    private function findField($regex, $text){
        preg_match($regex, $text, $result);
        return $result[1];

    }
}
