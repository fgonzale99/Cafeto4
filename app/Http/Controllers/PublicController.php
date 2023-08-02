<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PublicController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function certificateValidate(Request $request){

      $review = "\App\Models\ProjectReview"::whereRaw('md5(id)="'.$request->code.'"')->first();
      $format = \App\Models\FormatReview::find(2);

      $arrayValues['idCodigoEtica'] = $review->id;
      $arrayValues['fechaFirma'] = $review->assignDate;
      $arrayValues['firmaCodigo'] = '<img src="'.$review->codeSignature.'" widht="80" height="80"/>';
      $arrayValues['nombreEvaluador'] = $review->getReviewer->name;
      $arrayValues['identificacion'] = $review->getReviewer->document;
      $arrayValues['tipoId'] = $review->getReviewer->documentType;
      $arrayValues['nombreProceso'] = $review->getProject->getProcess->name;
      $arrayValues['nombreCliente'] = $review->getProject->getProcess->getCustomer->name;
      $arrayValues['nombreDocumento'] = $review->getProject->name;

      $arrayValues['qrConsulta']  = "";

      foreach ($arrayValues as $keyC => $valueC) {
        $titulos[] = '{{$'.$keyC.'}}';
        $valores[] = $valueC;
      }

      $content = str_replace($titulos, $valores, $format->content);


      return view('reviewer.certificate', compact('review','content'));
    }

}
