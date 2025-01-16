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


                            <h4 class="card-title"><b>Finance Report Misc Fee/ Other Fee and Tuition Fee</b></h4>


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
                                            style="margin-top: 30px;" onclick="generatePDFFinance()">Generate Excel</button>
                                    </div>
                                </div>

                            </form>
                            <h4 class="card-title"><b>Daily Collection</b></h4>
                            <form id="masterlistForm">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="id">Date From:</label>
                                        <input type="date" id="date1" name="date_from" class="form-control"
                                            aria-describedby="helpId" required>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="id">Date To:</label>
                                        <input type="date" id="date_to2" name="date" class="form-control"
                                            aria-describedby="helpId" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="id">Campus</label>
                                        <select name="school_year" id="school_year_id" class="form-select" required>
                                            <option value="">Select One</option>
                                            @foreach ($campus as $cm)
                                                <option value="{{ $cm->id }}">{{ $cm->code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="text" name="role_name_id" id="role_name_id" value={{ $id }}
                                        hidden>
                                    <div class="col-md-3 mb-3">
                                        <button type="button" class="btn btn-success waves-effect waves-light"
                                            style="margin-top: 30px;" onclick="generatePDFDailyCollection()">Daily
                                            Collection</button>
                                    </div>
                                </div>

                            </form>

                            <h4 class="card-title"><b>Discount Collection/Category</b></h4>
                            <form id="masterlistForm">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="id">Department</label>
                                        <select name="department_id" id="department_id_id" class="form-select" required>
                                            <option value="">Select One</option>
                                            @foreach ($department as $dp)
                                                <option value="{{ $dp->id }}">{{ $dp->code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="text" name="discount" id="discount_collection" value="Discount" hidden>
                                    <div class="col-md-3 mb-3">
                                        <button type="button" class="btn btn-success waves-effect waves-light"
                                            style="margin-top: 30px;" onclick="generateDiscountCollection()">Discount
                                            Collection</button>
                                    </div>
                                </div>
                                <form id="masterlistForm">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="id">Discount Category</label>
                                            <select name="discCategory" id="discCategory_id" class="form-select"
                                                aria-describedby="helpId">
                                                <option value="">Select One</option>
                                                @foreach ($discount as $d)
                                                    <option value="{{ $d->id }}">{{ $d->code }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <label for="id">Department</label>
                                            <select name="department_id" id="department_id_id4" class="form-select"
                                                required>
                                                <option value="">Select One</option>
                                                @foreach ($department as $dp)
                                                    <option value="{{ $dp->id }}">{{ $dp->code }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <label for="id">Date From:</label>
                                            <input type="date" id="date5" name="date_from" class="form-control"
                                                aria-describedby="helpId" required>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <label for="id">Date To:</label>
                                            <input type="date" id="date_to5" name="date" class="form-control"
                                                aria-describedby="helpId" required>
                                        </div>
                                        <input type="text" name="discount" id="discount_collection4" value="Discount"
                                            hidden>
                                        <div class="col-md-3 mb-3">
                                            <button type="button" class="btn btn-success waves-effect waves-light"
                                                style="margin-top: 30px;"
                                                onclick="generateDiscountCollectionCategory()">Discount
                                                Category</button>
                                        </div>
                                    </div>

                                </form>
                                <h4 class="card-title"><b>Fees Collection Misc Fee/ Other Fee and Laboratory Fee</b></h4>
                                <form id="masterlistForm">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="id">Date From:</label>
                                            <input type="date" id="date3" name="date_from" class="form-control"
                                                aria-describedby="helpId" required>

                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label for="id">Date To:</label>
                                            <input type="date" id="date_to3" name="date" class="form-control"
                                                aria-describedby="helpId" required>

                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="id">Course</label>
                                            <select name="course_id" id="course_id" class="form-select" required>
                                                <option value="">Select One</option>
                                                @foreach ($course as $cs)
                                                    <option value="{{ $cs->id }}">{{ $cs->code }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <button type="button" class="btn btn-success waves-effect waves-light"
                                                style="margin-top: 30px;" onclick="generateFeesCollection()">Generate
                                                Excel</button>
                                        </div>
                                    </div>

                                </form>
                                <h4 class="card-title"><b>Total Fees for Department</b></h4>
                                <form id="masterlistForm">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="id">Date From:</label>
                                            <input type="date" id="date4" name="date_from" class="form-control"
                                                aria-describedby="helpId" required>

                                        </div>

                                        <div class="col-md-2 mb-2">
                                            <label for="id">Date To:</label>
                                            <input type="date" id="date_to4" name="date" class="form-control"
                                                aria-describedby="helpId" required>

                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <label for="id">Department</label>
                                            <select name="department_id" id="department_id2" class="form-select"
                                                required>
                                                <option value="">Select One</option>
                                                @foreach ($department as $dm)
                                                    <option value="{{ $dm->id }}">{{ $dm->code }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <label for="id">Cashier</label>
                                            <input type="text" id="text" name="date"
                                                value="{{ $username }}" class="form-control"
                                                aria-describedby="helpId" readonly>
                                        </div>
                                        <input type="text" name="role_name_id" id="role_id"
                                            value="{{ $id }}" hidden>
                                        <div class="col-md-3 mb-3">
                                            <button type="button" class="btn btn-success waves-effect waves-light"
                                                style="margin-top: 30px;"
                                                onclick="generateFeesCollectionTotalForDeparment()">Generate
                                                Excel</button>
                                        </div>
                                    </div>

                                </form>


                                <h4 class="card-title"><b>Payment Bank Reports</b></h4>
                                <form id="masterlistForm">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="id">Date From:</label>
                                            <input type="date" id="date6" name="date_from" class="form-control"
                                                aria-describedby="helpId" required>

                                        </div>

                                        <div class="col-md-2 mb-2">
                                            <label for="id">Date To:</label>
                                            <input type="date" id="date_to6" name="date" class="form-control"
                                                aria-describedby="helpId" required>

                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <label for="id">Banks</label>
                                            <select name="banks" id="banksId" class="form-select" required>
                                                <option value="">--Select One--</option>
                                                <option value="Cash">Cash</option>
                                                <option value="BDO Unibank Inc">BDO Unibank Inc</option>
                                                <option value="BPI">BPI</option>
                                                <option value="Metropolitan Bank and Trust Company">Metropolitan Bank and
                                                    Trust
                                                    Company</option>
                                                <option value="PNB">PNB</option>
                                                <option value="Security Bank Corporation">Security Bank Corporation
                                                </option>
                                                <option value="China Bank">China Bank</option>
                                                <option value="UnionBank of the Philippines">UnionBank of the Philippines
                                                </option>
                                                <option value="EastWest Bank">EastWest Bank</option>
                                                <option value="Rizal Commercial Banking Corporation">RCBC</option>
                                                <option value="Philippine Savings Bank ">PSBank
                                                </option>
                                                <option value="Standard Chartered Bank">Standard Chartered Bank
                                                </option>
                                                <option value="HSBC">HSBC
                                                </option>
                                                <option value="Landbank">Landbank
                                                </option>
                                                <option value="Citibank NA">Citibank NA</option>
                                                <option value="Deutsche Bank AG">Deutsche Bank AG</option>
                                                <option value="JPMorgan Chase Bank NA">JPMorgan Chase Bank</option>
                                                <option value="Bank of China Philippine Branch">Bank of China (Philippine
                                                    Branch)
                                                </option>
                                                <option value="Development Bank of the Philippines DBP">Development Bank of
                                                    the
                                                    Philippines
                                                    (DBP)
                                                </option>
                                                <option value="Pag IBIG Fund">Pag-IBIG Fund
                                                </option>
                                                <option value="China Bank Savings">China Bank Savings
                                                </option>
                                                <option value="Robinsons Bank Corporation">Robinsons Bank Corporation
                                                </option>
                                            </select>
                                        </div>
                                        {{-- <div class="col-md-2 mb-2">
                                            <label for="id">Cashier</label>
                                            <input type="text" id="text" name="date"
                                                value="{{ $username }}" class="form-control"
                                                aria-describedby="helpId" readonly>
                                        </div> --}}
                                        <input type="text" name="role_name_id" id="role_id"
                                            value="{{ $id }}" hidden>
                                        <div class="col-md-3 mb-3">
                                            <button type="button" class="btn btn-success waves-effect waves-light"
                                                style="margin-top: 30px;" onclick="generateFeesBanks()">Generate
                                                Excel</button>
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

        function generatePDFDailyCollection() {
            // console.log('testing');
            var date = $('#date1').val();
            var dateTo = $('#date_to2').val();
            var role_name_id = $('#role_name_id').val();
            var campus = $('#school_year_id').val();

            // console.log($date)
            window.location.href = "{{ route('superadmin.generate.PDFDailyCollection') }}?date=" + date + "&dateTo=" +
                dateTo + "&role_name_id=" + role_name_id + "&campus=" + campus;
        }

        function generateDiscountCollection() {
            // console.log('testing');
            var department_id_id = $('#department_id_id').val();
            var discount_collection = $('#discount_collection').val();

            // console.log($date)
            window.location.href = "{{ route('superadmin.generate.discountCollection') }}?department_id_id=" +
                department_id_id + "&discount_collection=" +
                discount_collection;
        }

        function generateFeesCollection() {
            // console.log('testing');
            var date = $('#date3').val();
            var dateTo = $('#date_to3').val();
            var course_id = $('#course_id').val();
            window.location.href = "{{ route('superadmin.generate.PDFDailyCollectionFees') }}?date=" + date + "&dateTo=" +
                dateTo + "&course_id=" + course_id;
        }

        function generateFeesCollectionTotalForDeparment() {
            var date = $('#date4').val();
            var dateTo = $('#date_to4').val();
            var department_id = $('#department_id2').val();
            var role_id = $('#role_id').val();
            window.location.href = "{{ route('superadmin.generate.ReportCollectionperCampus') }}?date=" + date +
                "&dateTo=" +
                dateTo + "&department_id=" + department_id + "&role_id=" + role_id;
        }

        function generateDiscountCollectionCategory() {
            var category = $('#discCategory_id').val();
            var date = $('#date5').val();
            var dateTo = $('#date_to5').val();
            var department_id_id4 = $('#department_id_id4').val();
            var type = $('#discount_collection4').val();
            window.location.href = "{{ route('superadmin.generate.ReportCollectionperCategory') }}?date=" + date +
                "&dateTo=" +
                dateTo + "&department_id=" + department_id_id4 + "&discCategory_id=" + category + '&discount_collection4=' +
                type;
        }

        function generateFeesBanks() {
            var date = $('#date6').val();
            var dateTo = $('#date_to6').val();
            var bank = $('#banksId').val();
            window.location.href = "{{ route('superadmin.generate.ReportCollectionperBank') }}?date=" + date +
                "&dateTo=" +
                dateTo + "&bank=" + bank;
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#course_id').select2({
                // dropdownParent: $('#adddetails'),
                dropdownAutoWidth: true
            });
        });
        $(document).ready(function() {
            $('#department_id2').select2({
                // dropdownParent: $('#adddetails'),
                dropdownAutoWidth: true
            });
        });
        $(document).ready(function() {
            $('#discCategory').select2({
                // dropdownParent: $('#adddetails'),
                dropdownAutoWidth: true
            });
        })
        $(document).ready(function() {
            $('#discCategory_id').select2({
                // dropdownParent: $('#adddetails'),
                dropdownAutoWidth: true
            });
        })
    </script>
@endpush
