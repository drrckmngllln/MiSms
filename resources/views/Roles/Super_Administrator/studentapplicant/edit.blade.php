<div class="col-sm-6 col-md-4 col-xl-3">
    <div class="my-4 text-center">
        <!-- Content here -->
    </div>

    <!-- Modal content for the above example -->
    <div class="modal fade bs-example-modal-xl" tabindex="-1" id="editModal" role="dialog"
        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Edit Student Applicant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="edit_form" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="edit_id">
                        <div class="d-flex justify-content-center"></div>
                        <div class="form-group">
                            <label for="semester">Semester</label>
                            <select id="edit_semester" class="form-control" name="semester">
                                <option value="">Select Semester</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="id_number" id="edit_id_number"
                                value="" readonly>
                        </div>
                        <!-- Other form groups... -->
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="last_name" id="edit_last_name"
                                value="">
                        </div>
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="first_name" id="edit_first_name"
                                value="">
                        </div>

                        <div class="form-group">
                            <label>Middle Name</label>
                            <input type="text" name="middle_name" id="edit_middle_name" class="form-control"
                                value="">
                        </div>

                        <div class="form-group">
                            <label for="suffix" class="form-label">Suffix</label>
                            <select name="suffix" id="edit_suffix" class="form-select" aria-describedby="helpId">
                                <option value="">Select</option>
                                <option value="Jr.">Jr.</option>
                                <option value="II">II</option>
                                <option value="III">III</option>
                                <option value="IV">IV</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="gender" class="form-label">Gender</label>
                            <select name="gender" id="edit_gender" class="form-select" aria-describedby="helpId">
                                <option value="">Select</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date" name="date_of_birth" id="edit_date_of_birth" class="form-control"
                                placeholder="" aria-describedby="helpId" value="">
                        </div>
                        <div class="form-group">
                            <label>Place of Birth</label>
                            <input type="text" class="form-control" name="place_of_birth" id="edit_place_of_birth"
                                value="">
                        </div>
                        <div class="form-group">
                            <label>Nationality</label>
                            <input type="text" class="form-control" name="nationality" id="edit_nationality"
                                value="">
                        </div>
                        <div class="form-group">
                            <label>Religion</label>
                            <input type="text" class="form-control" name="religion" id="edit_religion"
                                value="">
                        </div>

                        <label for="inputState">Select Status</label>
                        <select id="edit_status" class="form-control" name="status">
                            <option value="0">Pending</option>
                            <option value="1">For Enrollment</option>
                        </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success waves-effect waves-light mt-2"
                        style="float: left;">Save</button>
                </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@push('scripts')
    <script>
        function editUser(id, semester, id_number, last_name, first_name, middle_name, suffix, gender, date_of_birth,
            place_of_birth, nationality, religion, status) {
            $('#edit_id').val(id);
            $('#edit_semester').val(semester);
            $('#edit_id_number').val(id_number);
            $('#edit_last_name').val(last_name);
            $('#edit_first_name').val(first_name);
            $('#edit_middle_name').val(middle_name);
            $('#edit_suffix').val(suffix);
            $('#edit_gender').val(gender);
            $('#edit_date_of_birth').val(date_of_birth);
            $('#edit_place_of_birth').val(place_of_birth);
            $('#edit_nationality').val(nationality);
            $('#edit_religion').val(religion);
            $('#edit_status').val(status);
            $('#edit_form').attr('action', location.href + '/' + id);
        }
    </script>

    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            const semesterSelect = document.getElementById("semester");
            const idNumberSelect = document.getElementById("id_number");

            semesterSelect.addEventListener("change", function() {
                const selectedSemester = semesterSelect.value;
                if (selectedSemester) {

                    fetch('get-last-id')
                        .then(response => response.json())
                        .then(data => {
                            const lastGeneratedID = data.lastID;
                            if (lastGeneratedID) {
                                // Extract the number part from the last generated ID and increment it
                                const lastNumber = parseInt(lastGeneratedID.split("-").pop(), 10);
                                const nextNumber = lastNumber + 1;
                                // Construct the new ID
                                const schoolYear = '2023-2024';
                                const idNumber =
                                    `${schoolYear}-${selectedSemester}-${String(nextNumber).padStart(4, "0")}`;
                                idNumberSelect.innerHTML = '';
                                // Create and append a new option
                                const option = document.createElement("option");
                                option.value = idNumber;
                                option.text = idNumber;
                                idNumberSelect.appendChild(option);
                            } else {
                                // Handle the case where there's no previous ID
                                idNumberSelect.innerHTML = '<option value="">Select ID Number</option>';
                            }
                        });
                } else {
                    idNumberSelect.innerHTML = '<option value="">Select ID Number</option>';
                }
            });
        });
    </script> --}}
@endpush
