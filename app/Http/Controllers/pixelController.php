<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pixelController extends Controller
{
    //


    public function transparent_pixel($notificacion_id)
    {
 
   //  header('Content-Type: image/png');
     echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII=');




   

        $notificacion=\App\Models\Notification::find($notificacion_id);

        $notificacion->state='Visto';

        $notificacion->save();

        dd($notificacion);


    }
}
