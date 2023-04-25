<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div>
        <h1>Registration Form</h1>
        <hr>
        <form action="{{url('register-user')}}" method="POST">
            @csrf
            @if (Session::has('success'))
                {{Session::get('success')}}
            @endif
            @if (Session::has('fail'))
                {{Session::get('fail')}}
            @endif
            <div>
                <input type="text"  max="15" name="name" placeholder="Enter your name" value="{{old('name')}}"><br>
                <span>@error('name'){{$message}}@enderror</span>
            </div>
            <br>
            <div>
                <input type="email" name="email" placeholder="Enter your email" value="{{old('email')}}"><br>
                <span>@error('email'){{$message}}@enderror</span>
            </div>
            <br>
            <div>
                <input type="password" name="password" placeholder="Enter your password" value="{{old('password')}}"><br>
                <span>@error('password'){{$message}}@enderror</span>
            </div>
            <br>
            <div>
                <input type="mobile" max="10" name="contact" placeholder="Enter your contact" value="{{old('contact')}}"><br>
                <span>@error('contact'){{$message}}@enderror</span>
            </div>
            <br>
            <h2>Select your course</h2>
           <br>
            <div>
               <select name="course">
                @foreach($courses as $course)
                <option value={{$course->id}}>{{$course->course_name}}</option>
                @endforeach
               </select>
                <span>@error('course_id'){{$message}}@enderror</span>
            </div>
            <br>
            <div>
                <button type="submit">Register</button><br>
            </div>
            <br>
            <a href="login">Already Register !! Login Here</a>
        </form>
    </div>
</body>
</html>