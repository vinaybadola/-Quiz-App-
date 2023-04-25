<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Previous Result</title>

</head>
<body>
    
    <marquee behavior="" direction=""><h2> Your Examination History </h2></marquee>


    <table border="2px solid blue">
 
        <thead>
            <tr>
			
				<th>Question Name </th>
				<th> Correct Answer</th>
				<th>Your Selected Answer/Option</th>
				<th>Correct/Incorrect</th>
				<th> </th>
               
                
            </tr>
        </thead>
        <tbody>
            @foreach ($result as $item)
                <tr>
					<td>{{$item->question_name}}</td>
					<td>{{$item->answer}}</td>
					<td>{{$item->selected_ans}}</td>
					<td>{{$item->isCorrect}}</td>
					
                    {{-- <td>{{$item->Selected_ans}} </td> --}}
					{{-- <td>{{$item->isCorrect}}</td> --}}
					
                
                    
                </tr>
            
            @endforeach
			
        </tbody>
        
    </table>


    <br>
    <div>
        <a href="/dashboard">GO TO DASHBOARD</a>
    </div>
    
</body>
</html>








