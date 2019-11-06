<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CommerceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DynamicPDFController extends Controller
{
    function index(){
        return view('pdf.dynamic_pdf');
    }
    public function makePdf($kp_id) {
      
      $rate = DB::table('rate')->pluck('rate_value')->first();
      $user = DB::table('kp_list')
          ->where('kp_list.id', $kp_id) 
          ->select('kp_list.name')
          ->first();
      
      $commerce = new CommerceController();
      $commerce = $commerce->getBlocksWithPositionsByKp($kp_id)->toArray();

      $file_name = "mirado_кп_$kp_id.pdf";
      $pdf = \App::make('dompdf.wrapper');

      $data = array(
        'name'      => $user->name ?? '',
        'rate'      => $rate,
        'commerces' => $commerce,
        'file_name' => $file_name
      );
      $pdf->loadView('pdf.dynamic_pdf', $data);
      return $pdf->download($file_name);
    }
}
