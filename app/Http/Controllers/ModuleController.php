<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModuleController extends Controller
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

    public function new(){

      return view('module.new');

   }

    public function get($id){

     try {

       $data = \App\Models\Module::find($id);

       if ($data) {
         $response['data'] = $data;
         $response['message'] = "Load successful";
         $response['success'] = true;
       }
       else {
         $response['message'] = "Not found data id => $id";
         $response['success'] = false;
       }

     } catch (\Exception $e) {
       $response['message'] = $e->getMessage();
       $response['success'] = false;
     }
     return $response;
   }


   public function getByName($name){

    try {
      $data = \App\Models\Module::where('name', $name)->first();

      if ($data) {
        $response['data'] = json_decode($data->fields);
        $response['message'] = "Load successful";
        $response['success'] = true;
      }
      else {
        $response['message'] = "Not found data id => $id";
        $response['success'] = false;
      }

    } catch (\Exception $e) {
      $response['message'] = $e->getMessage();
      $response['success'] = false;
    }
    return $response;
  }


}
