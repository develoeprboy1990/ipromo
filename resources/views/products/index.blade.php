@extends('template.tmp')
@section('title', 'products')
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
                        <h4 class="mb-sm-0 font-size-18">Manage {{$pagetitle}}</h4>
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
                    if(!empty($product)){
                    $route = route('products.update',$product->id);
                    $method = '<input type="hidden" name="_method" value="patch">';
                    $formMethod = 'PUT';
                    }else{
                    $route = route('products.store');
                    $method = '';
                    $formMethod = 'POST';
                    }
                    @endphp
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="{{$route}}" enctype="multipart/form-data" method="post">
                                {{csrf_field()}}
                                @if(!empty($product))
                                @method('patch')
                                @endif
                                <div class="card shadow-sm">
                                    <div class="card-header">
                                        <h2>{{$pagetitle}}</h2>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">

                                                <div class="mb-3 row">
                                                    <div class="col-sm-2">
                                                        <label class="col-form-label fw-bold" for="Title">Name</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" id="name" class="form-control" name="name" placeholder="Name" value="{{@$product->name}}">
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-sm-2">
                                                        <label class="col-form-label fw-bold" for="Price">Price</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="number" id="price" class="form-control" name="price" placeholder="Price" value="{{@$product->price}}">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3 row">
                                                    <div class="col-sm-2">
                                                        <label class="col-form-label fw-bold" for="Image">Image</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="file" name="image" class="form-control" accept="image/*">
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <div class="col-sm-2">
                                                        <label class="col-form-label " for="Description">Description</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea name="description" id="" class="form-control" cols="43" rows="3">{{@$product->description}}</textarea>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="card-footer">
                                            <div><button type="submit" class="btn btn-success w-lg float-right">Save</button>
                                                <a href="{{route('products.index')}}" class="btn btn-secondary w-lg float-right">Cancel</a>
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
                                    <h4 class="card-title pb-3">Manage products</h4>
                                    <!-- <p class="card-title-desc"> Add <code>.table-sm</code> to make tables more compact by cutting cell padding in half.</p>  -->
                                    <div class="table-responsive">
                                        <table class="table table-sm m-0" id="datatable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Image</th>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th>Price</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1; ?>
                                                @foreach($products as $product)
                                                <tr>
                                                    <td>{{$no++}}</td>
                                                    <td> <img src="{{URL('/')}}/uploads/products/thumbnail/{{ $product->image }}" width="100px" height="100px"></td>
                                                    <td scope="row">{{$product->name}}</td>
                                                    <td>{{$product->description}}</td>

                                                    <td>{{$product->price}}</td>
                                                    <td><a href="{{route('products.edit',$product->id)}}" title="Edit"><i class="font-size-18 mdi mdi-pencil align-middle me-1 text-secondary"></i></a>
                                                        <i class="font-size-18 mdi mdi-trash-can-outline align-middle me-1 text-secondary remove" data-record-id="{{$product->id}}"></i>
                                                        <form method="POST" action="{{ route('products.destroy',$product->id) }}" id="delete_{{$product->id}}">
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