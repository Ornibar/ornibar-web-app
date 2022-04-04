<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\UpdateUserScoreRequest;
use App\Http\Requests\User\UpdateUserProfileImageRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() : AnoymousResourceCollection
    {
        return UserResource::collection(User::all());
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(UpdateUserRequest $request, $id)
    {
        if($id) {
            $user = User::where("id", $id)->first();
            if($user == null) {
                return $this->sendError('User not found', '', 404);
            }          
        } 
        else {
            return $this->sendError('Integer is expected', '', 400);
        }

        try{
            $user->username = $request->input('username') ?? $user->username;
            $user->email = $request->input('email') ?? $user->email;
            $user->update();

            return $this->sendResponse($user, 'User updated succesfully');
        } catch(Exception $e) {
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised'], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateScore(UpdateUserScoreRequest $request, $id)
    {
        if($id) {
            $user = User::where("id", $id)->first();
            if($user == null) {
                return $this->sendError('User not found', '', 404);
            }          
        } 
        else {
            return $this->sendError('Integer is expected', '', 400);
        }

        try{
            $user->score = intval($request->input('score')) ?? $user->score;
            $user->update();

            return $this->sendResponse($user, 'User score updated succesfully');
        } catch(Exception $e) {
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised'], 403);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateProfileImage(UpdateUserProfileImageRequest $request, $id)
    {
        if($id) {
            $user = User::where("id", $id)->first();
            if($user == null) {
                return $this->sendError('User not found', '', 404);
            }          
        } 
        else {
            return $this->sendError('Integer is expected', '', 400);
        }

        try{
            $file = $request->file('file');
            $fileUpdated = json_decode($user->image);

            $oldFile = $fileUpdated->id;
            if ($oldFile) {
                $this->fileUploader->destroy($oldFile);
            }

            $fileInfo = $this->fileUploader->upload($file, null, [ 'transformation' => [
                'width' => 40,
                'height' => 40,
                'crop' => 'limit',
                'quality' => 'auto',
                'overwrite'    => true,
            ]], true);


            $user->image = json_encode($fileInfo) ?? $user->image;
            $user->update();

            return $this->sendResponse($file, 'User image updated succesfully');
        } catch(Exception $e) {
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised'], 403);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) 
    {
        if($id) {
            $user = User::where("id", $id)->first();
            if($user == null) {
                return $this->sendError('User not found', '', 404);
            }          
        } 
        else {
            return $this->sendError('Integer is expected', '', 400);
        }

        try{
            $user->delete();

            return $this->sendResponse('', 'User deleted succesfully');
        } catch(Exception $e) {
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised'], 403);
        }
    }
}
