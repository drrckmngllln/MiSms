@extends('Roles.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Create New Permissions</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Permission</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Page Title -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Please do not abbreviate all entries.</h4>
                                <form action="{{ route('superadmin.permission.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name" value="">
                                    </div>


                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success waves-effect waves-light mt-2"
                                            style="float: left;">Save</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>


            </div>

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
@endsection
