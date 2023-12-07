<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;

class AvisoEvaluacionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aviso:evaluacion';

    /**
     * The console command description.
     *
     * @var string
     */

     
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */

     public function mailSend($postArray)
     {
   
       //$notificacion = \App\Models\Mail::where('accion', 'like', $postArray['action'])->where('state', '=', 'Activo')->first();
   
       if($postArray){
   
         $emails = array();
         $correo['asunto'] = $postArray['subject'];
         $correo['emails'] = $postArray['emails'];
         $correo['mensaje'] = $postArray['message'];
   
         Mail::send([], [], function($message) use ($correo) {
            $message->to($correo['emails'])
                    ->subject($correo['asunto']);
           $message->setBody($correo['mensaje'], 'text/html');
         });
   
       }
   
       return $postArray;
     }

     

    public function handle()
    {
        $primer_aviso=env('PRIMER_AVISO');
        $segundo_aviso=env('SEGUNDO_AVISO');

        $evaluaciones_1aviso=\App\Models\ProjectReview::
        with('getReviewer','getProject')
        ->where('projectReview.state','Activo')
        ->whereRaw('datediff(date_add(assignDate,Interval daysLimit day),now()  )='.$primer_aviso)->get();   


        $evaluaciones_2aviso=\App\Models\ProjectReview::
        with('getReviewer','getProject')
        ->where('projectReview.state','Activo')
        ->whereRaw('datediff(date_add(assignDate,Interval daysLimit day),now()  )='.$segundo_aviso)->get();   

//primer aviso


      $style='<style>
      .btn {
        display: block;
        width: 115px;
        height: 25px;
        background: #4E9CAF;
        padding: 10px;
        text-align: center;
        border-radius: 5px;
        color: white;
        font-weight: bold;
        line-height: 25px;
    }
      .content
      {font-family: arial;
      }
    </style>';

        $dataset=$evaluaciones_1aviso;


        foreach($dataset as $key => $record)
        {
              $nombre=$record->getReviewer->name;
              $email=$record->getReviewer->email;
              $project_name=$record->getProject->name;
              $due_date=date('d \d\e M \d\e Y', strtotime($record->assignDate .' + '.$record->daysLimit.' days'));
              $eval_url=env('APP_URL').'reviewer/projects?model=evaluaciones';
        
              //Enviar correos
              $notification['subject'] = 'Avanciencia-Cafeto recordatorio';

              $notification['elementId'] = $record->id;
              $notification['message'] = "$style <div class='content'><img  width=150 src='https://avanciencia.org/sites/default/files/logoHAvanciencia_2.png'><br>";
              $notification['message'] .= "<br><br><strong>$nombre</strong>, recuerde que la evaluación de <br>
              <strong>$project_name</strong>,<br> debe finalizarla antes del $due_date
              <br><br>Ingrese a través del siguiente botón para continuar con su proceso.  
              <br><br>
              <a class='btn' href='$eval_url'>Evaluar</a>";
              $notification['message'] .= "<br><br><br><br><br><br><br><img alt='Cafeto logo' class='img-fluid logo-cafeto' width=150 src='https://cafeto.cimaonline.com.co//img/cafeto_logo.jpg'></div>";

              $notification['emails'] = [$email];


              $this->mailSend($notification);
        }



        //segundo aviso
        $dataset=$evaluaciones_2aviso;

        foreach($dataset as $key => $record)
        {
              $nombre=$record->getReviewer->name;
              $email=$record->getReviewer->email;
              $project_name=$record->getProject->name;
              $due_date=date('d \d\e M \d\e Y', strtotime($record->assignDate .' + '.$record->daysLimit.' days'));
              $eval_url=env('APP_URL').'reviewer/projects?model=evaluaciones';
        
              //Enviar correos
              $notification['subject'] = 'Avanciencia-Cafeto debe finalizar hoy su evaluación';

              $notification['elementId'] = $record->id;
              $notification['message'] = "$style <div class='content'><img  width=150 src='https://avanciencia.org/sites/default/files/logoHAvanciencia_2.png'><br>";
              $notification['message'] .= "<br><br><strong>$nombre</strong>, recuerde que la evaluación de <br>
              <strong>$project_name</strong>,<br> debe finalizarla <strong>hoy $due_date</strong>
              <br><br>Ingrese a través del siguiente botón para continuar con su proceso.  
              <br><br>
              <a class='btn' href='$eval_url'>Evaluar</a>";
              $notification['message'] .= "<br><br><br><br><br><br><br><img alt='Cafeto logo' class='img-fluid logo-cafeto' width=150xs src='https://cafeto.cimaonline.com.co//img/cafeto_logo.jpg'></div>";

              $notification['emails'] = [$email];


              $this->mailSend($notification);
        }


        return 'Terminé';
    }
}
