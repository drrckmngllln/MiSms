<div class="col-sm-6 col-md-4 col-xl-3">
    <div class="my-4 text-center">

    </div>

    <!--  Modal content for the above example -->
    <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true" id="subjectModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Add Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        {{-- {{ $dataTable->table() }} --}}
                        <form action="" method="post" id="subject-form">
                            @csrf
                            @method('POST')
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="id_number" class="form-label">Section Code</label>
                                    <input type="text" name="section_code" id="section_code" class="form-control"
                                        placeholder="" aria-describedby="helpId" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="course" class="form-label">Course</label>
                                    <input type="text" name="course" id="view_course" class="form-control"
                                        placeholder="" aria-describedby="helpId" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="id_number" class="form-label">Remarks</label>
                                    <input type="text" name="remarks" id="remarks" class="form-control"
                                        placeholder="" aria-describedby="helpId" readonly>
                                </div>
                            </div>
                            <input type="hidden" name="id" id="item_id">
                            <input type="hidden" name="section_id" id="section_id">
                            <input type="hidden" name="semester_id" id="semester_id">
                            <input type="hidden" name="code" id="code">
                            <input type="hidden" name="descriptive_tittle" id="descriptive_tittle">
                            <input type="hidden" name="total_units" id="total_units">
                            <input type="hidden" name="lecture_units" id="lecture_units">
                            <input type="hidden" name="lab_units" id="lab_units">
                            <input type="hidden" name="pre_requisite" id="pre_requisite">
                            <input type="hidden" name="total_hrs_per_week" id="total_hrs_per_week">
                            <input type="hidden" name="is_active" id="is_active">


                            <table class="table table-bordered" id="sectionsubject-datatable">
                                <thead>
                                    <th>Semester</th>
                                    <th>Code</th>
                                    <th>Descriptive Title</th>
                                    <th>Total Units</th>
                                    <th>Lecture Units</th>
                                    <th>Lab Units</th>
                                    <th>Pre-Requisite</th>
                                    <th>Total Hours Per Week</th>
                                    <th>Actions</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <button type="submit"></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

@push('scripts')
    <script></script>
    <script>
        $("#sectionsubject-datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('superadmin.curriculum_subjects.create') }}",
            columns: [{
                    data: 'semester_id',
                    name: 'semester_id'
                },
                {
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'descriptive_tittle',
                    name: 'descriptive_tittle'
                },
                {
                    data: 'total_units',
                    name: 'total_units'
                },
                {
                    data: 'lecture_units',
                    name: 'lecture_units'
                },
                {
                    data: 'lab_units',
                    name: 'lab_units'
                },
                {
                    data: 'pre_requisite',
                    name: 'pre_requisite'
                },
                {
                    data: 'total_hrs_per_week',
                    name: 'total_hrs_per_week'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
        });

        function addSubject(id, semester_id, code, descriptive_tittle, total_units, lecture_units,
            lab_units, pre_requisite,
            total_hrs_per_week, is_active) {
            var urlFetch = location.href;
            var fetchID = urlFetch.split('/');
            var urlID = fetchID[fetchID.length - 1];
            // var urlID = fetchID[fetchID.length - 1];
            // $("#item_id").val(id);
            $("#section_id").val(urlID);
            $("#semester_id").val(semester_id);
            $("#code").val(code);
            $("#descriptive_tittle").val(descriptive_tittle);
            $("#total_units").val(total_units);
            $("#lecture_units").val(lecture_units);
            $("#lab_units").val(lab_units);
            $("#pre_requisite").val(pre_requisite);
            $("#total_hrs_per_week").val(total_hrs_per_week);
            $("#is_active").val(is_active);
            $("#subject-form").attr('action', "{{ route('superadmin.section_subject.store') }}");
        }
        $(document).ready(function() {
            $('#subject-form').submit(function(event) {
                event.preventDefault(); //para hindi mag refresh yung browser
                // console.log('testing!');
                const url = $(this).attr('action');
                let formData = $(this).serializeArray();
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    success: function(data) {

                        // Show an additional Swal alert for successful status change
                        if (data.status == 'success') {
                            toastr.success(data.message);
                            Swal.fire({
                                title: 'Success!',
                                text: data.message,
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                // window.location.reload();
                            });
                            //else if error siya sa validation mag papakita na duplicate entry error nasa controller yung query na ginamit
                        } else if (data.status == 'error') {
                            toastr.error(data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            })
        })
    </script>

    <script>
        //get section code on input fields

        function throwID(id) {
            console.log('testing');

        }
    </script>
@endpush
