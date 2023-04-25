<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
 
  <center>
  <form action="{{url('/eval')}}" method="POST">
    @csrf
    <h1>TEST OVER </h1>
    <input type="submit" value="submit" name="submit">
  </form>
</center>
  
</body>
</html>