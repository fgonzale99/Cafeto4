<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Mail;

class ReviewerController extends Controller
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
      $list = \App\Models\Review::where('active', 1)->get();
      return view('review.cronology', compact('list'));
    }

     public function search()
     {
       return view('crud.main');
       //return view('reviewer.search');
     }

     public function projects(){
       return view('crud.main');
     }


     public function getProjects(Request $request){

      
       $model = ucwords($request->modelName);
       $className = "\App\Models\\$model";
       $module = $request->moduleName;
       $max = 25;
       $page = ($request->page) ? $request->page : 1;

       $arrayFilters = array();
       if($request->filters){
         $filters = json_decode($request->filters);

         foreach ($filters as $keyFilter => $valueFilter) {
           $arrayFilters[] = [$valueFilter[0], 'like', "$valueFilter[1]%"];
         }
       }

        try {

          $dataTotal = 0;
          if(Auth::user()->hasRole('Administrador')){
                $data = $className::where($arrayFilters)->skip(($page - 1)*$max)->take($max)->get();
                $dataTotal = $className::where($arrayFilters)->count();
            }elseif(Auth::user()->hasRole('Gestor')){
                $data = $className::where($arrayFilters)->skip(($page - 1)*$max)->take($max)->get();
                $dataTotal = $className::where($arrayFilters)->count();
            }elseif(Auth::user()->hasRole('Evaluador')){
                $data = $className::where('reviewer', auth()->user()->id)->where($arrayFilters)->skip(($page - 1)*$max)->take($max)->get();
                $dataTotal = $className::where('reviewer', auth()->user()->id)->where($arrayFilters)->count();
            }else{
                $data = $className::where('reviewer', auth()->user()->id)->where($arrayFilters)->skip(($page - 1)*$max)->take($max)->get();
                $dataTotal = $className::where('reviewer', auth()->user()->id)->where($arrayFilters)->count();
            }

          $pagesTotal = ceil($dataTotal/$max);

          $dataModule = \App\Models\Module::whereRaw( "LOWER(moduleName) LIKE ?", $module)->first();
          foreach ($data as $key => $value) {
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
     //Traidas de la app de EvSignal

     public function consultarInvestigador(Request $request)
     {

        $var = $request->codigo_investigador;

        $investigadores = \App\Models\Investigador::where('codigo_investigador',$var)->first();


        $vista= view('admin.resultInvestigador',compact('investigadores','var'));

        return $vista;
     }

     public function consultarHV(Request $request)
     {
        $filtro="";
        $max = 10;
        $page = ($request->page) ? $request->page : 1;

        try {
          $var = $request->criterio;
          $investigadores = \App\Models\Investigador::select('id','nombre_investigador','codigo_investigador','documento','url')->where(function($query) use ($var){
              $query->where('nombre_investigador', 'like', '%'.$var.'%')
                    ->orWhere('codigo_investigador', 'like', '%'.$var.'%')
                    ->orWhere('documento', 'like', '%'.$var.'%');
          })->skip(($page - 1)*$max)->take($max)->get();
          $investigadores = $investigadores->sortByDesc('asociado');

          $dataTotal = \App\Models\Investigador::where(function($query) use ($var){
              $query->where('nombre_investigador', 'like', '%'.$var.'%')
                    ->orWhere('codigo_investigador', 'like', '%'.$var.'%')
                    ->orWhere('documento', 'like', '%'.$var.'%');
          })->count();

          $pagesTotal = ceil($dataTotal/$max);

          $response['data'] = $investigadores;
          $response['total'] = $dataTotal;
          $response['pagesTotal'] = $pagesTotal;
          $response['success'] = true;

        } catch (\Exception $e) {
          $response['message'] = $e->getMessage();
          $response['success'] = false;
        }
        return $response;
     }

     public function consultarArticulos(Request $request){

        $filtro="";
        $max = 20;
        $page = ($request->page) ? $request->page : 1;

        try {
            $var = $request->criterio;
            $investigadores = \App\Models\Investigador::whereHas('getArticulos', function($q) use ($var){
                    $q->where('codigo_investigador', 'like', '%'.$var.'%')
                      ->orWhere('articulo', 'like', '%'.$var.'%');
                })->skip(($page - 1)*$max)->take($max)->get();

            $investigadores = $investigadores->sortByDesc('investigadores.asociado');

            $dataTotal = \App\Models\Investigador::whereHas('getArticulos', function($q) use ($var){
                    $q->where('codigo_investigador', 'like', '%'.$var.'%')
                      ->orWhere('articulo', 'like', '%'.$var.'%');
                })->count();
            $pagesTotal = ceil($dataTotal/$max);

            $response['data'] = $investigadores;
            $response['total'] = $dataTotal;
            $response['pagesTotal'] = $pagesTotal;
            $response['success'] = true;

        } catch (\Exception $e) {
          $response['message'] = $e->getMessage();
          $response['success'] = false;
        }
        return $response;
     }

     public function consultarProyectos(Request $request)
     {
       $filtro="";
       $max = 20;
       $page = ($request->page) ? $request->page : 1;

       try {
           $var = $request->criterio;
           $investigadores = \App\Models\Investigador::whereHas('getProyectos', function($q) use ($var){
                   $q->where('codigo_investigador', 'like', '%'.$var.'%')
                     ->orWhere('nombre', 'like', '%'.$var.'%');
               })->skip(($page - 1)*$max)->take($max)->get();

           $investigadores = $investigadores->sortByDesc('investigadores.asociado');

           $dataTotal = \App\Models\Investigador::whereHas('getProyectos', function($q) use ($var){
                     $q->where('codigo_investigador', 'like', '%'.$var.'%')
                       ->orWhere('nombre', 'like', '%'.$var.'%');
             })->count();

           $pagesTotal = ceil($dataTotal/$max);

           $response['data'] = $investigadores;
           $response['total'] = $dataTotal;
           $response['pagesTotal'] = $pagesTotal;
           $response['success'] = true;

       } catch (\Exception $e) {
         $response['message'] = $e->getMessage();
         $response['success'] = false;
       }
       return $response;

    }

    public function consultarLibros(Request $request){
      $filtro="";
      $max = 20;
      $page = ($request->page) ? $request->page : 1;

      try {
          $var = $request->criterio;
          $investigadores = \App\Models\Investigador::whereHas('getLibros', function($q) use ($var){
                  $q->where('codigo_investigador', 'like', '%'.$var.'%')
                    ->orWhere('libro', 'like', '%'.$var.'%');
              })->skip(($page - 1)*$max)->take($max)->get();

          $investigadores = $investigadores->sortByDesc('investigadores.asociado');

          $dataTotal = \App\Models\Investigador::whereHas('getLibros', function($q) use ($var){
                    $q->where('codigo_investigador', 'like', '%'.$var.'%')
                      ->orWhere('libro', 'like', '%'.$var.'%');
          })->count();
;
          $pagesTotal = ceil($dataTotal/$max);

          $response['data'] = $investigadores;
          $response['total'] = $dataTotal;
          $response['pagesTotal'] = $pagesTotal;
          $response['success'] = true;

      } catch (\Exception $e) {
        $response['message'] = $e->getMessage();
        $response['success'] = false;
      }
      return $response;
    }

    public function consultar(Request $request){

      $var=$request->criterio;

      $query="select distinct
      nombre_investigador,
      investigadores.codigo_investigador,";

      if($request->cbarticulo)
      {
        $query.="if(locate(upper('$var'),articulo)>0,articulo,'') as articulo,";
      }
      if($request->cbproyecto)
      {
        $query.="if(locate(upper('$var'),nombre)>0,nombre,'') as proyecto, ";
      }

      $query.="1 from investigadores
        inner join proyectos on proyectos.codigo_investigador=investigadores.codigo_investigador
        inner join articulos on articulos.codigo_investigador=investigadores.codigo_investigador
        where ";

      if($request->cbarticulo){
        $query.="upper(articulo) like upper('%$var%')";
      }

      if(($request->cbarticulo) && ($request->cbproyecto)){
        $query.=" $request->operador ";
      }

      if($request->cbproyecto){
        $query.="upper(nombre) like upper('%$var%')";
      }

      $investigadores= DB::select( DB::raw($query));

      return view('admin.results',compact('investigadores','var'));
    }


    protected function _consultaEstatica($var,$filtro)
    {
      //Google
      $parameters = array(
        'start' => 1 ,// start from the 10th results,
        'num' => 10,
        //  'cr'=>'countryCO',
        // 'as_sitesearch'=>'*.colciencias.gov.co' // number of results to get, 10 is maximum and also default value
      );

      $fulltext = new LaravelGoogleCustomSearchEngine(); // initialize
      // dd($var.'+Cvlac+'.$filtro);
      $google = $fulltext->getResults($var.' + Cvlac + '.$filtro, $parameters); // get first 10 results for query 'some phrase'

      // $google= array();

      //busca en cafeto
      $var  = urlencode(str_replace("+", " ", $var));
      $rUrl = 'http://querycafeto.acac.org.co/?q='.$var;

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $rUrl);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $output = curl_exec($ch);

      $cafeto = json_decode($output,true);

      return array($google, $cafeto);
    }

    public function setReviewer(Request $request){

       try {

         $researcher = \App\Models\Investigador::find($request->id);

          $data['name'] = $researcher['nombre_investigador'];
          $data['email'] =  $researcher['email'];
          $data['documentType'] = 'CC';
          $data['document'] = $researcher['documento'];
          $data['city'] = $researcher['ciudad'];
          $data['address'] = true;
          $data['phone'] = $researcher['telefono'];
          $data['profile'] = $researcher['url'];
          //s$data['cvlac'] =  $researcher['texto_cvlac'];
          $data['researcherCode'] = $researcher['codigo_investigador'];
          $data['password'] = Hash::make($researcher['codigo_investigador']);
          $data['state'] = 'Activo';

          $user = \App\Models\User::create($data);

          $user->roles()->sync([4]);

          $update['par'] = 1;
          $researcher->update($update);

          $response['message'] = 'User created.';
          $response['success'] = true;

       } catch (\Exception $e) {
         $response['message'] = $e->getMessage();
         $response['success'] = false;
       }

       return $response;
     }

}
