@extends('template.tmp')

@section('title', 'Offers')
 

@section('content')

 <div class="main-content">

 <div class="page-content">
<div class="container-fluid">

 <!-- start page title -->
<div class="row">
<div class="col-12">
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
 <h4 class="mb-sm-0 font-size-18">Manage Offers</h4>

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
      <div class="col-lg-12">
          
          <div class="card">
              
          <div class="card-body">
            <h4 class="card-title pb-3">Manage Offers</h4>
             <!-- <p class="card-title-desc"> Add <code>.table-sm</code> to make tables more compact by cutting cell padding in half.</p>  -->   
                                        
       <div class="table-responsive">
        <table class="table table-sm m-0" id="datatable">
            <thead>
               <tr>
                <th>#</th>
                <th>Image</th>
                <th>Title</th>
                <th>Description</th>
                
                <th>Days</th>
              </tr>
             </thead>
            <tbody>
                   <?php $no=1; ?> 
                @foreach($offers as $offer)
           <tr>
     <td  >{{$no++}}</td>
     <td> <img src="{{URL('/')}}/uploads/{{ $offer->Image }}" width="100px" height="100px"></td>
                <td scope="row">{{$offer->Title}}</td>
                <td>{{$offer->Description}}</td>
                
                <td>{{$offer->Days}}</td>
               
                 
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