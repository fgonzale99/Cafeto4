<?php

   

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\FormReview;
use Validator;
use App\Http\Resources\FormReview as FormReviewResource;
class FormReviewController extends BaseController

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $formReview = FormReview::all();

    

        return $this->sendResponse(FormReviewResource::collection($formReview), 'Forms retrieved successfully.');

    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

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

   

        $formReview = FormReview::create($input);

   

        return $this->sendResponse(new FormReviewResource($formReview), 'Forms created successfully.');

    } 

   

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {
      

        $formReview = FormReview::find($id);

  

        if (is_null($formReview)) {

            return $this->sendError('Form not found.');

        }

   

        return $this->sendResponse(new FormReviewResource($formReview), 'Form retrieved successfully.');

    }

    

    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, FormReview $formReview)

    {

        $input = $request->all();

   

        $validator = Validator::make($input, [

            'name' => 'required',

            'detail' => 'required'

        ]);

   

        if($validator->fails()){

            return $this->sendError('Validation Error.', $validator->errors());       

        }

   

        $formReview->name = $input['name'];

        $formReview->detail = $input['detail'];

        $formReview->save();

   

        return $this->sendResponse(new FormReviewResource($formReview), 'Form updated successfully.');

    }

   

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy(FormReview $formReview)

    {

     

        $formReview->delete();



        return $this->sendResponse([$formReview], 'Form deleted successfully.');

    }

}