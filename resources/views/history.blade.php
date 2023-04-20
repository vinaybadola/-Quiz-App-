<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Previous Result</title>

</head>
<body>
    
    <h2> Your Examination History </h2> <hr>

 
    @foreach ($data as $item)
        
   <center>
   <b>UserID </b> : {{$item->user_id}} <br>
   <b>  Result </b> : {{$item->result}} <br>
   <b> Grade </b>  : {{$item->marks}} <br>
   <b>Correct Answers</b>  : {{$item->correct}} <br>
   <b>Incorrect Answers</b>  :  {{$item->Incorrect}} <br>
   <b> No Attempts</b>  : {{$item->No_Attempt}} <br>
   <b>Date/Time</b> : {{$item->created_at}} <br>
    <br><br><br><hr>
</center>
    @endforeach

</body>
</html>