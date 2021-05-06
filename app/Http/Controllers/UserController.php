<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->validated());
        return response()->noContent(201);
    }

    public function setAvatar($id, Request $request){
        Validator::make(
            $request->all(),
            ['image' => 'required']
        )->validate();

        if($file = $request->file('image')) {

            $user = User::findOrFail($id);
            $image = str_replace(env('STORAGE_PATH'), '', $user->image);
            if (\Storage::disk('public')->exists($image)){
                \Storage::disk('public')->delete($image);
            }
            $name = env('STORAGE_PATH').'users/avatars/' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public') . '/users/avatars/', $name);
            $user->image = $name;
            $user->save();
        }
        return response($request->all());
    }
    public function bill(User $user, Request $request){
        $user->bill += $request->bill??0;
        $user->save();
        return response()->noContent(201);
    }
}
