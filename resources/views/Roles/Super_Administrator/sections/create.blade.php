<div class="col-sm-6 col-md-4 col-xl-3">
    <div class="my-4 text-center">

    </div>

    <!--  Modal content for the above example -->
    <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true" id="createSection">
        <div class="modal-dialog modal-md">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Create Sections</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('superadmin.sections.store') }}" method="POST">
                    @csrf
                    <div class="modal-body row">
                        <div class="form-group">
                            <label>Section Code</label>
                            <input type="text" class="form-control" name="section_code">
                        </div>
                        <div class="form-group">
                            <label for="course" class="form-label">School Year</label>
                            <select name="school_year" id="school_year_create_id" class="form-select" required>
                                <option value="" disabled selected>--Select One--</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="department" class="form-label">Course</label>
                            <select name="course_id" id="courseSelect" class="form-select id-number"
                                aria-describedby="helpId" required>
                                <option value="">Select Course</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}"
                                        data-department-id="{{ $course->department_id }}">
                                        {{ $course->description }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Department Description</label>
                            <select class="form-control" name="department_id" id="departmentSelect" readonly>
                                <option value="">Select Department</option>

                                @foreach ($department as $dp)
                                    <option value="{{ $dp->id }}">{{ $dp->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Semester</label>
                            <input type="text" class="form-control" name="semester" id="semester"
                                value="{{ isset($activeSchoolYear) ? $activeSchoolYear->semester : '' }}" readonly>
                        </div>

                        <div class="form-group">
                            <label>Year Level</label>
                            <input type="text" class="form-control" name="year_level">
                        </div>

                        <div class="form-group">
                            <label>Number of Students</label>
                            <input type="number" class="form-control" name="number_of_students" value="0">
                        </div>

                        <div class="form-group">
                            <label>Maximum Number of Students</label>
                            <input type="number" class="form-control" name="max_number_of_students">
                        </div>



                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="1">Available</option>
                                <option value="0">Full</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Remarks</label>
                            <select class="form-control" name="remarks">
                                <option value="regular">Regular</option>
                                <option value="irregular">Irregular</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>From: </label>
                            <input type="date" class="form-control" name="from"
                                value="{{ isset($activeSchoolYear) ? $activeSchoolYear->from : '' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>To: </label>
                            <input type="date" class="form-control" name="to"
                                value="{{ isset($activeSchoolYear) ? $activeSchoolYear->to : '' }}" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Level</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#courseSelect').select2({
                dropdownParent: $('#createSection'),
                dropdownAutoWidth: true
            }).on('select2:select', function(e) {
                var data = e.params.data;
                var departmentId = $(data.element).data('department-id');
                $('#departmentSelect').val(departmentId).trigger('change');
            });

            $('#departmentSelect').select2({
                dropdownParent: $('#createSection'),
                dropdownAutoWidth: true
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#createSection').on('show.bs.modal', function() {
                $.ajax({
                    url: '{{ route('superadmin.get.activeYear') }}',
                    type: 'GET',
                    success: function(data) {
                        let select = $('#school_year_create_id');
                        select.empty();
                        if (data.activeYears.length === 1) {
                            select.append('<option value="' + data.activeYears[0].id +
                                '" selected>' + data.activeYears[0].code + '</option>');
                        } else {
                            select.append(
                                '<option value="" disabled selected>--Select One--</option>'
                            );

                            $.each(data.activeYears, function(index, schoolYear) {
                                select.append('<option value="' + schoolYear.id + '">' +
                                    schoolYear.code + '</option>');
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching school years:', error);
                    }
                });
            });
        });
    </script>
@endpush
