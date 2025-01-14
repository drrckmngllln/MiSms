<!-- Modal content for the above example -->
<div class="modal fade bs-example-modal-xl" tabindex="-1" id="selectCurriculum" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-m">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Approve Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="curriculum_id_select" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="edit_iddd">
                    <div class="row">
                        <label for="occupation" class="form-label">Name</label>
                        <input type="text" name="fullname" id="fullname_id" class="form-control" placeholder=""
                            aria-describedby="helpId">


                        <label for="occupation" class="form-label">Course</label>
                        <input type="text" name="" id="student_course_id" class="form-control" placeholder=""
                            aria-describedby="helpId">


                        <label for="select_school_year" class="form-label">School Curriculum</label>
                        <select name="curriculum_id" id="curriculum_idss" class="form-select" required>
                            <option value="" selected disabled>--Select One--</option>
                            <option value=""></option>
                        </select>
                        {{-- 
                        <label for="select_school_year" class="form-label">School Curriculum</label>
                        <select name="curriculum_id" id="curriculum_id" class="form-select" required>
                            <option value="" selected disabled>--Select One--</option>
                            @foreach ($curriculum as $cr)
                                <option value="{{ $cr->id }}">{{ $cr->code }}</option>
                            @endforeach
                        </select> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success waves-effect waves-light mt-2"
                            style="float: left;" name="submitType" value="curriculum">Approve</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@push('scripts')
    <script>
        function approveStudent(id, first_name, middle_name, last_name, code, course_id) {

            var fullName = first_name + ' ' + middle_name + ' ' + last_name;
            $('#fullname_id').val(fullName);
            $('#student_course_id').val(code);
            $('#edit_iddd').val(id);


            var table = $('#highSchoolTable').DataTable();

            $('#curriculum_id_select').on('submit', function(e) {
                event.preventDefault();
                var form = $('#curriculum_id_select');
                var route = "{{ route('superadmin.studentappHS.changeStatusHighSchool', ['id' => ':id']) }}";
                route = route.replace(':id', id);
                form.attr('action', route);

                $.ajax({
                    url: route,
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        table.ajax.reload();
                        $('#selectCurriculum').modal('hide');
                    },
                    error: function(response) {
                        alert('An error occurred');
                    }
                });
            });

            $.ajax({
                type: 'GET',
                url: '{{ route('superadmin.get.CurrculumCoursesHS') }}',
                data: {
                    course_id: course_id,
                    first_name: first_name,
                    middle_name: middle_name,
                    last_name: last_name,
                },
                success: function(response) {
                    $('#curriculum_idss').empty();
                    response.forEach(element => {
                        $('#curriculum_idss').append(
                            `<option value="${element['id']}">${element['code']}</option>`
                        );
                    });
                },
                error: function(error) {}
            });
            // Show the modal
            $('#selectCurriculum').modal('show');


        }
    </script>
@endpush
