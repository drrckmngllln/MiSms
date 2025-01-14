@extends('Roles.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Manage Roles </h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Roles</a></li>
                                <li class="breadcrumb-item active">All Roles </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End page title -->

            <div class="row">
                <div class="col-12">

                    <a href="{{ route('superadmin.role.create') }}" class="btn btn-primary waves-effect waves-light">
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
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td>{{ $role->id }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                @include('Roles.edit')
                                                @include('Roles.addPermissionToRoles')

                                                <div class="d-flex">
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#addpermissionToRoles{{ $role->id }}">
                                                        <button type="button"
                                                            class="btn btn-secondary waves-effect waves-light mx-1">
                                                            Add Permission to Role
                                                        </button>
                                                    </a>
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $role->id }}">
                                                        <button type="button"
                                                            class="btn btn-primary waves-effect waves-light">
                                                            {{-- <i class="ri-edit-2-fill"></i> --}}
                                                            EDIT
                                                        </button>
                                                    </a>
                                                    <form action="{{ route('superadmin.role.destroy', $role->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger delete-item"
                                                            style="margin-left: 2px;">
                                                            DELETE
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
