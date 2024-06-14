<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Mail;
use DB;

class ProcessController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function list(){
      return view('process.crud.main');
    }

    public function new(){
      return view('process.crud.main');
    }

    public function edit(){
      return view('process.crud.main');
    }



    public function topBudget($id ){
      return view('process.crud.main');
    }




    public function validateTopBudget(Request $request){


      $project=$request->id;
      $project = \App\Models\Project::find($request->id);
      $processBudget = $project->getProcess->topBudget;

     


        $results = DB::select('select 
        SUM(COALESCE(feecustom,reviewFee.price )) as total
        from projectReview
        inner join process on projectReview.process=process.id
        inner join reviewFee on reviewFee.id = process.feeReview
        where process= ?', [$project->getProcess->id]);


        $asignedProcessBudget=$results[0]->total;

     //   dd($asignedProcessBudget);

  /*      if($asignedProcessBudget>$processBudget)
        {
          //si el presupuesto no  alcanza
          return false;
        }
        else
        {
          return true;
       }
    */   



      return true;
    }



    
    public function show(){
      return view('process.crud.main');
    }

    public function board(){
      return view('crud.main');
    }

    public function budget(){
      return view('process.crud.main');
    }

    public function paymentList(){
      return view('process.crud.main');
    }

    public function getList(){

     try {

       $data = \App\Models\Process::get();
       $response['data'] = $data;
       $response['success'] = true;

     } catch (\Exception $e) {
       $response['message'] = $e->getMessage();
       $response['success'] = false;
     }
     return $response;

   }

    public function listOld()
    {
      $elements = \App\Models\Process::orderBy('id','DESC')->paginate(20);
      return view('process.list', compact('elements'));
    }

    public function newOld()
    {
      $enums['users'] = \App\Models\User::get();
      $enums['customer'] = \App\Models\Customer::get();

      return view('process.new', compact('enums'));
    }


    public function store(Request $request)
    {
      $this->validate($request,['nombreProceso'=>'required',
                  'descripcion'=>'required',
                  'fechaInicio'=>'required',
                  'fechaTermino'=>'required',
                  'responsable'=>'required',
                  'institucion'=>'required']);

      $data = array('nombreProceso' => $request->nombreProceso,
            'descripcion' => $request->descripcion,
            'fechaInicio' => $request->fechaInicio,
            'fechaTermino' => $request->fechaTermino,
            'responsable' => $request->responsable,
            'institucion' => $request->institucion,
            'activo' => 1,
      );
      \App\Models\Process::create($data);
      return redirect()->route('process.list')->with('success','Registro creado satisfactoriamente');
    }

    public function showOld()
    {
      $element = \App\Models\Process::where('id', 1)->first();
      $projects = \App\Models\Project::orderBy('id','DESC')->paginate(20);

      return view('process.show', compact('element','projects'));
    }

   public function reviewsMatrix($elementId)
   {

     $process = "\App\Models\Process"::find($elementId);

     $modules = json_decode($process->getProjects[0]->getFormReview->form, true);

     $indexAlpha = range('A', 'Z');

     foreach($indexAlpha as $key){
       array_push($indexAlpha, "A".$key);
     }

     foreach($indexAlpha as $key){
       array_push($indexAlpha, "B".$key);
     }

     $this->_documento = new Spreadsheet();
     $this->_documento
         ->getProperties()
         ->setCreator("Asociación Colombiana Para el Avance de la Ciencia")
         ->setTitle('Informe');

     $this->_activeSheet = $this->_documento->getActiveSheet();

     $this->_indexFila = 1;

     $this->_activeSheet->setCellValue("A".$this->_indexFila, "Proceso");
     $this->_activeSheet->setCellValue("B".$this->_indexFila, $process->name);

     $this->_indexFila++;
     $this->_indexFila++;

     $this->_activeSheet->setCellValue("A".$this->_indexFila, 'Nº');
     $this->_activeSheet->setCellValue("B".$this->_indexFila, 'Código proyecto');
     $this->_activeSheet->setCellValue("C".$this->_indexFila, 'Par');
     $this->_activeSheet->setCellValue("D".$this->_indexFila, 'Nombre proyecto');
     $this->_activeSheet->setCellValue("E".$this->_indexFila, 'Evaluador(a)');
     $this->_activeSheet->setCellValue("F".$this->_indexFila, 'Fecha Evaluación');
     $this->_activeSheet->setCellValue("G".$this->_indexFila, 'Concepto General');
     $this->_activeSheet->setCellValue("H".$this->_indexFila, 'Puntaje Final');

     $this->_indexColumn = 8;

     foreach ($modules as $keyModule => $valueModule) {

           foreach ($valueModule['questions'] as $keyQuestion => $question) {
               if($question['type']!='paragraph'){
                  switch ($question['type']) {
                    case 'header':
                         $labelColumn = $question['label'];
                      break;
                    case 'text':
                         $labelColumn = $question['label'];
                      break;
                    case 'number':
                         $labelColumn = $question['label'];
                      break;
                    case 'paragraph':
                         $labelColumn = $question['label'];
                       break;
                    case 'textarea':
                         $labelColumn = $question['label'];
                       break;
                    case 'date':
                         $labelColumn = $question['label'];
                       break;
                   case 'radio-group':
                        $labelColumn = $question['label'];
                       break;
                    default:
                        $labelColumn = $question['label'];
                      break;
                  }
    
                 if(isset($question['name'])){
                   $questionIndex[$question['name']] = $this->_indexColumn;
                 }
    
                 $this->_activeSheet->setCellValue($indexAlpha[$this->_indexColumn].$this->_indexFila, strip_tags($labelColumn));
                $this->_indexColumn++;
             
            }
       }
     }

     $this->_indexFila++;

     foreach ($process->getProjects as $keyProject => $valueProject) {
       foreach ($valueProject->getProjecReviews as $keyReview => $valueReview) {
         if($valueReview->state == 'Evaluado'){
            $this->_activeSheet->setCellValue("A".$this->_indexFila, $valueReview->id);
             $this->_activeSheet->setCellValue("B".$this->_indexFila, $valueReview->getProject->code);
             $this->_activeSheet->setCellValue("C".$this->_indexFila, $valueReview->par);
             $this->_activeSheet->setCellValue("D".$this->_indexFila, $valueReview->getProject->name);
             $this->_activeSheet->setCellValue("E".$this->_indexFila, @$valueReview->getReviewer->name);
             $this->_activeSheet->setCellValue("F".$this->_indexFila, $valueReview->reviewDate);
             $this->_activeSheet->setCellValue("G".$this->_indexFila, $valueReview->concept);
             $this->_activeSheet->setCellValue("H".$this->_indexFila, $valueReview->result);
    
    
             $answerModules = json_decode($valueReview->answer, true);
    
             if(isset($answerModules)){
               foreach ($answerModules as $keyModule => $valueModule) {
                 foreach ($valueModule['questions'] as $keyQuestion => $question) {
                    
                    $questionValue = "";
                    
                    if(isset($question['value'])){
                        
                        switch ($question['type']) {
                        case 'radio-group':
                            foreach ($question['values'] as $keyOption => $valueOption) {
                                if($valueOption['value']==$question['value']){
                                    $questionValue = $valueOption['label'];
                                }
                             }
                            break;
                        case 'select':
                             foreach ($question['values'] as $keyOption => $valueOption) {
                                if($valueOption['value']==$question['value']){
                                    $questionValue = $valueOption['label'];
                                }

                             }
                            break;
                         default:
                            $questionValue = $question['value'];
                            break;
                       }
                                           }
    
                    if(isset($question['name']) && isset($questionIndex[$question['name']])){
                      $indexResult = $questionIndex[$question['name']];
                      $this->_activeSheet->setCellValue($indexAlpha[$indexResult].$this->_indexFila, $questionValue);
                    }
    
                 }
               }
             }
             $this->_indexFila++;
         }
         
       }
     }

     $nombreDelDocumento = "matriz_evaluacion_".date('Y-m-d H:i:s').".xlsx";

     $writer = new Xlsx($this->_documento);

   //  header("Content-Type: application/vnd.ms-excel");
   //  return redirect(url('/')."/reportes/".$nombreDelDocumento);

     try {

       // Get the writer and export in memory.
       $response = new StreamedResponse(
           function () use ($writer) {
               $writer->save('php://output');
           }
       );
       $response->headers->set('Content-Type', 'application/vnd.ms-excel');
       $response->headers->set('Content-Disposition', 'attachment;filename="'.$nombreDelDocumento.'"');
       $response->headers->set('Cache-Control', 'max-age=0');
       return $response;

     } catch (\Exception $e) {
         print($e->getMessage());
     }
   }

   public function auditMatrix($elementId)
   {

     $process = \App\Models\Process::find($elementId);

     $this->_documento = new Spreadsheet();
     $this->_documento
         ->getProperties()
         ->setCreator("Asociación Colombiana Para el Avance de la Ciencia")
         ->setTitle('Informe');

     $this->_activeSheet = $this->_documento->getActiveSheet();

     $this->_indexFila = 1;

     $this->_activeSheet->setCellValue("A".$this->_indexFila, "Proceso");
     $this->_activeSheet->setCellValue("B".$this->_indexFila, $process->name);

     $this->_indexFila++;
     $this->_indexFila++;

     $this->_activeSheet->setCellValue("A".$this->_indexFila, 'Nº');
     $this->_activeSheet->setCellValue("B".$this->_indexFila, 'Código proyecto');
     $this->_activeSheet->setCellValue("C".$this->_indexFila, 'Par');
     $this->_activeSheet->setCellValue("D".$this->_indexFila, 'Nombre proyecto');
     $this->_activeSheet->setCellValue("E".$this->_indexFila, 'Evaluador(a)');
     $this->_activeSheet->setCellValue("F".$this->_indexFila, 'Fecha Evaluación');
     $this->_activeSheet->setCellValue("G".$this->_indexFila, 'Concepto General');
     $this->_activeSheet->setCellValue("H".$this->_indexFila, 'Puntaje Final');
     $this->_activeSheet->setCellValue("I".$this->_indexFila, 'Miembro Cómite');
     $this->_activeSheet->setCellValue("J".$this->_indexFila, '¿Considera necesario asignar un nuevo evaluador?');
     $this->_activeSheet->setCellValue("K".$this->_indexFila, 'Calificación del perfil del par (1 - 5 siendo 5 la máxima nota)');
     $this->_activeSheet->setCellValue("L".$this->_indexFila, 'Concepto sobre el perfil del par ');
     $this->_activeSheet->setCellValue("M".$this->_indexFila, 'Calificación lde la evaluación (1 - 5 siendo 5 la máxima nota)');
     $this->_activeSheet->setCellValue("N".$this->_indexFila, 'Concepto sobre la evaluación');
     $this->_activeSheet->setCellValue("O".$this->_indexFila, 'Acepta la evaluación sin modificaciones');
     $this->_activeSheet->setCellValue("P".$this->_indexFila, 'En caso de responder no, ¿cuales son las solicitudes de ajustes para el evaluador?. Por favor escriba el mensaje que el par evaluador recibirá.');
     $this->_activeSheet->setCellValue("Q".$this->_indexFila, 'Comentarios para Informe Final');

     $this->_indexFila++;

     foreach ($process->getProjects as $keyProject => $valueProject) {
       foreach ($valueProject->getProjecReviews as $keyReview => $valueReview) {
         $this->_activeSheet->setCellValue("A".$this->_indexFila, $valueReview->id);
         $this->_activeSheet->setCellValue("B".$this->_indexFila, $valueReview->getProject->code);
         $this->_activeSheet->setCellValue("C".$this->_indexFila, $valueReview->par);
         $this->_activeSheet->setCellValue("D".$this->_indexFila, $valueReview->getProject->name);
         $this->_activeSheet->setCellValue("E".$this->_indexFila, @$valueReview->getReviewer->name);
         $this->_activeSheet->setCellValue("F".$this->_indexFila, $valueReview->reviewDate);
         $this->_activeSheet->setCellValue("G".$this->_indexFila, $valueReview->concept);
         $this->_activeSheet->setCellValue("H".$this->_indexFila, $valueReview->result);
        
        foreach ($valueReview->audit as $keyAudit => $valueAudit) {
            $this->_activeSheet->setCellValue("I".$this->_indexFila, $valueAudit->getCommittee->name);
            $this->_activeSheet->setCellValue("J".$this->_indexFila, $valueAudit->newReviewer);
            $this->_activeSheet->setCellValue("K".$this->_indexFila, $valueAudit->reviewerRating);
            $this->_activeSheet->setCellValue("L".$this->_indexFila, $valueAudit->reviewerConcept);
            $this->_activeSheet->setCellValue("M".$this->_indexFila, $valueAudit->reviewRating);
            $this->_activeSheet->setCellValue("N".$this->_indexFila, $valueAudit->reviewConcept);
            $this->_activeSheet->setCellValue("O".$this->_indexFila, $valueAudit->reviewCompleted);
            $this->_activeSheet->setCellValue("P".$this->_indexFila, $valueAudit->reviewSettings);
            $this->_activeSheet->setCellValue("Q".$this->_indexFila, $valueAudit->finalComments);
        }

         $this->_indexFila++;
       }
     }

     $nombreDelDocumento = "matriz_comite_".date('Y-m-d H:i:s').".xlsx";

     $writer = new Xlsx($this->_documento);

   //  header("Content-Type: application/vnd.ms-excel");
   //  return redirect(url('/')."/reportes/".$nombreDelDocumento);

     try {

       // Get the writer and export in memory.
       $response = new StreamedResponse(
           function () use ($writer) {
               $writer->save('php://output');
           }
       );
       $response->headers->set('Content-Type', 'application/vnd.ms-excel');
       $response->headers->set('Content-Disposition', 'attachment;filename="'.$nombreDelDocumento.'"');
       $response->headers->set('Cache-Control', 'max-age=0');
       return $response;

     } catch (\Exception $e) {
         print($e->getMessage());
     }
   }


   public function getUnisonoProjects(Request $request){

       //$idElement = $request->id;

      try {
          $client = new \GuzzleHttp\Client();
          $url = "https://unisono-acac.com/api/proyectos/lista";

          $apiResponse = $client->request('GET', $url, [
              'verify'  => false,
          ]);

          $response['data'] = json_decode($apiResponse->getBody());
          $response['success'] = true;

      } catch (\Exception $e) {

          $response['message'] = $e->getMessage();
          $response['success'] = false;
      }

      return $response;
    }

    public function getUnisonoBudgets(Request $request){

        //$idElement = $request->id;

       try {
           $client = new \GuzzleHttp\Client();
           $url = "https://unisono-acac.com/api/presupuestos/lista/".$request->id;

           $apiResponse = $client->request('GET', $url, [
               'verify'  => false,
           ]);

           $response['data'] = json_decode($apiResponse->getBody());
           $response['success'] = true;

       } catch (\Exception $e) {

           $response['message'] = $e->getMessage();
           $response['success'] = false;
       }

       return $response;
     }

    public function paymentAvailable(Request $request)
     {
       try {
         $process = \App\Models\Process::find($request->id);
         
         if($process->getFeeReview && $process->project_unisono_id && $process->budget_reviewer_id){
           $process->update(['paymentState'=>'habilitado']);

           $reviews = \App\Models\ProjectReview::where('process', $request->id)->where('state', 'Evaluado')->where('paymentState', 'Inactivo')->get();

           //Enviar correos

           $notification['subject'] = 'Cafeto - Cuenta de Cobro Habilitada';

           foreach($reviews as $keyReview => $valueReview){

             $notification['elementId'] = $valueReview->id;
             $notification['message'] = "Se ha habilitado la cuenta de cobro para la evaluación ".$valueReview->getProject->name." para el proceso ".$valueReview->getProject->getProcess->name.". Ingrese al menú Evaluaciones para registrar su cuenta de cobro.
             <br><br><a class='btn' href='https://www.cafeto.cimaonline.com.co'>https://www.cafeto.cimaonline.com.co</a>";

             if($valueReview->getReviewer->email){
                $notification['emails'] = [$valueReview->getProject->getProcess->getResponsible->email, $valueReview->getReviewer->email];
                $this->mailSend($notification);
             }

             $valueReview->update(['paymentState' => 'Activo']);

           }

           $response['data'] = json_decode($process);
           $response['success'] = true;
         }else{
           $response['message'] = "El proceso no cuenta con tarifa establecida y configuración para Unísono.";
           $response['success'] = false;
         }



       } catch (\Exception $e) {

         $response['message'] = $e->getMessage();
         $response['success'] = false;
       }

       return $response;

     }

     /* EVIO DE NOTIFICACIONES */

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

     public function reviewList(Request $request){

       $model = ucwords($request->modelName);
       $className = "\App\Models\\$model";
       $module = $request->moduleName;
       $max = 20;
       $page = ($request->page) ? $request->page : 1;

       $arrayFilters = array();

       if($request->filters){
         $filters = json_decode($request->filters);
         foreach ($filters as $keyFilter => $valueFilter) {
           $arrayFilters[] = [$valueFilter[0], 'like', "%$valueFilter[1]%"];
         }
       }

       if($request->prefilter){
         $prefilter = json_decode($request->prefilter);
         foreach ($prefilter as $keyFilter => $valueFilter) {
           $arrayFilters[] = [$keyFilter, '=', "$valueFilter"];
         }

       }

        try {

          $data = \App\Models\ProjectReview::where($arrayFilters)->where('process', $request->id)->skip(($page - 1)*$max)->take($max)->get();
          $dataTotal = \App\Models\ProjectReview::where($arrayFilters)->where('process', $request->id)->count();

          $pagesTotal = ceil($dataTotal/$max);

          $dataModule = \App\Models\Module::whereRaw( "LOWER(moduleName) LIKE ?", 'evaluaciones')->first();
          foreach ($data as $key => $value) {
            if(!$value->feeCustom){
                if($value->getProject->feeCustom){
                    $value->feeCustom = $value->getProject->feeCustom;
                }elseif($value->getProject->getProcess->getFeeReview){
                    $value->feeCustom = $value->getProject->getProcess->getFeeReview->price;
                }
            }
            
            foreach (json_decode($dataModule->fields) as $keyF => $valueF) {
              if($valueF->type=="select" && $valueF->origin=="model"){
                $value->{$valueF->alias};
              }
            }
          }

          $response['data'] = $data;
          $response['total'] = $dataTotal;
          $response['pagesTotal'] = $pagesTotal;
          $response['success'] = true;

      } catch (\Exception $e) {
        $response['message'] = $e->getMessage();
        $response['success'] = false;
      }
      return $response;

    }


    public function reviewListMaxBudget(Request $request){

    
      return view('process.crud.main');
    

   }



    

}
