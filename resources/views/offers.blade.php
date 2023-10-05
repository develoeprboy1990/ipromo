@extends('template.tmp')
@section('title', 'Offers')
@section('content')
<style>
    .remove {
        cursor: pointer;
    }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
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
                    <div class="alert alert-danger pt-3 pl-0   border-3">
                        <p class="font-weight-bold"> There were some problems with your input.</p>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @php
                    if(!empty($offer)){
                    $route = route('offers.update',$offer->OfferID);
                    $method = '<input type="hidden" name="_method" value="patch">';
                    $formMethod = 'PUT';
                    }else{
                    $route = route('offers.store');
                    $method = '';
                    $formMethod = 'POST';
                    }
                    @endphp
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="{{$route}}" enctype="multipart/form-data" method="post">
                                {{csrf_field()}}
                                @if(!empty($offer))
                                @method('patch')
                                @endif
                                <div class="card shadow-sm">
                                    <div class="card-header">
                                        <h2>Offer</h2>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">

                                                <div class="mb-3 row">
                                                    <div class="col-sm-2">
                                                        <label class="col-form-label fw-bold" for="Title">Title</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="Title" class="form-control" name="Title" placeholder="Title" value="{{@$offer->Title}}">
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <div class="col-sm-2">
                                                        <label class="col-form-label fw-bold" for="Title">Level</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <select name="Level" class="form-select">
                                                            <option value="L1">L1</option>
                                                            <option value="L2">L2</option>
                                                            <option value="L3">L3</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                  <div class="mb-3 row">
                                                    <div class="col-sm-2">
                                                        <label class="col-form-label fw-bold" for="Days">Days</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="number" id="Days" class="form-control" name="Days" placeholder="Days" value="{{@$offer->Days}}">
                                                    </div>
                                                </div>


                                                <div class="mb-3 row">
                                                    <div class="col-sm-2">
                                                        <label class="col-form-label " for="Description">Description</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea name="Description" id="" class="form-control" cols="43" rows="3">{{@$offer->Description}}</textarea>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3 row">
                                                    <div class="col-sm-2">
                                                        <label class="col-form-label fw-bold" for="Image">Image</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="file" name="Image" class="form-control" accept="image/*">
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <div class="col-sm-2">
                                                        <label class="col-form-label fw-bold" for="Title">Group Tag</label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <select name="GroupTag" class="form-select select2" id="GroupTag"  multiple="multiple">
                                                             @foreach($tags as $tag)
                                                             <option value="{{$tag->TagName}}">{{$tag->TagName}}</option>
                                                             @endforeach
                                                        </select> 

                                                        <div class="dropdown_items"></div>
                                                        <div class="new_items"></div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                         <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaxModal">Add Tax</button>
                                                    </div>
                                                    
                                                </div>


                                                <div class="mb-3 row">
                                                    <div class="col-sm-2">
                                                        <label class="col-form-label fw-bold" for="Offer Type">Offer Type</label>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <select name="OfferType" class="form-select" id="offer-type">
                                                            <option value="Offer">Offer</option>
                                                            <option value="Discount">Discount</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-2 discount" >
                                                        <label class="col-form-label fw-bold" for="Discount">Discount</label>
                                                    </div>
                                                    <div class="col-sm-4 discount" >
                                                        <input type="number" id="discount" class="form-control" name="discount" placeholder="Discount" value="{{@$offer->discount}}">
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                        <div class="card-footer">
                                            <div><button type="submit" class="btn btn-success w-lg float-right">Save</button>
                                                <a href="{{route('offers.index')}}" class="btn btn-secondary w-lg float-right">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                            </form>
                            <div class="card">
                                <div class="card-body">

                                    @if(session('message'))
                                    <div class="alert alert-{{ session('status') }} alert-dismissible fade show" role="alert">
                                        <strong>{{ session('message') }}</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @endif
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
                                                    <th>Discount</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1; ?>
                                                @foreach($offers as $offer)
                                                <tr>
                                                    <td>{{$no++}}</td>
                                                    <td> <img src="{{URL('/')}}/uploads/{{ $offer->Image }}" width="100px" height="100px"></td>
                                                    <td scope="row">{{$offer->Title}}</td>
                                                    <td>{{$offer->Description}}</td>

                                                    <td>{{$offer->Days}}</td>
                                                    <td>{{$offer->discount}}</td>
                                                    <td><a href="{{route('offers.edit',$offer->OfferID)}}" title="Edit"><i class="font-size-18 mdi mdi-pencil align-middle me-1 text-secondary"></i></a>
                                                        <i class="font-size-18 mdi mdi-trash-can-outline align-middle me-1 text-secondary remove" data-record-id="{{$offer->OfferID}}"></i>
                                                        <form method="POST" action="{{ route('offers.destroy',$offer->OfferID) }}" id="delete_{{$offer->OfferID}}">
                                                            @csrf
                                                            @method('delete')
                                                        </form>
                                                    </td>
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


        <!-- Add Modal -->
        <div class="modal fade" id="addTaxModal" tabindex="-1" role="dialog" aria-labelledby="addTaxModal" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="addTaxModalTitle">Add Tag</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                    <div class="row col-md-12">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Type Tag Name" required id="tag_name">
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" id="save_tag">Save</button>
                    </div>
              </div>
            </div>
          </div>
        </div>

        <script>
            $(document).ready(function() {

                $('.select2').select2();


                $('.discount').hide();

                $('#offer-type').on('change', function() {

                if($(this).val() == 'Offer') {
                    $('.discount').hide();
                }else{
                    $('.discount').show();
                }
            });


        $(document.body).on('click','#save_tag',function(){
            var tag_name = $('#tag_name').val();
    
            $.ajax({
                url: "{{url('save-tag')}}",
                dataType: 'JSON',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    tag_name: tag_name,
                },
                success: function(data) {
                    if(data){

                        var ul = $('<ul>');
                        $('.new_items').empty();

                        ul.append('<li>' + data['tag_name'] + '</li><input type="hidden" value="' + data['tag_name'] + '" name="new_items[]">');

                        $('.new_items').html(ul);
                        $("#addTaxModal").modal('hide');
                    }
                }
            });
        });

        $('#GroupTag').on('change', function() {
            var ul = $('<ul>');
            $('.dropdown_items').empty();

            $(this).find('option').each(function(index, element) {
                if($(element).is(':selected')) {
                    ul.append('<li>' + $(element).text() + '</li><input type="hidden" value="' + $(element).text() + '" name="dropdown_items[]">');
                }
            });
            $('.dropdown_items').html(ul);
        });




                $('.remove').click(function() {
                    var recordId = $(this).data("record-id");
                    var confirmDelete = confirm("Are you sure you want to delete this record?");

                    if (confirmDelete) {
                        // Perform the delete action here
                        // You can use AJAX or any other method to delete the record
                        // For example, remove the record from the list

                        $('#delete_' + recordId).submit();
                    }

                });
            });
        </script>
        @endsection