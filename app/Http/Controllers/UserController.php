<?php

    
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\Info;
use App\Models\Video;
use App\Models\Catigory;
use App\Models\Login;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
   public function AI(){
    return view("AI");
   }
    


    public function python(){
        return view("python");
    }

    public function frontEnd(){
        return view('HTMLCSSJS');
    }

    public function index(){
        $catigory=Catigory::all();
        return view('userIndex',compact("catigory"));
    }

    public function show($id){
      $course=Catigory::with("videos")->findOrFail($id);
    return view("catigory",compact('course'));
    }

    public function userNews(){
    $news=Info::all();
    return view("userNews",compact("news"));
    }
    
    public function login(){
        return view("log");
    }

    public function setLogin(Request $request)
    {
        $request->validate([
            "email"=>['required',"email"],
            "name"=>["required","min:4","max:30"],
            
        ]);

        DB::beginTransaction();
      
        try{
            $user=Login::create([
                "name"=>$request->name,
                "email"=>$request->email,
            ]);
          
            DB::commit();
            session(["student"=>[
                "name"=>$request->name,
                "email"=>$request->email,
            ]]);
            return redirect()->route("userIndex")->with("l","تم تسجيل الدخول بنجاح  ✅ ");
        }
        catch(\Exception){
            DB::rollBack();
            return back();
        }


    }
}
/*
شؤؤثسس فخنثى EAAiFPnYprsIBRYZC9EIAYiQcgTdjBRUiAT511ZC9aIsoGTMlhdV6WTw1SBU7oxroI2md55YCh5P1YZCNQ1ZBvZBVQj5sbUriEEn4c2mIDjKSQZAcHvFdFZB7trHKAyhScLZCZByYsD1u5Lh3WeZBas44HezgOTEmEBUq7vfeynuxn3NRz8sUl2H6T8zbwYpnHMx2n8ciSoko74u8WPHkAqFZApn1ayuk9ciza0Ac3F4rkVpLPYnkJnZC4b7ZCUirQ1THZCnXj6sZCQegnB82sL8LtU2g1RDBqsZBZBORx6TyL3KdzqWaex0NI8Qf6NEKHZBXEecf5A4AdZBcuSLGoDd
EAAiFPnYprsIBRYZC9EIAYiQcgTdjBRUiAT511ZC9aIsoGTMlhdV6WTw1SBU7oxroI2md55YCh5P1YZCNQ1ZBvZBVQj5sbUriEEn4c2mIDjKSQZAcHvFdFZB7trHKAyhScLZCZByYsD1u5Lh3WeZBas44HezgOTEmEBUq7vfeynuxn3NRz8sUl2H6T8zbwYpnHMx2n8ciSoko74u8WPHkAqFZApn1ayuk9ciza0Ac3F4rkVpLPYnkJnZC4b7ZCUirQ1THZCnXj6sZCQegnB82sL8LtU2g1RDBqsZBZBORx6TyL3KdzqWaex0NI8Qf6NEKHZBXEecf5A4AdZBcuSLGoDd
*/