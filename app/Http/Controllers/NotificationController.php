<?php

namespace App\Http\Controllers;

use Backpack\PageManager\app\Models\Page;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
  public function list(){
    return view('process.crud.main');
  }

  public function board(){
    return view('crud.main');
  }

  public function messageNew(){
    return view('crud.main');
  }

  public function messageSave(Request $request){
    try {

      foreach ($request->all() as $key => $value) {
          if($key!=='modelName') $insert[$key] = $value;
      };

      $insert['user'] = Auth::id();
      $insert['notification'] = $request->notificationId;
      $insert['date'] = date('Y-m-d');
      $insert['event'] = 'Respuesta';
      $insert['state'] = 'Activo';

      $model = ucwords($request->modelName);
      $className = "\App\Models\\$model";
      $element = ("{$className}::create")($insert);

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
