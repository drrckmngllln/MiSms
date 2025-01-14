<!--  Modal content for the above example -->
<div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
    aria-hidden="true" id="createAccountModal">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Student Account </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('superadmin.highSchool.store') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="row justify-content-center">
                            <div class="col-md-3 mb-3 mx-auto text-center" style="right: 80px">
                                <label for="id_number" class="form-label">Type of Students</label>
                                <select name="type_of_students" id="type_of_students_id" class="form-select id-number"
                                    aria-describedby="helpId">
                                    <option value="">Select Type</option>
                                    <option value="Freshman">Freshman</option>
                                    <option value="Transferee">Transferee</option>
                                    <option value="Regular">Regular</option>
                                </select>
                            </div>


                            <div class="col-md-3 mb-1 mx-2" style="right: 350px">
                                <label for="course" class="form-label">Course</label>

                                <select name="course_id" id="course_id_select2" class="form-select id-number"
                                    aria-describedby="helpId">
                                    <option value="">Select Course</option>
                                    @foreach ($course as $cs)
                                        <option value="{{ $cs->id }}">{{ $cs->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3 mx-auto text-center">
                            <label for="campus_id" class="form-label">Campus</label>
                            <select name="campus_id" id="campus_idss" class="form-select id-number"
                                aria-describedby="helpId">
                                <option value="">Select Campus</option>
                                @foreach ($campus as $cm)
                                    <option value="{{ $cm->id }}">{{ $cm->code }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="course" class="form-label">Department</label>
                                <select name="discount_id" id="discount_id_select2" class="form-select id-number"
                                    aria-describedby="helpId">
                                    <option value="">Select Department</option>
                                    @foreach ($department as $dp)
                                        <option value="{{ $dp->id }}">{{ $dp->code }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="id_number" class="form-label">Date of Admission</label>
                                <input type="text" name="admission_date" id="admission_date_id" class="form-control"
                                    placeholder="" aria-describedby="helpId" readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="id_number" class="form-label">ID Number</label>
                                <input type="text" name="id_number" id="id_number_iddd" class="form-control"
                                    placeholder="" aria-describedby="helpId">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control"
                                    placeholder="" aria-describedby="helpId">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" name="first_name" id="first_name" class="form-control"
                                    placeholder="" aria-describedby="helpId">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="middle_name" class="form-label">Middle Name</label>
                                <input type="text" name="middle_name" id="middle_name" class="form-control"
                                    placeholder="" aria-describedby="helpId">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="civil_status" class="form-label">Gender</label>
                                <select name="gender" id="gender" class="form-select id-number"
                                    aria-describedby="helpId">
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="civil_status" class="form-label">Civil Status</label>
                                <select name="civil_status" id="edit_civil_status" class="form-select id-number"
                                    aria-describedby="helpId">
                                    <option value="">Select Status</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" name="date_of_birth" id="date_of_birth" class="form-control"
                                    placeholder="" aria-describedby="helpId">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="place_of_birth" class="form-label">Place of Birth</label>
                                <input type="text" name="place_of_birth" id="place_of_birth" class="form-control"
                                    placeholder="" aria-describedby="helpId">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="nationality" class="form-label">Nationality</label>
                                <input type="text" name="nationality" id="nationality" class="form-control"
                                    placeholder="" aria-describedby="helpId">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="religion" class="form-label">Religion</label>
                                <input type="text" name="religion" id="religion" class="form-control"
                                    placeholder="" aria-describedby="helpId">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="control_number" class="form-label">Contact Number</label>
                                <input type="text" name="control_number" id="control_number" class="form-control"
                                    placeholder="" aria-describedby="helpId">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="" aria-describedby="helpId">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="home_address" class="form-label">Home Address</label>
                                <input type="text" name="home_address" id="home_address" class="form-control"
                                    placeholder="" aria-describedby="helpId">
                            </div>
                        </div>
                        <div class="row">
                            <h5 class="form-label">School Attended</h5>
                            <div class="col-md-8 mb-3">
                                <label for="elementary" class="form-label">Elementary</label>
                                <input type="text" name="elementary" id="elementary" class="form-control"
                                    aria-describedby="helpId">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="year_graduated_elem" class="form-label">Year Graduated</label>
                                <input type="text" name="year_graduated_elem" id="year_graduated_elem"
                                    class="form-control" placeholder="" aria-describedby="helpId">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="junior_high_school" class="form-label">Junior High School</label>
                                <input type="text" name="junior_high_school" id="junior_high_school"
                                    class="form-control" placeholder="" aria-describedby="helpId">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="year_graduated_elem_jhs" class="form-label">Year Graduated</label>
                                <input type="text" name="year_graduated_elem_jhs" id="year_graduated_elem_jhs"
                                    class="form-control" placeholder="" aria-describedby="helpId">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="senior_highschool" class="form-label">Senior High School</label>
                                <input type="text" name="senior_high_school" id="senior_high_school"
                                    class="form-control" placeholder="" aria-describedby="helpId">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="year_graduated" class="form-label">Year Graduated</label>
                                <input type="text" name="year_graduated_elem_shs" id="year_graduated_elem_shs"
                                    class="form-control" placeholder="" aria-describedby="helpId">
                            </div>
                        </div>
                        <div class="row">
                            <h5 class="form-label">Parent Information</h5>
                            <div class="col-md-5 mb-3">
                                <label for="mother_fullname" class="form-label">Mother Full Name</label>
                                <input type="text" name="mothers_fullname" id="mothers_fullname"
                                    class="form-control" aria-describedby="helpId">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="occupation" class="form-label">Occupation</label>
                                <input type="text" name="occupation_mother" id="occupation_mother"
                                    class="form-control" placeholder="" aria-describedby="helpId">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="occupation" class="form-label">Contact Number</label>
                                <input type="text" name="contact_number_mother" id="contact_number_mother"
                                    class="form-control" placeholder="" aria-describedby="helpId">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label for="fathers_fullname" class="form-label">Father Full Name</label>
                                <input type="text" name="fathers_fullname" id="fathers_fullname"
                                    class="form-control" aria-describedby="helpId">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="occupation_father" class="form-label">Occupation</label>
                                <input type="text" name="occupation_father" id="occupation_father"
                                    class="form-control" placeholder="occupation_father" aria-describedby="helpId">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="contact_number_father" class="form-label">Contact Number</label>
                                <input type="text" name="contact_number_father" id="contact_number_father"
                                    class="form-control" placeholder="" aria-describedby="helpId">
                            </div>
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
</div>
@push('scripts')
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            const semesterSelect = document.getElementById("semester");
            const idNumberSelect = document.getElementById("id_number");

            // Function to set the ID number based on the selected semester
            function setIDNumber(selectedSemester) {
                if (selectedSemester) {
                    // Make an AJAX request to retrieve the last generated ID
                    fetch('get-last-id')
                        .then(response => response.json())
                        .then(data => {
                            const lastGeneratedID = data.lastID;
                            if (lastGeneratedID) {
                                // Extract the number part from the last generated ID and increment it
                                const lastNumber = parseInt(lastGeneratedID.split("-").pop(), 10);
                                const nextNumber = lastNumber + 1;
                                // Construct the new ID
                                const schoolYear = '2023';
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
                                idNumberSelect.innerHTML =
                                    '<option value="">--Select ID Number--</option>';
                            }
                        });
                } else {
                    idNumberSelect.innerHTML = '<option value="">Select ID Number</option>';
                }
            }

            // Call the function on page load to set the ID number based on the default semester
            const defaultSemester = semesterSelect.value;
            setIDNumber(defaultSemester);
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            $("#searchButton").on("click", function() {
                var searchTerm = $("#searchInput").val().toLowerCase();
                $("#course_id option").each(function() {
                    var optionText = $(this).text().toLowerCase();
                    if (optionText.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Function to generate ID based on the selected semester
            function generateID(selectedSemester) {
                var currentYear = new Date().getFullYear();
                var generatedID = currentYear + '-' + selectedSemester + Math.floor(Math.random() * 10000);
                return generatedID;
            }

            // Add event listener to the semester input
            $('#semester').on('input', function() {
                // Get the selected semester
                var selectedSemester = $(this).val();

                // Generate the ID based on the selected semester
                var generatedID = generateID(selectedSemester);

                // Set the generated ID in the ID Number input
                $('#id_number').val(generatedID);
            });

            var initialSemester = $('#semester').val();
            var initialGeneratedID = generateID(initialSemester);
            $('#id_number_iddd').val(initialGeneratedID);


            $('#course_id_select2').select2({
                dropdownParent: $('#createAccountModal'),
                dropdownAutoWidth: true
            });


            $('#discount_id_select2').select2({
                dropdownParent: $('#createAccountModal'),
                dropdownAutoWidth: true
            });
        });
    </script>
    <script>
        var CurrentDate = new Date();

        var formattedDate = CurrentDate.toISOString().split('T')[0];

        document.getElementById("admission_date_id").value = formattedDate;
    </script>
    <script>
        $(document).ready(function() {
            function generateAutoIncrementValue(lastIdNumber) {
                var currentValue = parseInt(lastIdNumber.slice(-4)) || 0;
                var newValue = currentValue + 1;
                var paddedValue = ('000' + newValue).slice(-4);
                return paddedValue;
            }
            $.ajax({
                url: '{{ route('superadmin.get.LastIdNumber') }}',
                method: 'GET',
                success: function(response) {
                    var lastIdNumber = response.last_id_number;
                    var nextIdNumber = generateAutoIncrementValue(lastIdNumber);
                    $('#id_number_iddd').val(nextIdNumber);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    </script>
@endpush
