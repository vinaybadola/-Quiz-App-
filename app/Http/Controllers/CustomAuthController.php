<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Flash;

class CustomAuthController extends Controller
{
    public function login(){
        return view("auth.login");
    }
    public function registration(){

        $course=Course::get();
        return view("auth.registration")->with('courses',$course) ;
        
    }

    public function registerUser(Request $request){

        // return $request;
       
        $validated=$request->validate([
            'name'=>'required',
            'email'=>'required |email|unique:users',
            'password'=>'required|min:4|max:12',
            'contact'=>'required | min:5 | max:12',
            
            
        ]);

        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->contact=$request->contact;
        $user->course_id=$request->course;
        $res=$user->save();
        return redirect('login');
        if($res)
        {
            return back()->with('success','you have registered successfully !');
        }
        else
        {
            return back()->with('fail','Something Want wrong ?');
        }
    }

    public function loginUser(Request $request)
    {
       $validated=$request->validate([
        
        'email'=>'required |email',
        'password'=>'required|min:4|max:12',
       ]);
       $user = User::where('email','=',$request->email)->first();
       
       if($user)
        {
            if(Hash::check($request->password,$user->password)){
                $request->session()->put('loginId',$user->id);
                return redirect('dashboard');
            }
            else
            {
                return back()->with('fail','Password Not Matched ');
            }
        }
        else
        {
            return back()->with('fail','This email is not registered ?');
        }
    }
   
    public function dashboard(){
        
       // return Session()->forget('loginId');
       //return Session::get('loginId');

       
        
        $user_id=Session::get('loginId');
        $user=User::find($user_id);
        $user_course=$user->course_id;

        
        $course_name = Course::find($user_course);
        $data = array();

        if(Session::has('loginId')){
            $data = User::where('id','=',Session::get('loginId'))->first();
            
           
        }
        
        return view('dashboard')->with('data',$data)->with('course',$course_name);
    }
  
    
    

    public function showCourseName(){
        $user_id=Session::get('loginId');
        $user=User::find($user_id);
        $user_course=$user->course_id;
        $course_name = Course::find($user_course);
        return $course_name;
    }

    public function logout(){
        if(Session::has('loginId')){
            Session::pull('loginId');
            return redirect('login');
        }
    }
}
