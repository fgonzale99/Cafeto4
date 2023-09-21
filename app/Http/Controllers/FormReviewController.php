<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormReviewController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */





   public function guarda_header(Request $request)
   {

  //   dd($request->request);

     $form = \App\Models\FormReview::updateOrCreate(
         ['id' => $request->form_id],
    ['id' => $request->form_id, 'name' => $request->name,
    'description'=>$request->description, 'instructions'=> $request->instructions]

);

  return redirect(route('formreview.new_new',[$form->id]));
   }

    public function new_new($form_id = null)
    {

      if($form_id!=null)
      {

         $form = \App\Models\FormReview::find($form_id);


      }
      else
      {
        $form = new \App\Models\FormReview;
      }


      return view('form.new.header_editor',compact('form'));
    }

    public function neweditor($form_id = null, $module_id = null)
    {
//$elements = \App\Models\Form::orderBy('id','DESC')->paginate(20);
     $form = \App\Models\FormReview::find($form_id);

    $formData=$form->form;

    $formDataDecoded=json_decode($formData,true);
    $new_module_id=is_array($formDataDecoded) ? count($formDataDecoded)+1 : 1;

    if(isset($formDataDecoded[$module_id]))
    {

        $moduleDecoded=$formDataDecoded[$module_id];
        $encodedQuestions=json_encode($moduleDecoded['questions'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

     //   dd($encodedQuestions);

     //   $encodedQuestions=str_replace('\"','¨',$encodedQuestions);
    }
    else {
        $encodedQuestions=null;
        $module_id=$new_module_id;
        $formDataDecoded[$new_module_id]=[
          'pageName'=>null,
        ];
    }




      return view('form.new.editor',compact('encodedQuestions','module_id','formDataDecoded','form_id','new_module_id'));

    }



    public function uniqueform($process_id, $form_id)
    {
     
      $results=\App\Models\Project::select(['*'])->where('process',$process_id)->where('formReview','!=',$form_id)->count();
   
      return 0;


   //   return $results;
    }


    public function guardaModulo(Request $request)
    {

      //busca si existe formulario
      $form = \App\Models\FormReview::find($request->form_id);
      $formData=$form->form;

      //decodifica formulario
      $formDataDecoded=json_decode($formData,true);



    
      //extra json de post
      $raw_form=json_decode($request->json,false);


      foreach($raw_form as $form_item)

      {
        if(isset($form_item->label))
        {
          //elimina saltos de linea
          $form_item->label = str_replace(array("\n","\r","\t"), '', $form_item->label);
          
          //elimina tags indeseados
          $form_item->label = strip_tags($form_item->label,['<b>','<strong>','<p>','<h1>','<span>']);


          //limpia propiedades de tags permitidos
          $form_item->label = preg_replace("/<(p|a|b|div|span) [^>]*>/", "<$1>", $form_item->label );

        }
   

      }


      $clean_form=$raw_form;


    if(isset($formDataDecoded[$request->module_id]))
    {


      $module_data=$formDataDecoded[$request->module_id];

      $questions_data=$module_data['questions'];

      }
      else {


    }
    //   $formDataDecoded=$

      $new_module_data['pageName']=$request->module_name;
      $new_module_data['state']=$request->state;
      $new_module_data['questions']=$clean_form;



       $formDataDecoded[$request->module_id]=$new_module_data;

      $form->form=json_encode($formDataDecoded);

       // code...

    $form->save();




    

    return redirect(route('formreview.neweditor',[$form->id,$request->module_id]));



    }

    public function list()
    {
      $elements = \App\Models\Form::orderBy('id','DESC')->paginate(20);
      return view('form.list', compact('elements'));
    }

    public function new()
    {
       return view('review.form.main');
    }

    public function edit()
    {
       return view('review.form.main');
    }

    public function rules()
    {
       return view('review.form.main');
    }

    public function publish()
    {
       return view('review.form.main');
    }

    public function show()
    {
       return view('review.form.main');
    }


    public function duplicate()
    {
       return view('review.form.main');
    }


    public function save(Request $request)
    {
        $form= new  \App\Models\Formreview(array(
            'json' => $request->json,
            'descripcion' => 'Formulario de Test'
          ));

        $form->save();

        return view('form.new');
    }

    public function showOld()
    {
      $form = \App\Models\FormReview::orderBy('id', 'desc')->first();

      return view('form.show', compact('form'));
    }

    public function formbuilder(){
      return view('crud.main');
    }


    public function questionsSave(Request $request)
    {

      $model = ucwords($request->modelName);
      $idElement = $request->id;
      $idPage = $request->page;

      $className = "\App\Models\\$model";

      try {

          //Construir Pagina
          $formReview = ("{$className}::find")($idElement);

          $data = (array) json_decode($formReview->form,true);

          $data[$idPage]['questions'] = json_decode($request->form);
          $data[$idPage]['pageName'] = $request->pageName;
          $data[$idPage]['state'] = 'active';
          $data[$idPage]['order'] = 1;

          $form['form'] = json_encode($data);

          $element = ("{$className}::find")($idElement);
          $element->update($form);

          $response['data'] = $data;
          $response['idPage'] = $idPage;
          $response['message'] = "Form recorded.";
          $response['success'] = true;

        } catch (\Exception $e) {
          $response['message'] = $e->getMessage();
          $response['success'] = true;
        }

        return $response;
    }

    public function pageGet(Request $request){
      $model = ucwords($request->modelName);
      $idElement = $request->id;
      $idPage = $request->page;

      $className = "\App\Models\\$model";

      try {

          //Construir Pagina
          $formReview = ("{$className}::find")($idElement);
          $data = json_decode($formReview->form, true);

          $response['form'] = (isset($data[$idPage]['questions'])) ? json_encode($data[$idPage]['questions']) : '';
          $response['pageName'] = (isset($data[$idPage]['pageName'])) ? $data[$idPage]['pageName'] : '';
          $response['state'] = (isset($data[$idPage]['state'])) ? $data[$idPage]['state'] : '';
          $response['success'] = true;

        } catch (\Exception $e) {
          $response['message'] = $e->getMessage();
          $response['success'] = true;
        }

       return $response;
   }

   public function getFormReview(Request $request){
     $model = ucwords($request->modelName);
     $idElement = $request->id;

     $className = "\App\Models\\$model";

     try {

         //Construir Pagina
         $formReview = ("{$className}::find")($idElement);

         $data = json_decode($formReview->form, true);

         $pages = [];

         foreach ($data as $keyP => $valueP) {
           $pages[] = $valueP;
         }

        //dd($data);
         $response['questions'] = $pages;
         $response['success'] = true;

       } catch (\Exception $e) {
         $response['message'] = $e->getMessage();
         $response['success'] = true;
       }

      return $response;
  }

  public function published(Request $request){
    $idElement = $request->id;
    $className = "\App\Models\FormReview";

    try {
        //Construir Pagina
        $formReview = ("{$className}::find")($idElement);

        $update['state'] = 'Publicado';

        $formReview->update($update);

        $response['success'] = true;

      } catch (\Exception $e) {
        $response['message'] = $e->getMessage();
        $response['success'] = false;
      }

     return $response;
 }

 public function draft(Request $request){
   $idElement = $request->id;
   $className = "\App\Models\FormReview";

   try {

       //Construir Pagina
       $formReview = ("{$className}::find")($idElement);

       $update['state'] = 'Borrador';

       $formReview->update($update);

       $response['success'] = true;


     } catch (\Exception $e) {
       $response['message'] = $e->getMessage();
       $response['success'] = false;
     }

    return $response;
}

}
