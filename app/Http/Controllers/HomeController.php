<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


     public function clearCache()
     {
//       Artisan::call('cache:clear');
//       Artisan::call('config:cache');
  //     Artisan::call('config:clear');
//       Artisan::call('view:clear');
    //   Artisan::call('route:clear');
//       Artisan::call('view:cache');
  //  Artisan::call('route:cache');
    Artisan::call('optimize');




       dd('cache limpio');
     }





     public function home()

     {
         // Artisan::call('route:cache');
         // dd('limpio');
       $modules = \App\Models\Menu::where('parent_id', NULL)->where('active',1)->orderBy('order')->get();
       return view('home.home', compact('modules'));
     }

     public function module($idElement)
     {
       session(['proyecto_id' => $idElement]);
       $idProject = session('proyecto_id');
       $modules = \App\Models\Menu::where('parent_id', $idElement)->where('active',1)->get();

       return view('home.module', compact('modules'));
     }

     public function submodule(Request $request)
     {
        $idProyecto = session('proyecto_id');
        $submodulos = \App\Models\Menu::where('parent_id', $request->idRegistro)->where('active',1)->get();
        return view('home.submodulos',compact('submodulos'));
     }
}
