<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use App\Models\ProjectReview;
use App\Models\Process;
use App\Models\Customer;


class CustomerController extends Controller
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

    public function processList()
    {
      return view('crud.main');

    }

    public function processShow()
    {
      return view('crud.main');

    }

    public function projectShow()
    {
      return view('crud.main');

    }

    public function processBoard()
    {
      return view('crud.main');

    }

    public function projectBoard()
    {
      return view('crud.main');

    }

    public function reviewBoard()
    {
      return view('crud.main');

    }

    public function list(){
      return view('customer.crud.main');
    }

    public function new(){
      return view('customer.crud.main');
    }

    public function edit(){
      return view('customer.crud.main');
    }

    public function show(){
      return view('customer.crud.main');
    }

    public function getList(){

     try {

       $data = \App\Models\Customer::get();
       $response['data'] = $data;
       $response['success'] = true;

     } catch (\Exception $e) {
       $response['message'] = $e->getMessage();
       $response['success'] = false;
     }
     return $response;

   }


   public function get($id){

    try {

      $data = \App\Models\Customer::find($id);

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

  public function update(Request $request,$id){

    try {

      $data['name_lastname'] = $request['name'];
      $data['email'] = $request['email'];
      $data['city'] = $request['city'];
      $data['direction'] = $request['address'];
      $data['phone'] = $request['phone'];

      \App\Models\Customer::where("id",$id)->update($data);

      $response['message'] = "Updated successful";
      $response['success'] = true;

    } catch (\Exception $e) {
      $response['message'] = $e->getMessage();
      $response['success'] = false;
    }
    return $response;

  }

  public function delete($id){

    try {
      $res = \App\Models\Customer::where("id",$id)->delete();
      $response['res'] = $res;
      $response['message'] = "Deleted successful";
      $response['success'] = true;
    } catch (\Exception $e) {
      $response['message'] = $e->getMessage();
      $response['success'] = false;
    }

    return $response;
  }

  public function create(Request $request){

     try {

       $insert['name'] = $request->get('name');
       $insert['document'] = $request->get('document');
       $insert['documentType'] = $request->get('documentType');
       $insert['description'] = $request->get('description');
       $insert['contact'] = $request->get('contact');
       $insert['contactEmail'] = $request->get('contactEmail');
       $insert['contactPhone'] = $request->get('contactPhone');

       \App\Models\Customer::insert($insert);

       $response['message'] = "La información del cliente se almaceno correctamente.";
       $response['succes'] = true;

     } catch (\Exception $e) {
       $response['message'] = $e->getMessage();
       $response['succes'] = true;
     }

     return $response;
   }

   public function dashboard(){
     return view('customer.dashboard.main');
   }

   /* INICIO HU 2  */
   private function getQuery($customer_id,$process_id){
    $select = "process.customer,customer.name as cliente";
    $where = "1=1 ";
    $groupBy = "process.customer,customer.name ";

    if(!empty($customer_id)){
        $select = "p.process,process.name" ;
        $where = $where. "AND process.customer = $customer_id ";
        $groupBy = "p.process,process.name ";
    }
    if(!empty($process_id)){
        $select = "p.project,projects.name as proyecto" ;
        $where = $where. "AND p.process = $process_id ";
        $groupBy = "p.project,projects.name ";
    }

    $query = DB::table('projectReview', 'p')
                ->selectRaw($select)
                ->join('process','p.process','=','process.id')
                ->join('customer','process.customer','=','customer.id')
                ->join('projects','p.project','=','projects.id')
                ->whereRaw($where)
                ->groupByRaw($groupBy)
                ->get();
    return $query;
    }

    public function getCustomers(){
        $customers = self::getQuery('','');
        return $customers;
    }

    public function getProcesses($customer_id){
        $processes = self::getQuery($customer_id,'');
        return $processes;
    }

    public function getProjects($customer_id,$process_id){
        $projects = self::getQuery($customer_id,$process_id);
        return $projects;
    }

    public function getViewEvaluations(){
        $url = config("constants.URL");
        return view('reportes.evaluaciones', compact('url'));
    }

    public function prueba(Request $request){
        $valor = $request->input('customer_id');
        return var_dump($valor);
    }

   public function reporteResultados(Request $request){
    $customerId = $request->customer_id;
    $processId = $request->process_id;
    $projectId = $request->project_id;
    $assigneddate = $request->assignedDate;
    $assigneddateend = $request->assignedDateEnd;
    $reviewdate = $request->reviewDate;
    $reviewdateend = $request->reviewDateEnd;
    $where = "1=1 ";

    if(!empty($customerId)){
        $where = $where. "AND process.customer = $customerId ";
    }
    if(!empty($processId)){
        $where = $where. "AND p.process = $processId ";
    }
    if(!empty($projectId)){
        $where = $where. "AND p.project = $projectId ";
    }
    if(!empty($assigneddate) && !empty($assigneddateend)){
        $where = $where. "AND p.assignDate BETWEEN '$assigneddate' AND '$assigneddateend' ";
    }
    if(!empty($reviewdate) && !empty($reviewdateend)){
        $where = $where. "AND p.reviewDate BETWEEN '$reviewdate' AND '$reviewdateend' ";
    }

    $resultados = DB::table('projectReview', 'p')
                ->selectRaw('p.id as reviewId, users.name as evaluador,users.email as email, process.customer,customer.name,p.process,process.name as proceso,p.project,
                            projects.name as proyecto,p.assignDate,p.reviewDate,p.daysLimit,
                            TIMESTAMPDIFF(day,p.assignDate,p.reviewDate)/p.daysLimit*100 as desviacion,
                            TIMESTAMPDIFF(day,p.assignDate,NOW())/p.daysLimit*100 as desviacion2,
                            p.state,p.estadoRevision,p.paymentState')
                ->join('process','p.process','=','process.id')
                ->join('users','users.id','p.reviewer')
                ->join('customer','process.customer','=','customer.id')
                ->join('projects','p.project','=','projects.id')
                ->whereRaw($where )
                ->get();

    foreach($resultados as $resultado){
        if($resultado->desviacion == null ){
            $resultado->desviacion = number_format($resultado->desviacion2,2).'%';
        }else{
            $resultado->desviacion = number_format($resultado->desviacion,2).'%';
        }
    }

    if(!empty($resultados)){
        return $resultados;
    }
    return null;
   }

}
