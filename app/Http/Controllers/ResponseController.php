<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Response\StoreResponseRequest;
use App\Http\Requests\Response\UpdateResponseRequest;

class ResponseController extends Controller
{
    /**
     * get all questions and render
     * @param Request $request
     */
    public function index(Request $request) {
            
        $currentValues = $request->all();
        $filteredResponses = $this->filteredResponses($currentValues);
        $allResponses = $this->filteredResponses($currentValues, false, true);

        return view('pages.responses.index', compact('currentValues', 'filteredResponses', 'allResponses'));
    }

    /**
     *  Get responses by filter
     * @param Request $currentValues
     * @param Boolean $paginate
     */
    public function filteredResponses($currentValues, $paginate = true, $allResponses = false, $id  = null) {

        if($allResponses == true) {
            $filteredResponses = DB::table('responses')
            ->select('*')
            ->get();
        } else {
            if(count($currentValues) > 0 && !isset($currentValues['page'])) {
                $query = DB::table('responses')
                ->select('*');

                if($id != null) {
                    $query->where('question_id', $id);
                }

                if(isset($currentValues['search-response']) && $currentValues['search-response'] != null) {
                    $query->where('name', 'like', '%' . $currentValues['search-response'] . '%');
                }
            } else {
                $query = DB::table('responses')
                ->select('*');
            } 

            if($paginate === true) {
                if($id != null) {
                    $query->where('question_id', $id);
                }
                if(isset($currentValues['paginate']) == null) {
                    $filteredResponses = $query->paginate(100);
                } else {
                    $filteredResponses = $query->paginate($currentValues['paginate']);
                }
            } else {
                $filteredResponses = $query->get();
            }
        }
        
        return $filteredResponses;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {       
        $allQuestions = Question::all();
        $currentValues = $request->all();
        $filteredResponses = $this->filteredResponses($currentValues);
        $allResponses = $this->filteredResponses($currentValues, false, true);

        return view('pages.responses.create', compact('allQuestions', 'currentValues', 'filteredResponses', 'allResponses'));
    }

     /**
     * Create the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function store(StoreResponseRequest $request)
    {        
        $validate = $request->validated();

        Response::create([
            'name'   => $request->input('name'),
            'question_id'   => $request->input('question_id'),
        ]);
        
        return redirect()->route('responses.index')->with([
            'message'   => 'Response has been created successfully !'
        ]);
    }


    /**
     * Show the form for editing the specified resource
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $response = Response::where('id', $id)->first();
        return view('pages.responses.edit', compact('response'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateResponseRequest $request, $id)
    {        
        $response = Response::where('id', $id)->first();

        $response->update([
            'name'         => $request->input('name'),
            'title'   => $request->input('title'),
        ]);
        
        return redirect()->route('responses.index')->with([
            'message'   => 'Response has been updated successfully !'
        ]);
    }

    /**
     * PATCH is_active column
     */
    public function update_is_active(Request $request) {                
        $response = Response::where('id', $request->input('response_id'));
        $responsesActives = Response::where('question_id', $request->input('question_id'))->where('is_active', '1')->get();
        
        if(count($responsesActives) < 4 || count($responsesActives) == 4 && $request->input('active') == 0) {
            $isActive = ($request->input('active')) ? 1 : 0;
            $response->update(['is_active' => $isActive]);

            if($isActive == 1) {
                return response()->json([
                    'message'       => 
                        'Response has been assign successfully.',
                ], 200);
            } else {
                return response()->json([
                    'message'       => 
                        'Response has been unassign successfully.',
                ], 200);
            }
        } else {
            return response()->json([
                'message'       => 
                    'Only 4 responses can be selected',
            ], 200);
        }
    }
    

    public function random_assign($id) {

        $allActivesResponses = Response::where('question_id', $id)->orWhere('is_active', '1')->get();
        $allQuestionResponses = Response::where('question_id', $id)->get();
        
        if(count($allActivesResponses) < 4) {
            if(count($allQuestionResponses) <= 4) {
                foreach($allQuestionResponses as $response) {
                    $response->update(['is_active' => '1']);
                } 
            } else {
                $randomResponses = Response::all()->where("question_id", $id)->random(4 - count($allActivesResponses));
                foreach($randomResponses as $response) {
                    $response->update(['is_active' => '1']);
                } 
            }
        } else {
            foreach($allActivesResponses as $response) {
                $response->update(['is_active' => '0']);
            } 
            $randomResponses = Response::all()->where("question_id", $id)->random(4);
            foreach($randomResponses as $response) {
                $response->update(['is_active' => '1']);
            } 
        }
        return redirect()->back()->with([
            'message'   => 'Response has been assigned successfully.',
        ], 200);
    }

    /** 
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id) {
        $deletedResponse = DB::table('responses')->where('id', $id);

        if($deletedResponse) {
            $deletedResponse->delete();
            return redirect()->back()->with([
                'message'   => 'Response has been deleted successfully.',
            ], 200);
        } else {
            return redirect()->back()->with([
                'message' => '',
                'error'   => 'Response was not deleted.',
            ], 200);
        }
    }

}
