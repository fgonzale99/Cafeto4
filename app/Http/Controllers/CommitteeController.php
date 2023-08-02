<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommitteeController extends Controller
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

    public function reviewList()
    {
      return view('crud.main');
    }

    public function getReviewList()
    {

      try {

        $elements = DB::table('reviewAudit')
                    ->join('projectReview', 'review', '=', 'projectReview.id')
                    ->join('projects', 'projectReview.project', '=', 'projects.id')
                    ->join('process', 'projects.process', '=', 'process.id')
                    ->where('reviewAudit.user', '=', auth()->user()->id)
                    ->select('reviewAudit.id','projectReview.progress','projectReview.result','reviewAudit.state','process.name as process','projects.name as project')
                    ->get();

        $response['data'] = $elements;
        //$response['total'] = $dataTotal;
        //$response['pagesTotal'] = $pagesTotal;
        $response['success'] = true;

      } catch (\Exception $e) {
        $response['message'] = $e->getMessage();
        $response['success'] = false;
      }
      return $response;

    }

    public function getReview()
    {
      $elements = \App\Models\Process::where('institucion', 10027)->orderBy('id','DESC')->paginate(20);
      return view('customer.process.list', compact('elements'));
    }

    public function auditReviewEval()
    {
      return view('crud.main');
    }

    public function auditShow()
    {
      return view('crud.main');
    }

    public function auditSummary()
    {
      return view('crud.main');
    }

    public function auditSave(Request $request){

      $idElement = $request->id;
      $className = "\App\Models\ReviewAudit";

      try {

        foreach ($request->all() as $key => $value) {
            if($key!=='model' && $key!=='id') $update[$key] = $value;
        };

        $element = ("{$className}::find")($idElement);

        $update['state'] = 'Revisado';

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

    public function auditReviewSave(Request $request){

      $idElement = $request->id;
      $className = "\App\Models\ReviewAudit";

      try {

        foreach ($request->all() as $key => $value) {
            if($key!=='model' && $key!=='id') $update[$key] = $value;
        };

        $element = ("{$className}::find")($idElement);

        $update['state'] = 'Revisado';

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

    public function getAudit(Request $request)
    {
      try {

        $data = \App\Models\ReviewAudit::where('review', $request->id)->first();

        $response['data'] = $data;
        $response['success'] = true;

      } catch (\Exception $e) {
        $response['message'] = $e->getMessage();
        $response['success'] = false;
      }
      return $response;
    }

    public function getCommitteeAudit($id)
    {
      try {

        $data = \App\Models\ReviewAudit::find($id);

        $response['data'] = $data;
        $response['success'] = true;

      } catch (\Exception $e) {
        $response['message'] = $e->getMessage();
        $response['success'] = false;
      }
      return $response;
    }

    public function reviewSummary(Request $request)
    {
      return view('crud.main');
    }

    public function reviewerShow(Request $request)
    {
      return view('crud.main');
    }

    public function getReviewer($id)
    {
      try {

        $review = \App\Models\ProjectReview::find($id);
        $data = $review->getReviewer;

        $response['data'] = $data;
        $response['success'] = true;

      } catch (\Exception $e) {
        $response['message'] = $e->getMessage();
        $response['success'] = false;
      }
      return $response;
    }

}
