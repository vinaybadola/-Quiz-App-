<?php

namespace App\Http\Controllers;

use App\Models\QuizQuestion;
use App\Models\QuizResult;
use App\Models\QuizQuestionAttempt;
use App\Models\User;
use App\Models\StudentQuiz;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;


class StudentController extends Controller
{

    public function start_quiz()
    {

        $user_id = Session::get('loginId');
        $user = User::find($user_id);
        $user_course = $user->course_id;



        $store = new StudentQuiz();
        $store->marks = "";
        $store->user_id = $user_id;
        $store->total_attempt = 0;
        $store->save();
        $stu = StudentQuiz::get('id')->last();
        Session::put('quiz_id', $stu);

        $students = QuizQuestion::where('course_id', $user_course)->limit(1)->get();
        return view('question', ['display' => $students]);
    }




//!     Showing the Next Questions to User 
    public function add(Request $request)
    {

        $user_id = Session::get('loginId');
        $user = User::find($user_id);
        $user_course = $user->course_id;

        $demo = Session::get('quiz_id');
        $par = $demo->id;

        $option_id = $request->input('option_id');
        $question_id = $request->input('ques->id');

        if ($question_id == 0) {
            return view('submit');
        }


        $answer = QuizQuestion::where('course_id', $user_course)->get();

        foreach ($answer as $ans) {
            if ($ans->answer == $option_id) {
                $isCorrect = true;
            } elseif ($option_id == 0) {
                $isCorrect = false;
            } else {
                $isCorrect = false;
            }
        }


        $store_quiz = new QuizQuestionAttempt();
        $store_quiz->selected_ans = $option_id;
        $store_quiz->isCorrect = $isCorrect;
        $store_quiz->question_id = $question_id;
        $store_quiz->quiz_id = $par;
        $store_quiz->save();


        if ($question_id != 0) {
            $set = QuizQuestionAttempt::get('question_id');
            $answer = QuizQuestion::where('course_id', $user_course)->whereNotIn('id', function ($q) {
                $q->select('question_id')->from('quiz_question_attempts')->where('id', '!=', ' $set');
            })
             ->where('course_id','==',$user_course)
            ->limit(1)->get();
            return view('question', ['display' => $answer]);
        }
    }

    //!     Evaluating the User Question
    public function evaluate(Request $request)
    {




        $user_id = Session::get('loginId');
        $user = User::find($user_id);
        $user_course = $user->course_id;

        $demo = Session::get('quiz_id')->id;
        $help = QuizQuestionAttempt::all();

        foreach ($help as $item) {
            $hp = $item->selected_ans;
        }



        $correct = 0;
        $result = 0;
        $incorrect = 0;
        $no_attempt = 0;
        $grade = "";
        $answer = QuizQuestion::where('course_id', $user_course)->get();



        foreach ($answer as $ans) {
            if ($ans->answer == $hp) {
                $correct++;
            } elseif ($hp == 0) {
                $no_attempt++;
            } else {
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
        return view("StudentsScore", compact('ans'));
        // return $ans;


        return view('StudentsScore')->with('ans', $ans);
    }
}
