<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DashBoard</title>
</head>
<body>
    <div>
        <h1>Welcome To Dashboard !</h1>
        <hr>
        <table border="2px solid">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Course_Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
               @if(isset($data))
                <tr>
                    <td>{{$data->name}}</td>
                    <td>{{$data->email}}</td>
                    <td>{{$course->course_name}}</td>
                    <td><a href="logout">Logout</a></td>
                </tr>
               
                @endif
            </tbody>
        </table>
    </div>

    <div>
        <br><hr>
        <a href="/quiz">Start Quiz</a>
    </div>
    <br><br><br><br>
    <a href="{{url('/prev')}}">Check previous Result</a>
    <br><br><br><br><br><br><br><br><br><br><br><br>
    <a href="{{url('/leaderBoard')}}">Check LeaderBoard</a>
</body>
</html>