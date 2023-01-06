<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $users->transform(function ($user) {
            $user->role = $user->getRoleNames();
            return $user;
        });

        return view('backend.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('staff');
        }

        $user = User::create([
            'name' => $data['name'],
            "middlename" => $data['middlename'],
            "lastname" => $data['lastname'],
            "email" =>  $data['email'],
            "password" => Hash::make($data['password']),
            "phone" => $data['phone'],
            "gender" => $data['gender'],
            "status" => $data['status'],
            "dob" => $data['dob'],
            "bank" => $data['bank'],
            "account_name" => $data['account_name'],
            "account_number" => $data['account_number'],
            "category_id" => $data['category_id'],
            "level_id" => $data['level_id'],
            "religion" => $data['religion'],
            "marital_status" => $data['marital_status'],
            "blood_group" => $data['blood_group'],
            "nationality" => $data['nationality'],
            "qualification" => $data['qualification'],
            "address" => $data['address'],
            "photo" => $path,
        ]);

        $user->assignRole($data['role']);

        if ($request->has('permission_id')) {
            $user->givePermissionTo($data['permission_id']);
        }

        if ($user) {
            toast('User created successfully', 'success');
            return redirect()->route('user.index');
        } else {
            toast('User not created', 'error');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('backend.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $data = $request->validated();

        $user = User::find($id);

        $user->name = $data['name'];
        $user->middlename = $data['middlename'];
        $user->lastname = $data['lastname'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->gender = $data['gender'];
        $user->status = $data['status'];
        $user->dob = $data['dob'];
        $user->bank = $data['bank'];
        $user->account_name = $data['account_name'];
        $user->account_number = $data['account_number'];
        $user->category_id = $data['category_id'];
        $user->level_id = $data['level_id'];
        $user->religion = $data['religion'];
        $user->marital_status = $data['marital_status'];
        $user->blood_group = $data['blood_group'];
        $user->nationality = $data['nationality'];
        $user->qualification = $data['qualification'];
        $user->address = $data['address'];


        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('staff');
            $user->photo = $path;
        }

        $user->assignRole($data['role']);

        if ($user->save()) {
            toast('User updated successfully', 'success');
            return redirect()->route('user.index');
        } else {
            toast('User not updated', 'error');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        Storage::disk('staff')->delete($user->photo);

        $delete = $user->delete();
        if ($delete) {
            toast('User deleted successfully', 'success');
            return redirect()->route('user.index');
        } else {
            toast('User not deleted', 'error');
            return redirect()->back();
        }
    }
}
