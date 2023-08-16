@extends('template.tmp')

@section('title', 'Users')
 

@section('content')

 <div class="main-content">

 <div class="page-content">
<div class="container-fluid">

 <!-- start page title -->
<div class="row">
<div class="col-12">
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
 <h4 class="mb-sm-0 font-size-18">Manage Users</h4>

 <div class="page-title-right">
<div class="page-title-right">

</div>
</div>
</div>
</div>
<div>
 <!-- end page title -->

 @if (session('error'))

 <div class="alert alert-{{ Session::get('class') }} p-3" id="success-alert">
                    
                   {{ Session::get('error') }}  
                </div>

@endif

 @if (count($errors) > 0)
                                 
                            <div >
                <div class="alert alert-danger pt-3 pl-0   border-3">
                   <p class="font-weight-bold"> There were some problems with your input.</p>
                    <ul>
                        
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>

                        @endforeach
                    </ul>
                </div>
                </div>
 
            @endif
<div class="row">
 <div class="col-12">
    <form action="{{URL('/SaveUser')}}" method="post">
        {{csrf_field()}}
<div class="card">
<div class="card-body">

<h4 class="card-title">Add New User</h4>
<p class="card-title-desc"></p>

 <div class="mb-3 row">
<label for="example-text-input" class="col-md-2 col-form-label">Branch Name</label>
<div class="col-md-10">
<select name="BranchID" class="form-select">
    @foreach($branch as $value)
    <option value="{{$value->BranchID}}">{{$value->BranchName}}</option>
    @endforeach
</select>
</div>
 </div>



<div class="mb-3 row">
<label for="example-email-input" class="col-md-2 col-form-label">Full Name</label>
<div class="col-md-10">
<input class="form-control" type="text"  value="{{old('FullName')}}"  name="FullName" id="example-email-input">
</div>
</div>
<div class="mb-3 row">
<label for="example-url-input" class="col-md-2 col-form-label">Username</label>
<div class="col-md-10">
<input class="form-control" type="text"  value="{{old('Email')}}" name="Email" required>
</div>

</div>
<div class="mb-3 row">
<label for="example-url-input" class="col-md-2 col-form-label">Password</label>
<div class="col-md-10">
<input class="form-control" type="text"  name="Password" value="{{old('Password')}}" required>
</div>

</div>
<div class="mb-3 row">
<label for="example-tel-input" class="col-md-2 col-form-label">User Type</label>
<div class="col-md-10">
<select name="UserType" class="form-select">

     
      <option value="HR">HR</option>
    <option value="OM">OM</option>
    <option value="GM">GM</option>
    


</select> </div>
 </div>
 
 <div class="mb-3 row">
<label for="example-tel-input" class="col-md-2 col-form-label">Active</label>
<div class="col-md-10">
<select name="Active" class="form-select">

     
    <option value="Y">Yes</option>
    <option value="N">No</option>
    


</select> </div>
 </div>

 
                                      
    <input type="submit" class="btn btn-primary w-md">                                   
                                   
    
                                      
                                        

                                       

                                    </div>
                                </div>

                            </form>
                            </div> <!-- end col -->
                        </div>
                      

  <div class="row">
      <div class="col-lg-12">
          
          <div class="card">
              
          <div class="card-body">
            <h4 class="card-title pb-3">Manage Users</h4>
             <!-- <p class="card-title-desc"> Add <code>.table-sm</code> to make tables more compact by cutting cell padding in half.</p>  -->   
                                        
       <div class="table-responsive">
        <table class="table table-sm m-0" id="datatable">
            <thead>
               <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Password</th>
                <th>User Type</th>
                <th>Created on</th>
                <th>User's Branch</th>
                
                <th>Active</th>
                <th>Action</th>
              </tr>
             </thead>
            <tbody>
 


                   <?php $no=1; ?> 
                @foreach($v_users as $value)
           <tr>
     <td  >{{$no++}}</td>
                <td scope="row">{{$value->FullName}}</td>
                <td>{{$value->Email}}</td>
                <td>*********</td>
                <td>{{$value->UserType}}</td>
                <td>{{$value->eDate}}</td>
                <td>{{$value->BranchName}}</td>
                
                <td>{{$value->Active}}</td>
                <td><div class="d-flex gap-1">
        <a href="{{URL('/EditUser/'.$value->UserID)}}" class="text-secondary"><i class="mdi mdi-pencil font-size-15"></i></a>
        <a href="{{URL('/DeleteUser/'.$value->UserID)}}"  class="text-secondary"><i class="mdi mdi-delete font-size-15"></i></a>
        <a href="{{URL('/checkUserRole/'.$value->UserID)}}"  class="text-secondary"><i class="fas fa-user-lock
 font-size-12"></i></a>
                                                             </div> </td>
                 
            </tr>

            @endforeach
             
              </tbody>
               </table>
        
                  </div>
        
                   </div>
          </div>
      </div>



  </div>                     
 
                         
                     
                        
                    </div> <!-- container-fluid -->
                </div>


    
</div>
  @endsection