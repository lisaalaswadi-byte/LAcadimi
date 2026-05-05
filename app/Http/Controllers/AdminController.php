<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\AI\Client;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Video;
use App\Models\Info;
use App\Models\Catigory;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function publish(){

    return view("publish");
    }

    public function setPublish(Request $request){
       
        $request->validate([
            'title'=>["required","string",'max:500'],
            "video"=>['required','file',"max:20500",'mimes:mp4,mov,quicktime'],
            "catigory_id"=>["required","numeric"]
            
        ]);
        
        DB::beginTransaction();
        
        try{
            $store=Video::create([
                "title"=>$request->title,
                'video'=>$request->file('video')->store('video','public'),
                "catigory_id"=>$request->catigory_id,
            ]);
            DB::commit();
            return back()->with("done","successfully published ✅ ");
        }
       catch(\Exception $e){
            DB::rollback();
            return back();
        }

        return back();
    }

  
    public function news(){

    return view("news");
    }

    public function setInfos(Request $request){
        $request->validate([
            "info"=>["required","string",'max:700'],
            "image"=>["required","file","max:20500"],
        ]);
        DB::beginTransaction();
        try{
            $new=Info::create([
                "info"=>$request->info,
                "image"=>$request->file("image")->store("news","public"),
            ]);
            DB::commit();
            return back()->with("pop","done published ✅");
        }
        catch(\Exception $e){
            DB::rollback();
            return back();
        }

    return back();
    }
}
