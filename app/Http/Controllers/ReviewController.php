<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Mail;
use GuzzleHttp\Psr7;

class ReviewController extends Controller
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

    public function lista()
    {
      $actividad = \App\Models\ActividadUnidad::where('idUnidad')->get();
      return view('evaluacion.cronologia', compact('actividad'));
    }

    public function cronology()
    {
      $actividad = \App\Models\ActividadUnidad::where('idUnidad', 5615)->get();
      return view('review.cronology', compact('actividad'));
    }

    public function form(Request $request)
    {
      return view('crud.main');
    }

    public function start(Request $request)
    {
      return view('crud.main');
    }

    public function eval(Request $request)
    {
      return view('crud.main');
    }

    public function summary(Request $request)
    {
      return view('crud.main');
    }

    public function finish(Request $request)
    {
      return view('crud.main');
    }

    public function list(Request $request)
    {
      return view('crud.main');
    }

    public function auditAssign(Request $request)
    {
      return view('crud.main');
    }

    public function auditAssignEdit(Request $request)
    {
      return view('crud.main');
    }

    public function editAssign(Request $request)
    {
      return view('crud.main');
    }

    public function paymentProfile(Request $request)
    {
      return view('crud.main');
    }

    public function paymentRequest(Request $request)
    {
      return view('crud.main');
    }

    public function reviewAudit(Request $request)
    {
      return view('crud.main');
    }

    public function reviewBoard(Request $request)
    {
      return view('crud.main');
    }

    public function pageGet(Request $request){
      $model = ucwords($request->modelName);
      $reviewId = $request->reviewId;
      $idPage = $request->page;

      $className = "\App\Models\\$model";

      try {

          //Construir Pagina
          $review = ("{$className}::find")($reviewId);

          //revisar si la pagina ya esta evaluada
          if($review['answer']==""){
            $data = json_decode($review->getProject->getFormreview->form, true);
            $response['form'] = $data[$idPage]['questions'];
            $response['success'] = true;

          }else{
            $data = json_decode($review->answer, true);

            if(isset($data[$idPage])){
              $response['form'] = $data[$idPage]['questions'];
              $response['success'] = true;
            }else{
              $data = json_decode($review->getProject->getFormreview->form, true);
              $response['form'] = $data[$idPage]['questions'];
              $response['success'] = true;
            }

          }


        } catch (\Exception $e) {
          $response['message'] = $e->getMessage();
          $response['success'] = true;
        }

       return $response;
   }

    public function pageSave(Request $request)
    {
      $model = ucwords($request->params['modelName']);
      $idElement = $request->params['id'];
      $idPage = $request->params['page'];
      $formData = $request->params['formData'];

      try {

          $review = "\App\Models\ProjectReview"::find($idElement);

          if($review['answer']==""){

            $data = json_decode($review->getProject->getFormreview->form, true);
            $questions = $data[$idPage]['questions'];

            //Array de preguntas
            foreach ($questions as $keyQuestion => $valueQuestion) {
              //array de respuestas
              foreach ($formData as $keyData => $valueData) {
                if(isset($valueQuestion['name'])  && $valueQuestion['name'] == $valueData['name']) $valueQuestion['value'] = $valueData['value'];
              }
              $questions[$keyQuestion] = $valueQuestion;
            }

            $reviewAnswer[$idPage]['questions'] = $questions;
            $reviewAnswer[$idPage]['pageName'] = $data[$idPage]['pageName'];
            $reviewAnswer[$idPage]['state'] = $data[$idPage]['state'];

            $answer['answer'] = json_encode($reviewAnswer);

          }else{

              $reviewAnswer = json_decode($review->answer, true);
              $data = json_decode($review->getProject->getFormreview->form, true);

              if(isset($reviewAnswer[$idPage])){

                $questions = $data[$idPage]['questions'];
                foreach ($questions as $keyReview => $valueReview) {
                  //array de respuestas
                  foreach ($formData as $keyData => $valueData) {

                    if(isset($valueReview['name'])  && $valueReview['name'] == $valueData['name']) {
                      $valueReview['value'] = $valueData['value'];
                    }
                  }
                  $questions[$keyReview] = $valueReview;
                }

                $reviewAnswer[$idPage]['questions'] = $questions;
                $reviewAnswer[$idPage]['pageName'] = $data[$idPage]['pageName'];
                $reviewAnswer[$idPage]['state'] = $data[$idPage]['state'];
                $answer['answer'] = json_encode($reviewAnswer);

              }else{

                $data = json_decode($review->getProject->getFormreview->form, true);
                $questions = $data[$idPage]['questions'];

                //Array de preguntas
                foreach ($questions as $keyQuestion => $valueQuestion) {
                  //array de respuestas
                  foreach ($formData as $keyData => $valueData) {
                    if(isset($valueQuestion['name'])  && $valueQuestion['name'] == $valueData['name']) $valueQuestion['value'] = $valueData['value'];
                  }
                  $questions[$keyQuestion] = $valueQuestion;
                }

                $reviewAnswer[$idPage]['questions'] = $questions;
                $reviewAnswer[$idPage]['pageName'] = $data[$idPage]['pageName'];
                $reviewAnswer[$idPage]['state'] = $data[$idPage]['state'];
                $answer['answer'] = json_encode($reviewAnswer);
              }

          }

          $review->update($answer);
          $this->setResult($review->id);
          $this->setProcess($review->id);

          $response['message'] = "Form recorded.";
          $response['success'] = true;

        } catch (\Exception $e) {
          $response['message'] = $e->getMessage();
          $response['success'] = false;
        }

        return $response;
    }

    public function reportStandard(Request $request)
    {
      $mpdf = new \Mpdf\Mpdf();

      $review = "\App\Models\ProjectReview"::find($request->id);
      $reviewAnswer = json_decode($review->answer, true);

/*
     if(in_array($review->getProject->formReview, [42,43,44,45])) return redirect()->route('review.report.custom', ['id' => $request->id]);
     if(in_array($review->getProject->formReview, [46])) return redirect()->route('review.report.custom2', ['id' => $request->id]);
     if(in_array($review->getProject->formReview, [60,61])) return redirect()->route('review.report.custom2', ['id' => $request->id]);
*/

      //Format
      $formatId = env('REPORTE_STANDAR_ID'); //5 ;// isset($review->getProject->formatReview) ? $review->getProject->formatReview : '5';
      $format = \App\Models\FormatReview::find($formatId);

      $contentModules = "";

      $arrayValues['nombreProyecto'] = $review->getProject->name;
      $arrayValues['nombreProceso'] = $review->getProject->getProcess->name;
      $arrayValues['nombreCliente'] = $review->getProject->getProcess->getCustomer->name;
      $arrayValues['puntaje'] = $review->result;


      foreach ($reviewAnswer as $keyPage => $valuePage) {

        $contentModules .= "<table border='1' width='100%' cellspacing='0' cellpadding='5' style='overflow: wrap'>";
        $contentModules .= "<tr><td align='center' colspan='2'>".$valuePage['pageName']."</tr></td>";

        foreach ($valuePage['questions'] as $keyQuestion => $question) {

           switch ($question['type']) {
             case 'header':
                  $contentModules .= "<tr><td align='center' colspan='2'>".$question['label']."</td></tr>";
               break;
             case 'text':
                  $contentModules .= "<tr><td>";
                  $contentModules .= $question['label'];
                  $contentModules .= "</td><td align='justify'>";
                  $contentModules .= $question['value'];
                  $contentModules .= "</td></tr>";
               break;
             case 'number':
                 $contentModules .= "<tr><td>";
                 $contentModules .= $question['label'];
                 $contentModules .= "</td><td>";
                 $contentModules .= $question['value'];
                 $contentModules .= "</td></tr>";
               break;
             case 'paragraph':
                  $contentModules .= "<tr><td colspan='2' align='justify' class='sinborde'>".$question['label']."</td></tr>";
                break;
             case 'textarea':
                 $contentModules .= "<tr><td>";
                 $contentModules .= $question['label'];
                 $contentModules .= "</td><td align='justify'>";
                 if(isset($question['value'])) $contentModules .= $question['value'];
                 $contentModules .= "</td></tr>";
                break;
             case 'date':
                 $contentModules .= "<tr><td>";
                 $contentModules .= $question['label'];
                 $contentModules .= "</td><td>";
                 $contentModules .= $question['value'];
                 $contentModules .= "</td></tr>";
                break;
            case 'radio-group':
                 $contentModules .= "<tr><td>";
                 $contentModules .= $question['label'];
                 $contentModules .= "</td><td><ul>";

                 foreach ($question['values'] as $keyOption => $valueOption) {
                    if($valueOption['value']==$question['value']){

                      $contentModules .= "<li>".$valueOption['label']."</li>";
                    }
                    /*else{
                      $contentModules .= "<li>".$valueOption['label']."</li>";
                    }*/

                 }
                 $contentModules .= "</ul></td></tr>";
                break;
            case 'select':
                 $contentModules .= "<tr><td width='50%'>";
                 $contentModules .= $question['label'];
                 $contentModules .= "</td><td><ul>";

                 foreach ($question['values'] as $keyOption => $valueOption) {
                    if($valueOption['value']==$question['value']){
                      $contentModules .= "<li>".$valueOption['label']."</li>";
                    }
                 }
                 $contentModules .= "</ul></td></tr>";
                break;
             default:
                 $contentModules .= "<tr><td>";
                 $contentModules .= $question['label'];
                 $contentModules .= "</td></tr>";
               break;
           }
        }

        $contentModules .= "</table>";
      }

      $arrayValues['contenidoEvaluacion'] =$contentModules;

      $cabecera = '';
      $footer = '';

      foreach ($arrayValues as $keyC => $valueC) {
        $titulos[] = '{{$'.$keyC.'}}';
        $valores[] = $valueC;
      }

      $content = str_replace($titulos, $valores, $format->content);

  /*    $content .=  $contentModules;

      $content .= '<table><tbody>';

      $finalComents = '';
      $result = 0;
      if(isset($review->result) && $review->result > 0) $result = $review->result;


      $content .='<tr>
      <td><div style="text-align: justify;">Recomendación Final</div></td>
      <td><div style="text-align: justify;">'.$finalComents.'</div></td>
      </tr>

      <tr><td>Puntaje total (cuando aplique)</td><td>'.$result.'</td></tr>
      </tbody></table>';
*/
      $content = '<body>'.$content.'</body>';
      $footer = $format->footer.'Página: {PAGENO} de {nbpg}';

      $header = '
          <style>
            @page {
              margin: 80px 80px;
              margin-top: 30px;
              font-size: 9px;
              background-repeat: no-repeat;
              background-position: top left;
              header: AvancienciaHeader;
              footer: AvancienciaFooter;
              margin-header: 10px;
            }
            body{
                text-align: justify;
            }
            .sinborde{
                border: 0px;
            }
            td{
                padding: 12px;
            }

          </style>';

      $mpdf->DefHTMLHeaderByName('AvancienciaHeader', $cabecera);
      $mpdf->DefHTMLFooterByName('AvancienciaFooter', $footer);

      $mpdf->WriteHTML($header.$content);

      $nombreArchivo = date('Ymdhi').'.pdf';

      // Descargar o almacenar documento de salida
      $mpdf->Output();
    }

    public function reportCustom(Request $request)
    {
      $mpdf = new \Mpdf\Mpdf();

      $review = "\App\Models\ProjectReview"::find($request->id);
      $reviewAnswer = json_decode($review->answer, true);


      //Format
      $formatId = isset($review->getProject->formatReview) ? $review->getProject->formatReview : '5';
      $format = \App\Models\FormatReview::find($formatId);

      $contentModules = "";

      $arrayValues['nombreProyecto'] = $review->getProject->name;
      $arrayValues['nombreProceso'] = $review->getProject->getProcess->name;
      $arrayValues['nombreCliente'] = $review->getProject->getProcess->getCustomer->name;
      $arrayValues['puntaje'] = $review->result;


      foreach ($reviewAnswer as $keyPage => $valuePage) {

        $contentModules .= "<table border='1' width='100%' cellspacing='0' cellpadding='20' style='overflow: wrap'>";
        $contentModules .= "<tr><td align='center' colspan='2'><b>".$valuePage['pageName']."</b></tr></td>";

        foreach ($valuePage['questions'] as $keyQuestion => $question) {

           switch ($question['type']) {
             case 'header':
                  $contentModules .= "<tr><td align='center' colspan='2'><b>".$question['label']."</b></td></tr>";
               break;
             case 'text':
                  $contentModules .= "<tr><td>";
                  $contentModules .= $question['label'];
                  $contentModules .= "</td><td align='justify'>";
                  $contentModules .= $question['value'];
                  $contentModules .= "</td></tr>";
               break;
             case 'number':
                 $contentModules .= "<tr><td>";
                 $contentModules .= $question['label'];
                 $contentModules .= "</td><td>";
                 $contentModules .= $question['value'];
                 $contentModules .= "</td></tr>";
               break;
             case 'paragraph':
                  $contentModules .= "<tr class='sinborde'><td colspan='2' class='sinborde' align='justify'>".$question['label']."</td></tr>";
                break;
             case 'textarea':
                 $contentModules .= "<tr><td>";
                 $contentModules .= $question['label'];
                 $contentModules .= "</td><td align='justify'>";
                 if(isset($question['value'])) $contentModules .= $question['value'];
                 $contentModules .= "</td></tr>";
                break;
             case 'date':
                 $contentModules .= "<tr><td>";
                 $contentModules .= $question['label'];
                 $contentModules .= "</td><td>";
                 $contentModules .= $question['value'];
                 $contentModules .= "</td></tr>";
                break;
            case 'radio-group':
                 $contentModules .= "<tr><td>";
                 $contentModules .= $question['label'];
                 $contentModules .= "</td><td><ul>";

                 foreach ($question['values'] as $keyOption => $valueOption) {
                    if($valueOption['value']==$question['value']){
                      $contentModules .= "<li>".$valueOption['label']."</li>";
                    }
                 }
                 $contentModules .= "</ul></td></tr>";
                break;
            case 'select':
                 $contentModules .= "<tr><td width='50%'>";
                 $contentModules .= $question['label'];
                 $contentModules .= "</td><td><ul>";

                 foreach ($question['values'] as $keyOption => $valueOption) {
                    if($valueOption['value']==$question['value']){
                      $contentModules .= "<li>".$valueOption['label']."</li>";
                    }
                 }
                 $contentModules .= "</ul></td></tr>";
                break;
             default:
                 $contentModules .= "<tr><td>";
                 $contentModules .= $question['label'];
                 $contentModules .= "</td></tr>";
               break;
           }
        }

        $contentModules .= "</table>";
      }

      $arrayValues['contenidoEvaluacion'] =$contentModules;

      $cabecera = '';
      $footer = '';




      foreach ($arrayValues as $keyC => $valueC) {
        $titulos[] = '{{$'.$keyC.'}}';
        $valores[] = $valueC;
      }

      $content = str_replace($titulos, $valores, $format->content);

  /*    $content .=  $contentModules;

      $content .= '<table><tbody>';

      $finalComents = '';
      $result = 0;
      if(isset($review->result) && $review->result > 0) $result = $review->result;


      $content .='<tr>
      <td><div style="text-align: justify;">Recomendación Final</div></td>
      <td><div style="text-align: justify;">'.$finalComents.'</div></td>
      </tr>

      <tr><td>Puntaje total (cuando aplique)</td><td>'.$result.'</td></tr>
      </tbody></table>';
*/
      $content = '<body>'.$content.'</body>';
      $footer = $format->footer.'Página: {PAGENO} de {nbpg}';

      $header = '
          <style>
            @page {
              margin: 80px 80px;
              margin-top: 30px;
              font-size: 9px;
              background-repeat: no-repeat;
              background-position: top left;
              header: AvancienciaHeader;
              footer: AvancienciaFooter;
              margin-header: 10px;
            }
            body{
                text-align: justify;
            }
            .sinborde{
                border: 0px;
            }
            td{
                padding: 12px;
            }

          </style>';

      $mpdf->DefHTMLHeaderByName('AvancienciaHeader', $cabecera);
      $mpdf->DefHTMLFooterByName('AvancienciaFooter', $footer);

      $mpdf->WriteHTML($header.$content);

      $nombreArchivo = date('Ymdhi').'.pdf';

      // Descargar o almacenar documento de salida
      $mpdf->Output();
    }


    public function pagesList(Request $request)
    {
      $idElement = $request->id;

      try {

          //Construir Pagina
          $formReview = "\App\Models\FormReview"::find($idElement);

          $pages = json_decode($formReview->form, true);

          if($pages){
            foreach ($pages as $keyP => $valueP) {
                $pages[$keyP]['page'] = $keyP;
            }
          }else{
            $pages = [];
          }

          $response['pages'] = $pages;
          $response['success'] = true;

        } catch (\Exception $e) {
          $response['message'] = $e->getMessage();
          $response['success'] = true;
        }

       return $response;
    }

    public function get(Request $request)
    {
      $elementId = $request->id;

      try {

          //Construir Pagina
          $formReview = "\App\Models\ProjectReview"::find($elementId);

          $data = json_decode($formReview->answer, true);

          $pages = [];

          foreach ($data as $keyP => $valueP) {
            $pages[] = $valueP;
          }

          $response['form']['pages'] = $pages;
          $response['success'] = true;

        } catch (\Exception $e) {
          $response['message'] = $e->getMessage();
          $response['success'] = true;
        }

       return $response;
    }

    public function setResult($elementId){

      $review = "\App\Models\ProjectReview"::find($elementId);
      $reviewAnswer = json_decode($review->answer, true);

      $result = 0;

      foreach ($reviewAnswer as $keyPage => $valuePage) {

        foreach ($valuePage['questions'] as $keyQuestion => $question) {

           switch ($question['type']) {
             case 'number':
                  $ponderacion = isset($question['ponderacion']) ? $question['ponderacion'] : 1;
                  $result = $result + $question['value']*$ponderacion;
               break;
             case 'radio-group':
                 foreach ($question['values'] as $keyOption => $valueOption) {
                    if($question['value']==$valueOption['value'] && is_numeric($valueOption['value']))  $result = $result + $valueOption['value'];
                 }
                break;
           }
        }
      }

      $data['result'] = $result;

      $review->update($data);

      return true;

    }

    public function setProcess($elementId){

      $review = "\App\Models\ProjectReview"::find($elementId);

      $progress = 0;
      $answers = json_decode($review->answer, true);
      $totalAnswers = count($answers);
      $pages = json_decode($review->getProject->getFormreview->form, true);
      $totalPages = count($pages);

      if($totalPages > 0) $progress = ($totalAnswers/$totalPages)*100;
      $data['progress'] = $progress;

      $review->update($data);

      return true;

    }

    public function accept(Request $request){

      $elementId = $request->id;

      try {

          //Construir Pagina
          $review = "\App\Models\ProjectReview"::find($elementId);

          $data['state'] = 'Activo';
          $review->update($data);

          $notification['elementId'] = $elementId;
          $notification['subject'] = 'Cafeto - Evaluación Aceptada';
          $notification['message'] = "La evaluación ha sido aceptada ".$review->getProject->name." para el proceso ".$review->getProject->getProcess->name;

          $this->notify($notification);
          $this->reviewLog($notification);

          $response['success'] = true;

        } catch (\Exception $e) {
          $response['message'] = $e->getMessage();
          $response['success'] = false;
        }

       return $response;

    }

    public function decline(Request $request){

      $elementId = $request->id;

      try {

          //Construir Pagina
          $review = "\App\Models\ProjectReview"::find($elementId);

          $data['state'] = 'Declinado';
          $review->update($data);

          $notification['elementId'] = $elementId;
          $notification['subject'] = 'Cafeto - Evaluación Declinada.';
          $notification['message'] = "La evaluación ha sido rechazada ".$review->getProject->name." para el proceso ".$review->getProject->getProcess->name;

          $this->notify($notification);
          $this->reviewLog($notification);

          $response['success'] = true;

        } catch (\Exception $e) {
          $response['message'] = $e->getMessage();
          $response['success'] = false;
        }

       return $response;

    }

    public function notify($data)
    {
      $insert['name'] = 'Inicio de Evaluación';
      $insert['message'] = $data['message'];
      $insert['model'] = 'Evaluacións';
      $insert['event'] = 'Inicio de Evaluación';
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

    public function getReview(Request $request){

      $elementId = $request->id;

       try {

         $data = \App\Models\ProjectReview::with('getProject')->with('getProject.getProcess')->with('getProject.getFormReview')->with('getProject.files')->with('getReviewer')->find($elementId);

         $response['data'] = $data;
         $response['success'] = true;

       } catch (\Exception $e) {
         $response['message'] = $e->getMessage();
         $response['success'] = false;
       }

       return $response;
   }

   public function track(){
     return view('crud.main');
   }

   public function getTrack(Request $request){

     $elementId = $request->id;

      try {

        $data = \App\Models\ProjectReviewLog::where('projectReview', $elementId)->get();

        $response['data'] = $data;
        $response['success'] = true;

      } catch (\Exception $e) {
        $response['message'] = $e->getMessage();
        $response['success'] = false;
      }

      return $response;
  }

  public function certificate(Request $request)
  {
    $review = "\App\Models\ProjectReview"::find($request->id);

    $mpdf = new \Mpdf\Mpdf();

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

    $urlCertificado = "https://www.cafeto.cimaonline.com.co/certificate/validate/".md5($review->id);

    $arrayValues['qrConsulta']  =  str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', QrCode::generate($urlCertificado));

    foreach ($arrayValues as $keyC => $valueC) {
      $titulos[] = '{{$'.$keyC.'}}';
      $valores[] = $valueC;
    }

    $content = str_replace($titulos, $valores, $format->content);

    $cabecera = '';
    $content = '<body>'.$content.'</body>';
    $footer = $format->footer.'Página: {PAGENO} de {nbpg}';

    $header = '
        <style>
          @page {
            margin: 30px 80px;
            font-size: 10px;
            background-repeat: no-repeat;
            background-position: top left;
            header: AvancienciaHeader;
            footer: AvancienciaFooter;
            margin-header: 25px;
          }
          body{
              text-align: justify;
          }

        </style>';

    $mpdf->DefHTMLHeaderByName('AvancienciaHeader', $cabecera);
    $mpdf->DefHTMLFooterByName('AvancienciaFooter', $footer);

    $mpdf->WriteHTML($header.$content);

    $nombreArchivo = date('Ymdhi').'.pdf';

    // Descargar o almacenar documento de salida
    $mpdf->Output();
  }

  public function finishSave(Request $request){

    $elementId = $request->id;

    try {

       if(isset($request->codeSignature) && $request->codeSignature!=Null){
         //Construir Pagina
         $review = "\App\Models\ProjectReview"::find($elementId);



         foreach ($request->all() as $key => $value) {
             if($key!=='model' && $key!=='id') $update[$key] = $value;
         };

         $update['state'] = 'Evaluado';
         $update['reviewDate'] = date('Y-m-d');
         $review->update($update);
         $review->save();


         //$notification['elementId'] = $elementId;
         //$notification['subject'] = 'Cafeto - Evaluación Aceptada';
         //$notification['message'] = "La evaluación ha sido aceptada ".$review->getProject->name." para el proceso ".$review->getProject->getProcess->name;

         //$this->notify($notification);
         //$this->reviewLog($notification);

         $response['success'] = true;

       }else{
         $response['message'] = 'La firma esta vacia.';
         $response['success'] = false;
       }


      } catch (\Exception $e) {
        $response['message'] = $e->getMessage();
        $response['success'] = false;
      }

     return $response;

  }

  public function ethicCode(Request $request)
  {

    $review = "\App\Models\ProjectReview"::find($request->id);

    $mpdf = new \Mpdf\Mpdf();

    $format = \App\Models\FormatReview::find(1);

    $arrayValues['idCodigoEtica'] = $review->id;
    $arrayValues['fechaFirma'] = $review->assignDate;
    $arrayValues['firmaCodigo'] = '<img src="'.$review->codeSignature.'" widht="80" height="80"/>';
    $arrayValues['nombreEvaluador'] = $review->getReviewer->name;
    $arrayValues['identificacion'] = $review->getReviewer->document;
    $arrayValues['tipoId'] = $review->getReviewer->documentType;

    foreach ($arrayValues as $keyC => $valueC) {
      $titulos[] = '{{$'.$keyC.'}}';
      $valores[] = $valueC;
    }

    $content = str_replace($titulos, $valores, $format->content);

    $cabecera = '';
    $content = '<body>'.$content.'</body>';
    $footer = $format->footer.'Página: {PAGENO} de {nbpg}';

    $header = '
          <style>
            @page {
              margin: 80px 80px;
              margin-top: 30px;
              font-size: 9px;
              background-repeat: no-repeat;
              background-position: top left;
              header: AvancienciaHeader;
              footer: AvancienciaFooter;
              margin-header: 10px;
            }
            body{
                text-align: justify;
            }

          </style>';

    $mpdf->DefHTMLHeaderByName('AvancienciaHeader', $cabecera);
    $mpdf->DefHTMLFooterByName('AvancienciaFooter', $footer);

    $mpdf->WriteHTML($header.$content);

    $nombreArchivo = date('Ymdhi').'.pdf';

    // Descargar o almacenar documento de salida
    $mpdf->Output();
  }

  public function auditAssignSave(Request $request)
  {

    try {

      $auditExist = \App\Models\ReviewAudit::where('review', '=', $request->review)->where('user', '=', $request->user)->first();

      if(isset($auditExist)){

        $response['message'] = "El usuario ya se encuentra asignado a esta revisión.";
        $response['data'] = '';
        $response['success'] = false;

      }else{

        $project = \App\Models\Project::find($request->project);

        $insert['review'] = $request->review;
        $insert['user'] = $request->user;
        $insert['daysLimit'] = $request->daysLimit;
        $insert['assignDate'] = date('Y-m-d');
        $insert['state'] = 'Activo';

        $className = "\App\Models\ReviewAudit";
        $element = \App\Models\ReviewAudit::create($insert);

        $notification['elementId'] = $element->id;
        $notification['subject'] = 'Cafeto - Nueva Revisión Asignada';
        $notification['message'] = "Ha sido asignado como comité académico de la evaluación ".$element->getReview->getProject->name." para el proceso ".$element->getReview->getProject->getProcess->name.", el plazo de revisión es ".$element->daysLimit." días. Ingrese al menú Revisiones para empezar.
        <br><br><a class='btn' href='https://www.cafeto.cimaonline.com.co'>https://www.cafeto.cimaonline.com.co</a>";
        $notification['emails'] = $element->getCommittee->email;

        $this->notify($notification);
        $this->reviewLog($notification);
        $this->mailSend($notification);

        $notification['emails'] = $element->getReview->getProject->getProcess->getResponsible->email;
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

  public function auditAssignUpdate(Request $request)
  {

    try {

        $update['user'] = $request->user;
        $update['daysLimit'] = $request->daysLimit;
        $update['assignDate'] = date('Y-m-d');
        $update['state'] = $request->state;

        //$element = \App\Models\ReviewAudit::where('review', $request->review)->first();
        $element = \App\Models\ReviewAudit::find($request->id);
        $element->update($update);

        $notification['elementId'] = $element->id;
        $notification['subject'] = 'Cafeto - Nueva Revisión Asignada';
        $notification['message'] = "Ha sido asignado como comité académico de la evaluación ".$element->getReview->getProject->name." para el proceso ".$element->getReview->getProject->getProcess->name.", el plazo de revisión es ".$element->daysLimit." días. Ingrese al menú Revisiones para empezar.
        <br><br><a class='btn' href='https://www.cafeto.cimaonline.com.co'>https://www.cafeto.cimaonline.com.co</a>";
        $notification['emails'] = $element->getCommittee->email;

        $this->notify($notification);
        $this->reviewLog($notification);
        //$this->mailSend($notification);

        $notification['emails'] = $element->getReview->getProject->getProcess->getResponsible->email;
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

  public function terms()
  {
    $content = \App\Models\FormatReview::find(1);
    return view('review.terms', compact('content'));
  }

  public function ethicCodeFormat()
  {

    $mpdf = new \Mpdf\Mpdf();

    $format = \App\Models\FormatReview::find(1);

    $arrayValues['idCodigoEtica'] = '';
    $arrayValues['fechaFirma'] = '';
    $arrayValues['firmaCodigo'] = '';
    $arrayValues['firmaCodigo'] = '';
    $arrayValues['nombreEvaluador'] = '';
    $arrayValues['identificacion'] = '';
    $arrayValues['tipoId'] = '';


    foreach ($arrayValues as $keyC => $valueC) {
      $titulos[] = '{{$'.$keyC.'}}';
      $valores[] = $valueC;
    }

    $content = str_replace($titulos, $valores, $format->content);

    $cabecera = '';
    $content = '<body>'.$content.'</body>';
    $footer = $format->footer.'Página: {PAGENO} de {nbpg}';

    $header = '
          <style>
            @page {
              margin: 80px 80px;
              margin-top: 30px;
              font-size: 9px;
              background-repeat: no-repeat;
              background-position: top left;
              header: AvancienciaHeader;
              footer: AvancienciaFooter;
              margin-header: 10px;
            }
            body{
                text-align: justify;
            }

          </style>';

    $mpdf->DefHTMLHeaderByName('AvancienciaHeader', $cabecera);
    $mpdf->DefHTMLFooterByName('AvancienciaFooter', $footer);

    $mpdf->WriteHTML($header.$content);

    $nombreArchivo = date('Ymdhi').'.pdf';

    // Descargar o almacenar documento de salida
    $mpdf->Output();

  }

  public function delete(Request $request){
    $idElement = $request->id;
    $className = "\App\Models\ProjectReview";

   try {
       $data['state'] = 'Activo';
       $res = ("{$className}::where")("id",$idElement)->update($data);
       $response['res'] = $res;
       $response['message'] = "Inactivated successful";
       $response['success'] = true;
   } catch (\Exception $e) {
       $response['message'] = $e->getMessage();
       $response['success'] = false;
   }

   return $response;
 }

   public function paymentSend(Request $request){

     $message = "";

     try {
      $client = new \GuzzleHttp\Client();
      
        $review = \App\Models\ProjectReview::find($request->idReview);

  
        $url ="https://unisono-acac.com/api/contratos/registrar";


        //validar estado de calendario de pagos
        $urlEventosUnisono="https://unisono-acac.com/eventos/consulta/";
        $requestClientEvento = $client->request('GET', $urlEventosUnisono.date('Y-m-d H:i:s'));
        $reponseClienteEvento=json_decode($requestClientEvento->getBody());

       

        if($reponseClienteEvento!=[])
        {
          $response['message']  =  $reponseClienteEvento[0]->descripcion;
          $response['success'] = false;
          return $response;
        
        }
      

        

    
   


        // si no está activa la cuenta
        if($review->paymentState == 'Activo' && !($review->paymentId)){

          $this->paymentFile($request->idReview);

          if(isset($review->getReviewer->document) && isset($review->getProject->getProcess->getFeeReview->price) && isset($review->getProject->getProcess->budget_reviewer_id)){

            //$fee = ($review->feeCustom) ? $review->feeCustom : $review->getProject->getProcess->getFeeReview->price;

            if($review->feeCustom){
               $fee = $review->feeCustom;
            }elseif($review->getProject->feeCustom){
               $fee = $review->getProject->feeCustom;
            }else{
               $fee = $review->getProject->getProcess->getFeeReview->price;
            }

            $rutFile = \App\Models\File::where('model', 'like', 'User')->where('elementId', $review->getReviewer->id)->where('description', 'rut')->orderBy('id', 'desc')->first();

            $documentFile = \App\Models\File::where('model', 'like', 'User')->where('elementId', $review->getReviewer->id)->where('description', 'identification')->orderBy('id', 'desc')->first();

            $bankCertificadeFile = \App\Models\File::where('model', 'like', 'User')->where('elementId', $review->getReviewer->id)->where('description', 'bankCertificate')->orderBy('id', 'desc')->first();

            $paymentFile = \App\Models\File::where('model', 'like', 'ProjectReview')->where('description', 'paymentInvoice')->where('elementId', $review->id)->orderBy('id', 'desc')->first();

            $parameters = [
                    ['name' => 'presupuestoId', 'contents' => $review->getProject->getProcess->budget_reviewer_id],
                    ['name' => 'contratistaNombre', 'contents' =>  $review->getReviewer->name],
                    ['name' => 'contratistaEmail', 'contents' => $review->getReviewer->email],
                    ['name' => 'contratistaDocumento', 'contents' => $review->getReviewer->document],
                    ['name' => 'documentoTipo', 'contents' => $review->getReviewer->documentType],
                    ['name' => 'contratistaTelefono', 'contents' => $review->getReviewer->phone],
                    ['name' => 'contratistaDireccion', 'contents' => $review->getReviewer->address],
                    ['name' => 'contratistaDepartamento', 'contents' => $review->getReviewer->city],
                    ['name' => 'contratistaPais', 'contents' => $review->getReviewer->country],
                    ['name' => 'contratistaCiudad', 'contents' => $review->getReviewer->city],
                    ['name' => 'cuentaDescripcion', 'contents' => 'Evaluación: '.$review->getProject->getProcess->name.' '.$review->getProject->name],
                    ['name' => 'responsable', 'contents' => $review->getProject->getProcess->getResponsible->name],
                    ['name' => 'tarifaValor', 'contents' => $fee],
                    ['name' => 'evaluacionFecha', 'contents' =>  $review->reviewDate],
                    ['name' => 'rut', 'contents' => Psr7\Utils::tryFopen('storage/files/'.$rutFile->file, 'r')],
                    ['name' => 'cedula', 'contents' => Psr7\Utils::tryFopen('storage/files/'.$documentFile->file, 'r')],
                    ['name' => 'certificado_bancario', 'contents' => Psr7\Utils::tryFopen('storage/files/'.$bankCertificadeFile->file, 'r')],
                    ['name' => 'cuenta_cobro', 'contents' => Psr7\Utils::tryFopen('storage/files/'.$paymentFile->file, 'r')],
                ];

            $requestClient = $client->request('POST', $url, [
                  'multipart' => $parameters]);

            $requestResponse = json_decode($requestClient->getBody());
            if($requestResponse->success == true && isset($requestResponse->data->unisonoId) && isset($requestResponse->data->paymentId)){
              $review->update(['paymentId' => $requestResponse->data->paymentId, 'paymentState' => 'Registrado']);
            }

            $response['data'] = $requestResponse;
            $response['success'] = true;

          }else{
              $message = 'Los datos de pago se encuentran incompletos, revisa que los datos del evaluador esten completos así como la tarifa de evaluación y el presupuesto del proceso.';
              $response['success'] = false;

          }

        }else{
          $message = 'La evaluación no se encuentra para pago.';
          $response['success'] = false;

        }
        

         $response['message'] = $message;

     } catch (\Exception $e) {

         $response['message'] = $e->getMessage();
         $response['success'] = false;
     }
    

     return $response;

  }

  public function paymentReceipt($id)
  {

    $review = \App\Models\ProjectReview::find($id);

    $mpdf = new \Mpdf\Mpdf();

    $format = \App\Models\FormatReview::find(7);

    //$fee = ($review->getProject->feeCustom) ? $review->getProject->feeCustom : $review->getProject->getProcess->getFeeReview->price;

    if($review->feeCustom){
        $fee = $review->feeCustom;
    }elseif($review->getProject->feeCustom){
       $fee = $review->getProject->feeCustom;
    }else{
       $fee = $review->getProject->getProcess->getFeeReview->price;
    }

    $arrayValues['pagoFecha'] =  date('Y-m-d');
    $arrayValues['evaluadorNombre'] = $review->getReviewer->name;
    $arrayValues['evaluadorTipoDocumento'] = $review->getReviewer->documentType;
    $arrayValues['evaluadorDocumento'] = $review->getReviewer->document;
    $arrayValues['evaluadorDireccion'] = $review->getReviewer->address;
    $arrayValues['evaluadorCiudad'] = $review->getReviewer->city;
    $arrayValues['evaluadorTelefono'] = $review->getReviewer->phone;
    $arrayValues['evaluadorEmail'] = $review->getReviewer->email;
    $arrayValues['evaluacionProceso'] = $review->getProject->getProcess->name;
    $arrayValues['evaluacionDocumento'] = $review->getProject->name;
    $arrayValues['evaluacionFecha'] = $review->reviewDate;
    $arrayValues['evaluacionTarifa'] = "$ ".number_format($fee, 0, ',', '.');

    $urlCuenta = "https://www.cafeto.cimaonline.com.co/payment/receipt/".md5($review->id);
    $arrayValues['qrCuenta']  =  str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', QrCode::generate($urlCuenta));
    $arrayValues['consecutivo'] = $review->id;

    foreach ($arrayValues as $keyC => $valueC) {
      $titulos[] = '{{$'.$keyC.'}}';
      $valores[] = $valueC;
    }

    $content = str_replace($titulos, $valores, $format->content);

    $cabecera = '';
    $content = '<body>'.$content.'</body>';
    $footer = $format->footer.'Página: {PAGENO} de {nbpg}';

    $header = '
        <style>
          @page {
            margin: 30px 80px;
            font-size: 10px;
            background-repeat: no-repeat;
            background-position: top left;
            header: AvancienciaHeader;
            footer: AvancienciaFooter;
            margin-header: 25px;
          }
          body{
              text-align: justify;
          }

        </style>';

    $mpdf->DefHTMLHeaderByName('AvancienciaHeader', $cabecera);
    $mpdf->DefHTMLFooterByName('AvancienciaFooter', $footer);

    $mpdf->WriteHTML($header.$content);

    $nombreArchivo = "receipt_".date('Ymdhi').'.pdf';

    // Descargar o almacenar documento de salida
    $mpdf->Output();
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


  public function paymentFile($id)
  {

    $review = \App\Models\ProjectReview::find($id);

    $mpdf = new \Mpdf\Mpdf();

    $format = \App\Models\FormatReview::find(7);

    //$fee = ($review->feeCustom) ? $review->feeCustom : $review->getProject->getProcess->getFeeReview->price;

    if($review->feeCustom){
        $fee = $review->feeCustom;
    }elseif($review->getProject->feeCustom){
       $fee = $review->getProject->feeCustom;
    }else{
       $fee = $review->getProject->getProcess->getFeeReview->price;
    }

    $arrayValues['pagoFecha'] =  date('Y-m-d');
    $arrayValues['evaluadorNombre'] = $review->getReviewer->name;
    $arrayValues['evaluadorTipoDocumento'] = $review->getReviewer->documentType;
    $arrayValues['evaluadorDocumento'] = $review->getReviewer->document;
    $arrayValues['evaluadorDireccion'] = $review->getReviewer->address;
    $arrayValues['evaluadorCiudad'] = $review->getReviewer->city;
    $arrayValues['evaluadorTelefono'] = $review->getReviewer->phone;
    $arrayValues['evaluadorEmail'] = $review->getReviewer->email;
    $arrayValues['evaluacionProceso'] = $review->getProject->getProcess->name;
    $arrayValues['evaluacionDocumento'] = $review->getProject->name;
    $arrayValues['evaluacionFecha'] = $review->reviewDate;
    $arrayValues['evaluacionTarifa'] = "$ ".number_format($fee, 0, ',', '.');

    $urlCuenta = "https://www.cafeto.cimaonline.com.co/payment/receipt/".md5($review->id);
    $arrayValues['qrCuenta']  =  str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', QrCode::generate($urlCuenta));
    $arrayValues['consecutivo'] = $review->id;

    foreach ($arrayValues as $keyC => $valueC) {
      $titulos[] = '{{$'.$keyC.'}}';
      $valores[] = $valueC;
    }



    $content = str_replace($titulos, $valores, $format->content);

    $cabecera = '';
    $content = '<body>'.$content.'</body>';
    $footer = $format->footer.'Página: {PAGENO} de {nbpg}';

    $header = '
        <style>
          @page {
            margin: 30px 80px;
            font-size: 10px;
            background-repeat: no-repeat;
            background-position: top left;
            header: AvancienciaHeader;
            footer: AvancienciaFooter;
            margin-header: 25px;
          }
          body{
              text-align: justify;
          }

        </style>';

    $mpdf->DefHTMLHeaderByName('AvancienciaHeader', $cabecera);
    $mpdf->DefHTMLFooterByName('AvancienciaFooter', $footer);

    $mpdf->WriteHTML($header.$content);

    $nombreArchivo = "receipt_".$review->id."_".date('Ymdhi').'.pdf';

    // Descargar o almacenar documento de salida
    $mpdf->Output('storage/files/'.$nombreArchivo, 'F');

    $upload = new \App\Models\File;
    $upload->name = $nombreArchivo;
    $upload->file = $nombreArchivo;
    $upload->field = 'paymentInvoice';
    $upload->description = 'paymentInvoice';
    $upload->model = 'ProjectReview';
    $upload->elementId = $review->id;
    $upload->user = 1;
    $upload->state = 'Activo';
    $upload->created_at = time();
    $upload->updated_at = time();

    $upload->save();
  }

  public function reportCustom2(Request $request)
    {
 //     $mpdf = new \Mpdf\Mpdf();

      $mpdf = new \Mpdf\Mpdf([
        'setAutoTopMargin' => 'stretch',
        'setAutoBottomMargin' => 'pad',

    ]);
    

      $review = "\App\Models\ProjectReview"::find($request->id);
      $reviewAnswer = json_decode($review->answer, true);

    //loopback a reporte standar
      if(!isset($review->getProject->formatReview))
      {
        return redirect(route('review.report.standard',$request->id));
      }

      //Format
      $formatId = isset($review->getProject->formatReview) ? $review->getProject->formatReview : env('REPORTE_STANDAR_ID');
      $format = \App\Models\FormatReview::find($formatId);

      $contentModules = "";

      

      $arrayValues['nombreProyecto'] = $review->getProject->name;
      $arrayValues['nombreProceso'] = $review->getProject->getProcess->name;
      $arrayValues['nombreCliente'] = $review->getProject->getProcess->getCustomer->name;
      $arrayValues['puntaje'] = $review->result;
      $arrayValues['evaluadorNombre'] = $review->getReviewer->name;
      $arrayValues['evaluadorIdentificacion'] = $review->getReviewer->document;
      $arrayValues['evaluadorTitulo'] = $review->getReviewer->lastDegree;
      $arrayValues['evaluadorInstitucion'] = $review->getReviewer->institution;
      $arrayValues['evaluadoCorreo'] = $review->getReviewer->email;
      $arrayValues['evaluadorTelefono'] = $review->getReviewer->phone;
      $arrayValues['evaluadorPerfil'] = $review->getReviewer->profile;
      $arrayValues['evaluacionDia'] =  date('d', strtotime($review->reviewDate));
      $arrayValues['evaluacionMes'] = date('m', strtotime($review->reviewDate));
      $arrayValues['evaluacionAnio'] = date('Y', strtotime($review->reviewDate));
      $arrayValues['firma'] = "<img  width='200px' src='".$review->codeSignature."' />";





      //dd($arrayValues);


      $titulosPreguntas = array();
      $valoresPreguntas = array();

      foreach ($reviewAnswer as $keyPage => $valuePage) {

        $contentModules .=  ""; // "<table border='0' width='100%' cellspacing='0' cellpadding='5' style='overflow: wrap'>";

        foreach ($valuePage['questions'] as $keyQuestion => $question) {

            switch ($question['type']) {
                case 'radio-group':
                    if(isset($question['name'])){
                        $titulosPreguntas[] = '%'.$question['name'].'%';

                        foreach ($question['values'] as $keyOption => $valueOption) {
                            if($valueOption['value']==$question['value']){
                              $valoresPreguntas[] = $valueOption['label'];
                            }
                        }
                    }
                    break;
                case 'select':
                    if(isset($question['name'])){
                        $titulosPreguntas[] = '%'.$question['name'].'%';

                        foreach ($question['values'] as $keyOption => $valueOption) {
                            if($valueOption['value']==$question['value']){
                              $valoresPreguntas[] = $valueOption['label'];
                            }
                        }
                    }
                    break;


              case 'number':
                    if(isset($question['name'])){


                        $titulosPreguntas[] = '%'.$question['name'].'%';
                        //formato con decimales si el step es decimal


                        $numerodeDecimales= $this->numberOfDecimals($question['step']);

                        if(fmod($question['step'], 1) !== 0.00){
                                  $valoresPreguntas[] = number_format($question['value'],$numerodeDecimales,'.',',');
                            } else {
                                  $valoresPreguntas[] = $question['value'];
                               }

                    }
                break;

                default:
                    if(isset($question['name'])){
                        $titulosPreguntas[] = '%'.$question['name'].'%';
                        $valoresPreguntas[] = $question['value'];
                    }
                break;
            }

        }

    //    $contentModules .= "</table>";
      }

      $arrayValues['contenidoEvaluacion'] =$contentModules;

      $cabecera = $format->header ?: '';
      $footer = '';

      foreach ($arrayValues as $keyC => $valueC) {
        $titulos[] = '{{$'.$keyC.'}}';
        $valores[] = $valueC;
      }

      $content = str_replace($titulos, $valores, $format->content);
      $content = str_replace($titulosPreguntas, $valoresPreguntas, $content);

      $customData=[];

      $valueArray=array_combine($titulosPreguntas,$valoresPreguntas);

      //dd($titulos);
      
      //evalúa código desde formato
      eval($format->parameters);

      $content = str_replace(array_keys($customData), array_values($customData), $content);

      


     // $content = '<body>'.$content.'</body>';
      $footer = $format->footer ; //.'Página: {PAGENO} de {nbpg}';

   $header='';

     $header = '
          <style>
            @page {
              margin: 80px 80px;
              margin-top: 30px;
              font-size: 20px;
              background-repeat: no-repeat;
              background-position: top left;
              header: AvancienciaHeader;
              footer: AvancienciaFooter;
              margin-header: 10px;
            }
            body{
                text-align: justify;
            }
            .sinborde{
                border: 0px;
            }

          </style>';


      $mpdf->DefHTMLHeaderByName('AvancienciaHeader', $cabecera);
      $mpdf->DefHTMLFooterByName('AvancienciaFooter', $footer);

    //return($header.$content);

      $mpdf->WriteHTML($header.$content);

      $nombreArchivo = date('Ymdhi').'.pdf';

      // Descargar o almacenar documento de salida
      $mpdf->Output();
    }



  public  function numberOfDecimals($value)
    {
        if ((int)$value == $value)
        {
            return 0;
        }
        else if (! is_numeric($value))
        {
            // throw new Exception('numberOfDecimals: ' . $value . ' is not a number!');
            return false;
        }

        return strlen($value) - strrpos($value, '.') - 1;
    }


  public function paymentEnable(Request $request)
  {
    try {
      $review = \App\Models\ProjectReview::find($request->idReview);

      if($review->getProject->getProcess->getFeeReview && $review->getProject->getProcess->project_unisono_id && $review->getProject->getProcess->budget_reviewer_id){

        //Enviar correos
        $notification['subject'] = 'Cafeto - Cuenta de Cobro Habilitada';

        $notification['elementId'] = $review->id;
        $notification['message'] = "Se ha habilitado la cuenta de cobro para la evaluación ".$review->getProject->name." para el proceso ".$review->getProject->getProcess->name.". Ingrese al menú Evaluaciones para registrar su cuenta de cobro.
        <br><br><a class='btn' href='https://www.cafeto.cimaonline.com.co'>https://www.cafeto.cimaonline.com.co</a>";
        $notification['message'] .= "<br><br>Nota: De acuerdo a la política de pagos, AVANCIENCIA establece el plazo de cuarenta y cinco (45) días para el pago de facturas y cuentas de cobro de evaluadores a partir de la fecha de radicación. ";

        $notification['emails'] = [$review->getReviewer->email];

        if($review->getReviewer->email){
            $notification['emails'] = [$review->getProject->getProcess->getResponsible->email, $review->getReviewer->email];
            $this->mailSend($notification);
        }

        $review->update(['paymentState' => 'Activo']);

        $response['data'] = json_decode($review);
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

}
