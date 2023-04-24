<?php

namespace App\Http\Controllers;

use App\Models\QuizQuestion;
use App\Models\QuizResult;
use App\Models\QuizQuestionAttempt;
use App\Models\User;
use App\Models\StudentQuiz;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{

    public function start_quiz()
    {

        $user_id = Session::get('loginId');
       
       

        $store = new StudentQuiz();
        $store->marks = "";
        $store->user_id = $user_id;
        $store->total_attempt = 0;
        $store->save();

        $stu = StudentQuiz::get('id')->last();
        Session::put('quiz_id', $stu);
        //return $stu;


        $demo = Session::get('quiz_id');
        $quiz_id = $demo->id;
        //return $quiz_id;

      
        

       // $students = QuizQuestion::where('course_id', $user_course)->limit(1)->get();
         $students= $this->fetch_question($quiz_id);
        return view('question', ['display' => $students]);
    }




//!     Showing the Next Questions to User 
    public function add(Request $request)
    {

        $isCorrect= false;
        $user_id = Session::get('loginId');
        $user = User::find($user_id);
        $user_course = $user->course_id;
        //return $user_course;

        $demo = Session::get('quiz_id');
        $quiz_id = $demo->id;
        //return $quiz_id;

        $option_id = $request->input('option_id');
        //return $option_id;
        $question_id = $request->input('ques->id');
        //return $question_id;

    //   $answer = QuizQuestion::where('course_id', $user_course)->pluck('answer');
        
    //   foreach($answer as $ans){
    //      echo  $ans . '<br>';
    //   }

      //echo  $res;
       // return $answer;

        // foreach ($answer as $ans) {
        //     if ($ans->answer == $option_id) {
        //         $isCorrect = true;
        //     } elseif ($option_id == 0) {
        //         $isCorrect = false;
        //     } else {
        //         $isCorrect = false;
        //     }
        // }


        // if($answer == $option_id){
        //   $isCorrect = 1;
        // }

        // return $isCorrect;

        


        $store_quiz = new QuizQuestionAttempt();
        $store_quiz->selected_ans = $option_id;
        $store_quiz->isCorrect = $isCorrect;
        $store_quiz->question_id = $question_id;
        $store_quiz->quiz_id = $quiz_id;
        $store_quiz->save();


     
           


            $answers=$this->fetch_question($quiz_id);
            if(count( $answers)>0)
            {
                return view('question', ['display' => $answers]);
            }
            else
            {
                
                return  view('submit');
            }

            


                    
       
    }
    

    public function fetch_question($quiz_id)
    {
        $user_id = Session::get('loginId');
        $user = User::find($user_id);
        $user_course = $user->course_id;

        $answer=QuizQuestion::where('course_id', $user_course)->whereNotIn('id',function($q)use($quiz_id){
            $q->select('question_id')->from('quiz_question_attempts')->where('quiz_id',$quiz_id);
        })->limit(1)->get();

        return $answer;
    }

    //!     Evaluating the User Question
    public function evaluate(Request $request)
    {




        $user_id = Session::get('loginId');
        $user = User::find($user_id);
        $user_course = $user->course_id;

        $demo = Session::get('quiz_id')->id;
       


            $response = DB::table('quiz_question_attempts')
                        ->join('quiz_questions', 'quiz_question_attempts.question_id', '=', 'quiz_questions.id')
                        ->where('quiz_question_attempts.quiz_id', $demo)
                        ->select('quiz_question_attempts.selected_ans', 'quiz_questions.answer')
                        
                        ->get();

            // return $response;
            $correct = 0;
            $no_attempt= 0;
            $incorrect = 0;
            $no_attempt= 0;
            $result = 0;
            foreach ($response as $resp){
               if($resp->selected_ans == $resp->answer){
                $correct++;
               }
           
               else if($resp->selected_ans == 0){
                $no_attempt++;
               }
               else{
                  $incorrect++;
               }

            }

         $result  = ($correct * 2);
          if ($result > 2) {
            $grade = "Pass";
         } else {
            $grade = "Fail";
         }


        $store_quiz = new QuizResult();
        $store_quiz->result = $result;
        $store_quiz->marks = $grade;
        $store_quiz->correct = $correct;
        $store_quiz->Incorrect = $incorrect;
        $store_quiz->No_Attempt = $no_attempt;
        $store_quiz->user_id = Session::get('loginId');
        $store_quiz->save();


        // return $total_attempt;



        //!    Update the StudentQuiz table
        $updt = StudentQuiz::find($demo);
        $updt->total_attempt = 1;
        $updt->marks = $grade;
        $updt->save();





        $score = [];

        $score['result'] = $result;
        $score['marks'] = $grade;
        $score['correct'] = $correct;
        $score['incorrect'] = $incorrect;
        $score['no_attempt'] = $no_attempt;
        $score['user_id'] = Session::get('loginId');
        $score['time'] = $store_quiz->get('created_at')->last();
        return view("result", compact('score'));

        //  return $score;

    }



    //!    Fetching the data from a particular user 
    public function showHistory(Request $request)
    {

        $user_id = Session::get('loginId');

        $user_name = User::find($user_id);



        $data = array();
        if (Session::has('loginId')) {
            $data = QuizResult::where('user_id', '=', Session::get('loginId'))->get();
        }
        // return $data;
        // return $user_name;
        return view("history")->with('data', $data)->with('name', $user_name);
    }


    //!       Show the leaderboard 
    public function showResult()
    {


        $ans = QuizResult::all()->sortByDesc('result');
       // return view("StudentsScore", compact('ans'));
        // return $ans;

        $name = QuizResult::with('user')->get();
        // return view('StudentsScore', ['name'=> $name]);
        
       
      

        return view('StudentsScore')->with('ans', $ans)->with('ans', $name);
    }
}
