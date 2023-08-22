<!doctype html>
<html lang="en">
 <head>
        <meta charset="utf-8" />
        <title>Promo Deals</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <link rel="shortcut icon" href="{{URL('/')}}/assets/images/favicon.jpeg">
        <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@200;300&display=swap" rel="stylesheet">
<style>
  #radioButtons{
  margin: 5px 0 10px 0;
}

input[type=text], select, textarea {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}


input[type=submit] {
  width: 100%;
  background-color: #016a70;
  color: white;
  padding: 14px 20px;
  margin-top: 12px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #018c94;
}

div {
  margin: auto;
  width: 30%;
  border-radius: 5px;
  background-color: #ededed;
  padding: 20px;
  font-family: 'Work Sans', sans-serif;
}
</style>

    </head>

    <body class="auth-body-bg">
        <div>
  <form action="{{URL('/UserAdd')}}" method="post">
    {{csrf_field()}}
    <label for="fname">Agent</label>
    <select name="AgentID" class="form-select" required>
      <option value="">--Select Agent--</option>
      @foreach($agents as $agent)
        <option value="{{$agent->UserID}}" {{($agent->FullName== $agent_requested) ? 'selected=selected':'' }}>{{$agent->FullName}}</option>
      @endforeach
    </select>


    <label for="fname">Name</label>
    <input type="text" id="FullName" name="FullName" placeholder="Your Full Name...">

    <label for="lname">Phone Number</label>
    <input type="text" id="Phone" name="Phone" placeholder="Your Phone ...">

    <label for="lname">Rental Rate Number</label>
    <input type="text" id="RentalRate" name="RentalRate" placeholder="Your Rental Rate ...">
    
    <label for="lname">Address</label>
    <textarea name="Address"></textarea>
    
    <input type="submit" value="Submit">
  </form>
    </div>
    </body>

 </html>
