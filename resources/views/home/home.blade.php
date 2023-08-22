<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Limited Time Offer - Book Your Room Now!</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">


  <!-- App favicon -->
  <link rel="shortcut icon" href="{{asset('assets/images/favicon.jpeg')}}">
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@200;300&display=swap" rel="stylesheet">
  <style>
    #radioButtons {
      margin: 5px 0 10px 0;
    }

    input[type=text],
    select,
    textarea {
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

    .form-div {
      margin: auto;
      border-radius: 5px;
      background-color: #ededed;
      padding: 20px;
    }
  </style>

</head>

<body>
  <div class="container ">
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-4 form-div" >
      <form action="{{URL('/UserAdd')}}" method="post">
        {{csrf_field()}}
        <div class="mb-3">
          <label for="fname" class="form-label">Agent</label>
          <select name="AgentID" class=" form-control" required>
            <option value="">--Select Agent--</option>
            @foreach($agents as $agent)
            <option value="{{$agent->UserID}}" {{($agent->FullName== $agent_requested) ? 'selected=selected':'' }}>{{$agent->FullName}}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label for="fname" class="form-label">Name</label>
          <input type="text" id="FullName" name="FullName" placeholder="Your Full Name..." class=" form-control">
        </div>
        <div class="mb-3">
          <label for="lname" class="form-label">Phone Number</label>
          <input type="text" id="Phone" name="Phone" placeholder="Your Phone ..." class=" form-control">
        </div>
        <div class="mb-3">
          <label for="lname" class="form-label">Rental Rate Number</label>
          <input type="text" id="RentalRate" name="RentalRate" placeholder="Your Rental Rate ..." class=" form-control">
        </div>
        <div class="mb-3">
          <label for="lname" class="form-label">Address</label>
          <textarea name="Address" class=" form-control"></textarea>
        </div>

        <input type="submit" value="Submit" class="btn btn-success">
      </form></div>
      <div class="col-md-2"></div>
    </div>
  </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</html>