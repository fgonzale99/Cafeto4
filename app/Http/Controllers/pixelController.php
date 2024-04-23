<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pixelController extends Controller
{
    //


    public function verifyQrCode(Request $request)
    {


      //firmadatos
      $reviewId=$request->reviewId;
      $reviewerId=$request->reviewerId;
      
      $fechaFirma=$request->fechaFirma;
      $ip=$request->ip;

      $codigo_etica=\App\Models\ProjectReview::whereRaw('md5(assignDate)="'.$fechaFirma.'"')
      ->where('id',$reviewId)
      ->where('reviewer',$reviewerId)
      ->first();

      if($codigo_etica)
      {
       
       $reviewerName=$codigo_etica->getReviewer->name;
       $hostName=request()->getHost(); 
       $validezQr="Válido" ;
       $fechaFirma = $codigo_etica->assignDate;
       $codigoFirma = 'http://'.$hostName.'/' . md5('firmaDatos') . '/' . $codigo_etica->id . '/' . md5($fechaFirma) . '/' . $codigo_etica->getReviewer->id . '/' . $ip;

   
       $imagenFirma = base64_encode(\QrCode::size(300)->format('svg')->generate($codigoFirma));
   




        return view('review.validaQr',compact('imagenFirma','validezQr','reviewerName','fechaFirma'));
      }
      else
      {
       return "Firma no válida";
   

      }

      


    }


    
    public function transparent_pixel($notificacion_id)
    {
 
     header('Content-Type: image/png');
     echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII=');


        $notificacion=\App\Models\Notification::find($notificacion_id);

        $notificacion->state='Visto';

        $notificacion->save();

    


    }
}
