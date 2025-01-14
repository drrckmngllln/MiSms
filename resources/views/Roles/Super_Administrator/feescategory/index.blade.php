@extends('Roles.layouts.master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"></h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Fees Category</a></li>
                                <li class="breadcrumb-item active">Fees</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">

                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                        data-bs-target=".bs-example-modal-xl">
                        <i class="ri-add-line"></i> Create New
                    </button>
                    <div class="card" style="margin-top: 20px;">
                        <div class="card-body">
                            <h4 class="card-title">Fees Category</h4>
                            {{ $dataTable->table() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page-content -->
@endsection
@include('Roles.Super_Administrator.feescategory.create')
{{-- @include('Roles.Super_Administrator.studentapplicant.edit')
@include('Roles.Super_Administrator.studentapplicant.view')
@include('Roles.Super_Administrator.studentapplicant.forenrollment') --}}


@push('scripts')
    {{-- Include DataTable scripts --}}
    {{ $dataTable->scripts(attributes: ['type' => 'module', 'class' => 'dt-responsive']) }}
@endpush
