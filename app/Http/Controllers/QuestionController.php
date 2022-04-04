<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Response;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;
use Cloudinary\Transformation\Resize;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\FileUploadController;
use App\Http\Requests\Question\StoreQuestionRequest;
use App\Http\Requests\Question\UpdateQuestionRequest;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class QuestionController extends Controller
{


    public function __construct(
        ResponseController $responseController,
        FileUploadController $fileUploader
    ) {
        $this->responseController = $responseController;
        $this->fileUploader = $fileUploader;
    }
    /**
     * get all questions and render
     * @param Request $request
     */
    public function index(Request $request) {
        $currentValues = $request->all();
        $filteredQuestions = $this->filteredQuestions($currentValues);
        $allQuestions = $this->filteredQuestions($currentValues, false, true);

        return view('pages.questions.index', compact('currentValues', 'filteredQuestions', 'allQuestions'));
    }

    /**
     *  Get questions by filter
     * @param Request $currentValues
     * @param Boolean $paginate
     */
    public function filteredQuestions($currentValues, $paginate = true, $allQuestions = false) {

        if($allQuestions == true) {
            $filteredQuestions = DB::table('questions')
            ->select('*')
            ->get();
        } else {
            if(count($currentValues) > 0 && !isset($currentValues['page'])) {
                $query = DB::table('questions')
                ->select('*');

                if(isset($currentValues['search-question']) && $currentValues['search-question'] != null) {
                    $query->where('title', 'like', '%' . $currentValues['search-question'] . '%');
                }
            } else {
                $query = DB::table('questions')
                ->select('*');
            } 

            if($paginate === true) {
                if(isset($currentValues['paginate']) == null) {
                    $filteredQuestions = $query->paginate(100);
                } else {
                    $filteredQuestions = $query->paginate($currentValues['paginate']);
                }
            } else {
                $filteredQuestions = $query->get();
            }
        }

        return $filteredQuestions;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.questions.create');
    }

     /**
     * Create the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {
        $validate = $request->validated();
            
        $file = $request->file('file');

        $fileInfo = $this->fileUploader->upload($file, null, [ 'transformation' => [
            'width' => 600,
            'height' => 600,
            'crop' => 'limit',
            'quality' => 'auto',
            'overwrite'    => true,
        ]]);

        Question::create([
            'title'   => $request->input('title'),
            'file'   => json_encode($fileInfo),
        ]);
        
        return redirect()->route('questions.index')->with([
            'message'   => 'Question has been created successfully !'
        ]);
    }


    /**
     * Show the form for editing the specified resource
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::where('id', $id)->first();
        return view('pages.questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuestionRequest $request, $id)
    {      
        $validate = $request->validated();

        $question = Question::where('id', $id)->first();    
        $file = $request->file('file');
        $fileUpdated = json_decode($question->file);

        $oldFile = $fileUpdated->id;
        if ($oldFile) {
            $this->fileUploader->destroy($oldFile);
        }

        $fileInfo = $this->fileUploader->upload($file, null, [ 'transformation' => [
            'width' => 600,
            'height' => 600,
            'crop' => 'limit',
            'quality' => 'auto',
            'overwrite'    => true,
        ]]);

        $question->update([
            'title'   => $request->input('title'),
            'file'    => json_encode($fileInfo),
        ]);
        
        return redirect()->route('questions.index')->with([
            'message'   => 'Question has been updated successfully !'
        ]);
    }

    /**
     * PATCH is_active column
     */
    public function update_is_active(Request $request) { 
                    
        $question = Question::where('id', $request->input('id'));

        $isActive = ($request->input('active')) ? 1 : 0;

    
        $question->update(['is_active' => $isActive]);

        if($isActive == 1) {
            return response()->json([
                'message' => 
                    'Question has been activated.',
            ], 200);
        } else {
             return response()->json([
                'message' => 
                    'Question has been desactivated.',
            ], 200);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $deletedQuestion = Question::where('id', $id)->first();

        if($deletedQuestion && json_decode($deletedQuestion->file) != null) {
            $deletedQuestion->delete();
            $fileRemoved = json_decode($deletedQuestion->file);
            $oldFile = $fileRemoved->id;
            if ($oldFile) {
                $this->fileUploader->destroy($oldFile);
            }
            return redirect()->route('questions.index')->with([
                'message'   => 'Question has been deleted successfully.',
            ], 200);
        } else {
            return redirect()->route('questions.index')->with([
                'message' => '',
                'error'   => 'Question was not deleted.',
            ], 200);
        }
    }


    /**
     * Show the form for assign responses to a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function assign(Request $request, $id)
    {
        $currentValues = $request->all();
        $question = Question::where('id', $id)->first();
        $allResponses = Response::where('question_id', $id)->get();
        $filteredResponses = $this->responseController->filteredResponses($currentValues, true, false, $id);

        return view('pages.questions.assign', compact('question', 'currentValues', 'filteredResponses', 'allResponses'));
    }

}
