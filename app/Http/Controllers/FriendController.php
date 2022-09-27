<?php

namespace App\Http\Controllers;

use App\Http\Resources\FriendResource;
use Illuminate\Http\Request;
use App\Models\Friend;
class FriendController extends Controller
{
    public function index(Request $req)
    {
        $req->validate([
            'email'=>'required'
        ]);

        $friend=Friend::where('to',$req->email)->where('status',"Accepted");
        return response()->json(new FriendResource($friend->get()));
    }

    public function request_friend(Request $req)
    {
        $req->validate([
            'requestor'=>'required',
            'to'=>'required'
        ]);
        $data=$req->only('requestor','to');
         $data['status']="Pending";
        $friend=Friend::create($data);

        return response()->json([
            'success'=>"true"
        ]);
    }
    public function change_accept_or_rejection(Request $req)
    {
        $req->validate([
            'requestor'=>'required',
            'to'=>'required'
        ]);

        $check=Friend::where('requestor',$req->requestor)->where('to',$req->to)->first();
        if($check->status!="Pending")
        {
            return response()->json([
                'success'=>"false"
            ]);
        }
        $check->status="Accepted";
        $check->save();


        return response()->json([
             'success'=>"true"
        ]);
    }
    public function rejection(Request $req)
    {

        $req->validate([
            'requestor'=>'required',
            'to'=>'required'
        ]);

        $check=Friend::where('requestor',$req->requestor)->where('to',$req->to)->first();

        if($check->status!="Pending")
        {
            return response()->json([
                'success'=>"false"
            ]);
        }

        $check->status='Rejection';
        $check->save();

        return response()->json([
            'success'=>"true"
        ]);
    }
    public function blocked(Request $req)
    {

        $req->validate([
            'requestor'=>'required',
            'block'=>'required'
        ]);
        $check=Friend::where('requestor',$req->requestor)->where('to',$req->to)->first();
        if($check->status=='Blocked'){
            return response()->json([
                'success'=>"false"
            ]);
        }
        if($check){
            $check->status="Blocked";
            $check->save();

            return response()->json([
                'success'=>"true"
            ]);
        }
        $data=$req->all();
        $data['status']="Blocked";
        $friend=Friend::create([$data]);

        return response()->json([
            'success'=>"true"
        ]);
    }
    public function list_of_friend_status(Request $req)
    {
        $req->validator([
            'email'=>'request'
        ]);
        
        $friend=Friend::where('to',$req->email)->where('status','<>','Blocked');

        return response()->json(['requestor'=>$friend->get()]);
    }


}
