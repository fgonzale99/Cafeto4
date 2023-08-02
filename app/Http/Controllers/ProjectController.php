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


class ProjectController extends Controller
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

    public function list()
    {
      $elements = \App\Models\Project::orderBy('id','DESC')->paginate(20);
      return view('project.list', compact('elements'));
    }

    public function new()
    {
      return view('crud.main');
    }

    public function edit()
    {
      return view('crud.main');
    }

    public function reviewer()
    {
      return view('crud.main');
    }

    public function board(){
      return view('crud.main');
    }

    public function show()
    {
      $element = \App\Models\Project::where('id', 20)->first();
      $units = \App\Models\ReviewUnit::where('idProyecto', 1033)->get();
      $forms = \App\Models\Form::get();


      return view('project.show', compact('element','units','forms'));
    }

    public function reviewerAssign(Request $request)
    {


      try {

        //Comprobar si el evaluador no ya existe para este proyecto
        $reviewExist = \App\Models\ProjectReview::where('project', '=', $request->project)->where('reviewer', '=', $request->reviewer)->first();

        if(isset($reviewExist)){

          $response['message'] = "El evaluador ya se encuentra asignado a esta evaluación.";
          $response['data'] = '';
          $response['success'] = false;

        }else{

          $project = \App\Models\Project::find($request->project);

          $insert['project'] = $request->project;
          $insert['process'] = $project->process;
          $insert['reviewer'] = $request->reviewer;
          $insert['par'] = $request->par;
          $insert['daysLimit'] = $request->daysLimit;
          $insert['assignDate'] = date('Y-m-d');
          $insert['state'] = 'Inactivo';

          $className = "\App\Models\ProjectReview";
          $element = ("{$className}::create")($insert);

          $notification['elementId'] = $element->id;
          $notification['subject'] = 'Cafeto - Nueva Evaluación Asignada';
          $notification['message'] = "Ha sido asignado como evaluador del documento ".$element->getProject->name." para el proceso ".$element->getProject->getProcess->name.", el plazo de evaluación es ".$element->daysLimit." días. Ingrese al menú evaluaciones para empezar a evaluar.
          <br><br><a class='btn' href='https://www.cafeto.cimaonline.com.co'>https://www.cafeto.cimaonline.com.co</a>";
          $notification['emails'] = $element->getReviewer->email;

          $this->notify($notification);
          $this->reviewLog($notification);
          $this->mailSend($notification);

          $notification['emails'] = $element->getProject->getProcess->getResponsible->email;
          $this->mailSend($notification);

          $response['message'] = "Form recorded.";
          $response['data'] = $element;
          $response['success'] = true;
        }

      } catch (\Exception $e) {
        $response['message'] = $e->getMessage();
        $response['success'] = false;
      }

      return $response;
    }

    public function reviewerUnassign()
    {
      $actividad = \App\Models\ActividadUnidad::where('idUnidad', 5561)->get();
      return view('evaluacion.cronologia', compact('actividad'));
    }

    public function reviewerAccept()
    {
      $actividad = \App\Models\ActividadUnidad::where('idUnidad', 5561)->get();
      return view('evaluacion.cronologia', compact('actividad'));
    }


    public function cronology()
    {
      $actividad = \App\Models\ActividadUnidad::where('idUnidad', 5561)->get();
      return view('evaluacion.cronologia', compact('actividad'));
    }

    public function notify($data)
    {
      $insert['name'] = 'Nuevo Documento para Evaluar';
      $insert['message'] = $data['message'];
      $insert['model'] = 'Proyectos';
      $insert['event'] = 'Asignación Evaluador';
      $insert['elementId'] = $data['elementId'];
      $insert['date'] = date('Y-m-d');
      $insert['user'] = 1;

      $className = "\App\Models\Notification";
      $element = ("{$className}::create")($insert);
    }

    public function reviewLog($data)
    {
      $insert['projectReview'] = $data['elementId'];
      $insert['description'] = $data['message'];
      $insert['event'] = $data['subject'];
      $insert['date'] = date('Y-m-d');

      $className = "\App\Models\ProjectReviewLog";
      $element = ("{$className}::create")($insert);
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

    public function reviewsMatrix($elementId)
    {

      $project = "\App\Models\Project"::find($elementId);

      $modules = json_decode($project->getFormreview->form, true);

      $indexAlpha = range('A', 'Z');

      //'Título Proceso'

      //'Nº'
      //'Código proyecto'
      //'Par'
      //'Nombre proyecto'
      //'Evaluador(a)'
      //'Fecha Evaluación'

      //'Concepto General'
      //'Puntaje final'

      $this->_documento = new Spreadsheet();
      $this->_documento
          ->getProperties()
          ->setCreator("Asociación Colombiana Para el Avance de la Ciencia")
          ->setTitle('Informe');

      $this->_activeSheet = $this->_documento->getActiveSheet();

      $this->_indexFila = 1;

      $this->_activeSheet->setCellValue("A".$this->_indexFila, "Proceso");
      $this->_activeSheet->setCellValue("B".$this->_indexFila, $project->getProcess->name);

      $this->_indexFila++;
      $this->_indexFila++;

      $this->_activeSheet->setCellValue("A".$this->_indexFila, 'Nº');
      $this->_activeSheet->setCellValue("B".$this->_indexFila, 'Código proyecto');
      $this->_activeSheet->setCellValue("C".$this->_indexFila, 'Par');
      $this->_activeSheet->setCellValue("D".$this->_indexFila, 'Nombre proyecto');
      $this->_activeSheet->setCellValue("E".$this->_indexFila, 'Evaluador(a)');
      $this->_activeSheet->setCellValue("F".$this->_indexFila, 'Fecha Evaluación');
      $this->_activeSheet->setCellValue("G".$this->_indexFila, 'Concepto General');
      $this->_activeSheet->setCellValue("H".$this->_indexFila, 'Puntaje final');

      $this->_indexColumn = 8;

      foreach ($modules as $keyModule => $valueModule) {

            foreach ($valueModule['questions'] as $keyQuestion => $question) {
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

      $this->_indexFila++;

      $reviews = "\App\Models\ProjectReview"::where('project', '=', $elementId)->get();

      foreach ($reviews as $keyReview => $valueReview) {
        if(isset($valueReview->answer)){
          $this->_activeSheet->setCellValue("A".$this->_indexFila, $valueReview->id);
          $this->_activeSheet->setCellValue("B".$this->_indexFila, $valueReview->getProject->code);
          $this->_activeSheet->setCellValue("C".$this->_indexFila, '');
          $this->_activeSheet->setCellValue("D".$this->_indexFila, $valueReview->getProject->name);
          $this->_activeSheet->setCellValue("E".$this->_indexFila, $valueReview->getReviewer->name);
          $this->_activeSheet->setCellValue("F".$this->_indexFila, $valueReview->reviewDate);
          $this->_activeSheet->setCellValue("G".$this->_indexFila, $valueReview->concept);
          $this->_activeSheet->setCellValue("H".$this->_indexFila, $valueReview->result);

          $answerModules = json_decode($valueReview->answer, true);
          foreach ($answerModules as $keyModule => $valueModule) {
            foreach ($valueModule['questions'] as $keyQuestion => $question) {
               $questionValue = "";
               if(isset($question['value'])){
                  $questionValue = $question['value'];
               }

               if(isset($question['name'])){
                 $indexResult = $questionIndex[$question['name']];
                 $this->_activeSheet->setCellValue($indexAlpha[$indexResult].$this->_indexFila, $questionValue);
               }

            }
          }
          $this->_indexFila++;
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


    public function reviewerChange(Request $request)
    {

      try {

        $element = \App\Models\ProjectReview::find($request->id);

        $notification['elementId'] = $element->id;
        $notification['subject'] = 'Cafeto - Solicitud Cambio de Evaluador';
        $notification['message'] = "El cliente solicita el cambio del evaluador ".$element->getReviewer->name." del documento ".$element->getProject->name." para el proceso ".$element->getProject->getProcess->name.", el plazo de evaluación es ".$element->daysLimit." días.";
        $notification['emails'] = $element->getReviewer->email;

        $this->notify($notification);
        $this->reviewLog($notification);
        //$this->mailSend($notification);

        //$notification['emails'] = $element->getProject->getProcess->getResponsible->email;
        //$this->mailSend($notification);


        $response['message'] = "Form recorded.";
        $response['data'] = $element;
        $response['success'] = true;

      } catch (\Exception $e) {
        $response['message'] = $e->getMessage();
        $response['success'] = false;
      }

      return $response;
    }


}
