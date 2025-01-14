@extends('Roles.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Manage Permissions</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Permissions</a></li>
                                <li class="breadcrumb-item active">All Permissions</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End page title -->

            <div class="row">
                <div class="col-12">
                    <a href="{{ route('superadmin.permission.create') }}" class="btn btn-primary waves-effect waves-light">
                        <i class="ri-add-line"></i>Create New
                    </a>

                    <div class="card" style="margin-top: 20px;">
                        <div class="card-body">
                            <h4 class="card-title">Roles List</h4>

                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td>{{ $permission->id }}</td>
                                            <td>{{ $permission->name }}</td>
                                            <td>
                                                @include('Roles.Permissions.edit')
                                                <div class="d-flex">
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $permission->id }}">
                                                        <button type="button"
                                                            class="btn btn-primary waves-effect waves-light">
                                                            <i class="ri-edit-2-fill"></i>
                                                        </button>
                                                    </a>
                                                    <form
                                                        action="{{ route('superadmin.permission.destroy', $permission->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger delete-item"
                                                            style="margin-left: 2px;">
                                                            <i class="ri-delete-bin-6-fill"></i>
                                                        </button>
                                                    </form>
                                                </div>
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
    </div>
    <!-- End Page-content -->
@endsection
