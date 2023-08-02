<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mail;

class userController extends Controller
{

  public function profileEdit(){
    return view('crud.main');
  }

  public function profileShow(){
    return view('crud.main');
  }

  public function documents(){
    return view('crud.main');
  }

  public function getCurrent(){

     try {

       $documentsCompleted = 1;

       $data = Auth::user();

       DB::enableQueryLog();

       $dataFiles = \App\Models\File::where('model', 'like', 'User')->where('elementId', $data->id)->orderBy('id', 'desc')->get();

       if ($data) {

         //tiene rut
         $rutFile = \App\Models\File::where('model', 'like', 'User')->where('elementId', $data->id)->where('description', 'rut')->orderBy('id', 'desc')->first();
         if(!$rutFile) $documentsCompleted = 0;

         //tiene cedula
         $documentFile = \App\Models\File::where('model', 'like', 'User')->where('elementId', $data->id)->where('description', 'identification')->orderBy('id', 'desc')->first();
         if(!$documentFile) $documentsCompleted = 0;

         //tiene certificado bancario
         $bankFile = \App\Models\File::where('model', 'like', 'User')->where('elementId', $data->id)->where('description', 'bankCertificate')->orderBy('id', 'desc')->first();
         if(!$bankFile) $documentsCompleted = 0;

         $response['data'] = $data;
         $response['data']['files'] = $dataFiles;
         $response['data']['documentsCompleted'] = $documentsCompleted;
         $response['message'] = "Load successful";
         $response['success'] = true;
       }
       else {
         $response['message'] = "Not found data id => $elementId";
         $response['success'] = false;
       }

     } catch (\Exception $e) {
       $response['message'] = $e->getMessage();
       $response['success'] = false;
     }
     return $response;
  }

  public function profileUpdate(Request $request){

    try {

      $idElement = Auth::user()->id;
      $update = array();

      foreach ($request->all() as $key => $value) {
          if($key!=='model' && $key!=='id') $update[$key] = $value;
      };

      $element = \App\Models\User::find($idElement);

      $element->update($update);
      $element->save();

      $response['message'] = "Form recorded.";
      $response['success'] = true;

    } catch (\Exception $e) {
      $response['message'] = $e->getMessage();
      $response['success'] = false;
    }

    return $response;
  }

  public function documentsUpload(Request $request){

    try {

      $idElement = Auth::user()->id;
      $update = array();

      //save files
      if($request->file()){

        $files = $request->file();

        foreach ($files as $keyFile => $valueFile) {

           $data['file'] = $request->file($keyFile);
           $data['name'] = $request->file($keyFile);
           $data['field'] = $keyFile;
           $data['user'] = 1;
           $data['model'] = 'User';
           $data['elementId'] = $idElement;
           $this->fileSave($data);
        }
      }

      $response['message'] = "Form recorded.";
      $response['success'] = true;

    } catch (\Exception $e) {
      $response['message'] = $e->getMessage();
      $response['success'] = false;
    }

    return $response;
  }

  public function fileSave($data)
 {
   //Almacenar documentos

   $filename = time()."_".$data['file']->getClientOriginalName();
   Storage::disk('local')->putFileAs('public/files/',
               $data['file'],
               $filename
               );

   $upload = new \App\Models\File;
   $upload->name = $filename;
   $upload->file = $filename;
   $upload->field = $data['field'];
   $upload->description = $data['field'];
   $upload->model = $data['model'];
   $upload->elementId = $data['elementId'];
   $upload->user = $data['user'];
   $upload->state = 'Activo';
   $upload->created_at = time();
   $upload->updated_at = time();

   $upload->save();
 }

}
