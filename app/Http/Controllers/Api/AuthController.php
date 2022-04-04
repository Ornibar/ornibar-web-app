<?php
   
namespace App\Http\Controllers\Api;
   
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\User\StoreUserRequest;
   
class AuthController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(StoreUserRequest $request)
    {
        try{
            $inputs = $request->all();
            $inputs['password'] = bcrypt($inputs['password']);
            $user = User::create($inputs);

            // $success['token'] =  $user->createToken('token')->plainTextToken;
            // $success['username'] =  $user->username;
   
            return $this->sendResponse('', 'User registered successfully.');
        } catch(Exception $e) {
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised'], 403);
        }
    }

   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        $user = User::where("email",$request->input('email'))->first();

        if($user == null) {
            return $this->sendError('User not found', '', 404);
        }

        $password = Hash::make($request->input('password'));
        $tokenresult = null;

        try {
            if(password_verify($request->input('password'), $user->password)) {
                $token = $user->createToken("token");
                $tokenresult = $token->plainTextToken;

                $success['token'] =  $tokenresult; 
                $success['user_id'] =  $user->id;
                
                return $this->sendResponse($success, 'User login successfully.');
            } else {
                return $this->sendError('Password is not matching', '', 400);
            } 
        } catch(Exception $e) {
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised'], 403);
        }
    }

    
    /**
     * Reset Password api
     *
     * @return \Illuminate\Http\Response
     */
    public function reset_password(Request $request)
    {
        if($request->all()){ 
            $credentials = request()->validate(['email' => 'required|email']);

            // $user = User::where("email",$credentials['email'])->first();

            // if($user == null) {
            //     return $this->sendError('User not found', '', 404);
            // }

            Password::sendResetLink($credentials);
   
            return $this->sendResponse('', 'Reset password link sent on your email');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised'], 403);
        } 
    }

    /**
     * Logout user api
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request) {
        // if ($request) {
        //     $accessToken = Auth::user()->token();
        //     $token = $request->user()->tokens->find($accessToken);
        //     $token->revoke();
        //     return $this->sendResponse('', 'Logged out succesfully');
        // }       
        if($request) {
            return $this->sendResponse(null, 'User is logout');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }  
    }
}