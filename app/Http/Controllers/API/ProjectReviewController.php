<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\ProjectReview;
use Validator;
use App\Http\Resources\ProjectReview as ProjectReviewResource;

use App\Filters\V1\ProjectReviewFilter;

class ProjectReviewController extends BaseController
{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */



     public function index(Request $request)
     {

 
 
         $filter = new ProjectReviewFilter();
         $queryItems = $filter->transform($request); //[['column','operator','value']]
 
 
          if (count($queryItems) == 0 )
          {
 
             $ProjectReview = ProjectReview::paginate();
             return $this->sendResponse(ProjectReviewResource::collection($ProjectReview), 'Forms retrieved successfully.');
 
          }
          else
          {
             $ProjectReview =    ProjectReview::where($queryItems)->paginate();
 
             return $this->sendResponse(ProjectReviewResource::collection($ProjectReview), 'Forms retrieved successfully.');
 
          }
         
         
     }

     
     public function store(Request $request)
 
     {
 
         $input = $request->all();
 
    
 
         $validator = Validator::make($input, [
 
             'name' => 'required',
 
             'detail' => 'required'
 
         ]);
 
    
 
         if($validator->fails()){
 
             return $this->sendError('Validation Error.', $validator->errors());       
 
         }
 
    
 
         $ProjectReview = ProjectReview::create($input);
 
    
 
         return $this->sendResponse(new ProjectReviewResource($ProjectReview), 'Forms created successfully.');
 
     } 
 
    
 
     /**
 
      * Display the specified resource.
 
      *
 
      * @param  int  $id
 
      * @return \Illuminate\Http\Response
 
      */
 
     public function show($id)
  
     {
           
 
         $ProjectReview = ProjectReview::with('getProject.getProcess')->with('getReviewer')->find($id);
 
   
 
         if (is_null($ProjectReview)) {
 
             return $this->sendError('Form not found.');
 
         }
 
    
 
         return $this->sendResponse(new ProjectReviewResource($ProjectReview), 'Form retrieved successfully.');
 
     }
 
     
 
     /**
 
      * Update the specified resource in storage.
 
      *
 
      * @param  \Illuminate\Http\Request  $request
 
      * @param  int  $id
 
      * @return \Illuminate\Http\Response
 
      */
 
     public function update(Request $request, ProjectReview $ProjectReview)
 
     {
 
         $input = $request->all();
 
    
 
         $validator = Validator::make($input, [
 
             'name' => 'required',
 
             'detail' => 'required'
 
         ]);
 
    
 
         if($validator->fails()){
 
             return $this->sendError('Validation Error.', $validator->errors());       
 
         }
 
    
 
         $ProjectReview->name = $input['name'];
 
         $ProjectReview->detail = $input['detail'];
 
         $ProjectReview->save();
 
    
 
         return $this->sendResponse(new ProjectReviewResource($ProjectReview), 'Form updated successfully.');
 
     }
 
    
 
     /**
 
      * Remove the specified resource from storage.
 
      *
 
      * @param  int  $id
 
      * @return \Illuminate\Http\Response
 
      */
 
     public function destroy(ProjectReview $ProjectReview)
 
     {
 
      
 
         $ProjectReview->delete();
 
 
 
         return $this->sendResponse([$ProjectReview], 'Form deleted successfully.');
 
     }
}
