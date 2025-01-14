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
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Students</a></li>
                                <li class="breadcrumb-item active">Report</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12">

                    {{-- <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                        data-bs-target=".bs-example-modal-xl">
                        <i class="ri-add-line"></i> Create New
                    </button> --}}
                    <div class="card" style="margin-top: 20px;">
                        <div class="card-body">
                            <h4 class="card-title">Finance Report</h4>

                            <form id="masterlistForm">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="id">Date From:</label>
                                        <input type="date" id="date" name="date_from" class="form-control"
                                            aria-describedby="helpId" required>

                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="id">Date To:</label>
                                        <input type="date" id="date_to" name="date" class="form-control"
                                            aria-describedby="helpId" required>

                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <button type="button" class="btn btn-success waves-effect waves-light"
                                            style="margin-top: 30px;" onclick="generatePDFFinance()">Print on
                                            PDF</button>
                                    </div>
                                </div>

                            </form>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End Page-content -->
@endsection

@push('scripts')
    <script>
        function generatePDFFinance() {
            // console.log('testing');
            var date = $('#date').val();
            var dateTo = $('#date_to').val();
            // console.log($date)
            window.location.href = "{{ route('superadmin.generate.PDFFinancedailyreport') }}?date=" + date + "&dateTo=" +
                dateTo;
        }
    </script>
@endpush
