<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserContact;
use Illuminate\Http\Request;
use Mockery\Container;

class UserController extends Controller
{
    function changeAvatar(Request $request) {
        $request->validate([
            'image' => 'required|image'
        ]);
        $user = User::first();
        $imagePrev = $user->avatar;
        $user->avatar = uniqid().rand().time().'.'.$request->image->extension();
        if($user->save()){
            if ($imagePrev && file_exists(public_path().'/images/'.$imagePrev)) {
                unlink(public_path().'/images/'.$imagePrev);
            }
            $request->image->move('images',$user->avatar);
            return response()->json(['data' => $user]);
        }
    }
    function getContact(){
        return response()->json(['data' => UserContact::all()]);
    }
    function addContact(Request $request) {

        $request->validate([
            'contact.contact' => 'required',
        ]);
        if (isset($request->contact['id'])) {
            $con = UserContact::findOrFail($request->contact['id']);
        } else {
            $con = new UserContact();
        }
        $con->user = auth()->user()->id;
        $con->icon = $request->contact['icon'];
        $con->text = $request->contact['text'];
        $con->contact = $request->contact['contact'];
        $con->save();
        return response()->json(['data' => $con]);
    }
    function deleteContact($id){
        if(UserContact::findOrFail($id)->delete()){
            return response('',200);
        }
    }
    function saveInfo(Request $request){
        $request->validate([
            'info' => 'required|string'
        ]);
        $user = User::first();
        $user->info = $request->info;
        $user->save();
        return response('',200);
    }
    function saveAddress(Request $request){
        $request->validate([
            'address' => 'required|string'
        ]);
        $user = User::first();
        $user->address = $request->address;
        $user->save();
        return response('',200);
    }
    function saveBio(Request $request){
        $request->validate([
            'bio' => 'required|string'
        ]);
        $user = User::first();
        $user->bio = $request->bio;
        $user->save();
        return response('',200);
    }
    function personalInfo(Request $request){
        $request->validate([
            'name' => 'required'
        ]);
        $user = User::first();
        $user->name = $request->name;
        if (isset($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return response('',200);
    }
}
