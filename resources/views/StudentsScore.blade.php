
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-lg-offset-2 col-lg-8">
				<h1 align="center">LeaderBoard </h1> <hr> <br>
				<br>
			
				
				<table class="table">
					<thead>
						<tr>

                            <th>Name</th>
							<th>User ID </th>
							<th>Your Grade is </th>
							<th>Correct Answers</th>
							<th>Incorrect Answers</th>
							<th>No attempt</th>
							<th>Grade</th>
							<th>Date/Time </th>
                            
						</tr>
					</thead>
					<tbody>
						    
							@foreach($ans as $sc)
								<tr>
							<td>{{$sc->user->name}}</td>
							<td>{{$sc->user_id}}</td>
							<td>{{$sc->result}}</td> 
							<td>{{$sc->correct}}</td>
							<td>{{$sc->Incorrect}}</td> 
							<td>{{$sc->No_Attempt}}	</td> 
							<td>{{$sc->marks}}</td>
							<td>{{$sc->created_at}}</td>
						</tr>
						
						@endforeach				
					</tbody>
                </table>
            </div>
        </div>
    </div>

	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
</body>
</html>