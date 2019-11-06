<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RateController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $rate = DB::table('rate')->pluck('rate_value')->first();
        $rate_values = DB::table('rate')->orderBy('id', 'desc')->limit(20)->get();
        $rate_values_chart = DB::table('rate')->get();
        
        return view('pages.rate', [
            'rate' =>  $rate,
            'rate_values' => $rate_values,
            'rate_values_chart' => $rate_values_chart,
        ]);
    }

    public function add(Request $request){
        $rate = $request->input('rate');

        DB::table('rate')->insert(['rate_value' => $rate]);
        return redirect()->action('RateController@index');
    }

    public function delete(Request $request){
        $id = $request->input('id');

        DB::table('rate')->where('id', $id)->delete();
        return redirect()->action('RateController@index');
    }
}
