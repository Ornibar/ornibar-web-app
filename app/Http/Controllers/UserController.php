<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\UpdateUserPasswordRequest;

class UserController extends Controller
{
    /**
     * get all users and render
     * @param Request $request
     */
    public function index(Request $request) {
        $currentValues = $request->all();
        $filteredUsers = $this->filteredUsers($currentValues);
        $allUsers = $this->filteredUsers($currentValues, false, true);

        return view('pages.users.index', compact('currentValues', 'filteredUsers', 'allUsers'));
    }

    /**
     *  Get users by filter
     * @param Request $currentValues
     * @param Boolean $paginate
     */
    public function filteredUsers($currentValues, $paginate = true, $allUsers = false) {

        if($allUsers == true) {
            $filteredUsers = DB::table('users')
            ->select('*')
            ->get();
        } else {
            if(count($currentValues) > 0 && !isset($currentValues['page'])) {
                $query = DB::table('users')
                ->select('*');

                if($currentValues['role'] != "Any Role") {
                    $query->where("is_admin", "=", $currentValues['role']);
                }
                if($currentValues['search-user'] != null && $currentValues['search-user'] > 0) {
                    $query->where('firstname', 'like', '%' . $currentValues['search-user'] . '%');
                }
            } else {
                $query = DB::table('users')
                ->select('*');
            } 

            if($paginate === true) {
                if(isset($currentValues['paginate']) == null) {
                    $filteredUsers = $query->paginate(100);
                } else {
                    $filteredUsers = $query->paginate($currentValues['paginate']);
                }
            } else {
                $filteredUsers = $query->get();
            }
        }

        return $filteredUsers;
    }


    /**
     * Show the form for editing the specified resource
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        return view('pages.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {        
        $user = User::where('id', $id)->first();

        if($request->input('is_admin') === "on") {
            $isAdmin = 1;
        }

        $user->update([
            'username'  => $request->input('username'),
            'email'   => $request->input('email'),
            'is_admin'    => isset($isAdmin) ?? 0
        ]);
        
        return redirect()->route('users.index')->with([
            'message'   => 'User has been updated successfully !'
        ]);
    }

    /**
     * Show the form for editing the specified resource
     *
     * @return \Illuminate\Http\Response
     */
    public function edit_password($id)
    {
        $user = User::where('id', $id)->first();
        return view('pages.users.edit-password', compact('user'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update_password(UpdateUserPasswordRequest $request, $id)
    {                
        $validate = $request->validated();
        
        $user = User::where('id', $id)->first();
        
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        
        return redirect()->route('users.index')->with([
            'message'   => 'User password has been updated successfully !'
        ]);
        
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $deletedUser = DB::table('users')->where('id', $id);

        if($deletedUser) {
            $deletedUser->delete();
            return redirect()->back()->with([
                'message'   => 'User has been deleted successfully.',
            ], 200);
        } else {
            return redirect()->back()->with([
                'message' => '',
                'error'   => 'User was not deleted.',
            ], 200);
        }
    }

}
