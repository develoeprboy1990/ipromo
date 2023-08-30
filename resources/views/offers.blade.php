@extends('template.tmp')
@section('title', 'Offers')
@section('content')
<style>
    .remove {
        cursor: pointer;
    }
</style>
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
                                                        <label class="col-form-label fw-bold" for="Days">Days</label>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="number" id="Days" class="form-control" name="Days" placeholder="Days" value="{{@$offer->Days}}">
                                                    </div>

                                                    <div class="col-sm-2">
                                                        <label class="col-form-label fw-bold" for="Days">Discount</label>
                                                    </div>
                                                    <div class="col-sm-5">
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
        <script>
            $(document).ready(function() {
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