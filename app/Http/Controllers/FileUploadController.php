<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Response;
use Illuminate\Http\Request;

use JD\Cloudder\Facades\Cloudder;
use Illuminate\Support\Facades\DB;
use Cloudinary\Transformation\Resize;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class FileUploadController extends Controller
{


    public function __construct(ResponseController $responseController) {
        $this->responseController = $responseController;
    }



     /**
     * Upload the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function upload($file, $publicId, array $transformation, $userProfileImage = false)
    {
        if($userProfileImage == true){
            $fileUploaded = Cloudder::upload($file, $publicId,[
                "folder" => 'Ornibar/Users/Images',
                $transformation
            ]);
        } else {
            if(str_contains($file->getMimeType(), 'image')) {
                $fileUploaded = Cloudder::upload($file, $publicId,[
                    "folder" => 'Ornibar/Questions/Images',
                    $transformation
                ]);
            } else {
                $fileUploaded = Cloudder::uploadVideo($file, $publicId, [ 
                    "folder" => 'Ornibar/Questions/Videos',
                    $transformation
                ]);
            }
        }

        $fileInfo = [
            'url' => $fileUploaded->getResult()["secure_url"],
            'id' => $fileUploaded->getResult()["public_id"],
            'type' => $fileUploaded->getResult()['resource_type'],
        ];

        return $fileInfo;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($publicId)
    {
        if($publicId) {
            Cloudder::destroyImage($publicId);
            Cloudder::delete($publicId);
        }
    }
}
