<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserDetailRequest;
use App\Http\Requests\UpdateUserDetailRequest;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user_details = Auth::user()->userDetails;
        return view('admin.userDetails.create', compact('user_details'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserDetailRequest $request)
    {
        $user = Auth::user();
        $new_user_detail = new UserDetail();
        $new_user_detail->fill($request->validated());
        $new_user_detail->user_id = $user->id;

        $new_user_detail->save();

        return redirect()->route('admin.dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $userDetail = UserDetail::where('user_id', $id)->first();

        if ($userDetail->user_id != Auth::user()->id) {
            abort(404);
        }
        return view('admin.userDetails.edit', compact('userDetail'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserDetailRequest $request, $id)
    {
        $userDetail = UserDetail::where('user_id', $id)->first();
        $userData = $request->validated();

        $userDetail->update($userData);

        return redirect()->route('admin.dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
