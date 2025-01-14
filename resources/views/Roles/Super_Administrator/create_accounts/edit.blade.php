<!-- Modal content for the above example -->
<div class="modal fade bs-example-modal-xl" tabindex="-1" id="editCreateAccount" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Edit Student Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="edit_form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit_id">
                    <div class="row">
                        <div>
                            <h5 class="form-label">Personal Information</h5>

                            <div>
                                <hr style="border: none; height: 2px; background-color: #000; margin: 10px 0;">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-3 mb-3 mx-auto text-center" style="right: 80px">
                                <label for="id_number" class="form-label">Type of Students</label>
                                <select name="type_of_students" id="edit_type_of_students_id"
                                    class="form-select id-number" aria-describedby="helpId">
                                    <option value="">Select Type</option>
                                    <option value="Freshman">Freshman</option>
                                    <option value="Transferee">Transferee</option>
                                    <option value="Regular">Regular</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-1 mx-2" style="right: 350px">
                                <label for="course" class="form-label">Course</label>
                                <select name="course_id" id="course_id_select2_edit" class="form-select id-number"
                                    aria-describedby="helpId">
                                    <option value="">Select Type</option>
                                    @foreach ($course as $cs)
                                        <option value="{{ $cs->id }}">{{ $cs->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3 mx-auto text-center">
                            <label for="campus_id" class="form-label">Campus</label>
                            <select name="campus_id" id="edit_campus_idss" class="form-select id-number"
                                aria-describedby="helpId">
                                <option value="">Select Campus</option>
                                @foreach ($campus as $cm)
                                    <option value="{{ $cm->id }}">{{ $cm->code }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="course" class="form-label">Department</label>

                            <select name="discount_id" id="edit_discount_id_select2" class="form-select id-number"
                                aria-describedby="helpId">
                                <option value="">Select Department</option>
                                @foreach ($department as $dp)
                                    <option value="{{ $dp->id }}">{{ $dp->code }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-3 mb-3">
                            <label for="id_number" class="form-label">Date of Admission</label>
                            <input type="text" name="admission_date" id="edit_admission_date_id" class="form-control"
                                placeholder="" aria-describedby="helpId">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="id_number" class="form-label">ID Number</label>
                            <input type="text" name="id_number" id="edit_id_number" class="form-control"
                                placeholder="" aria-describedby="helpId">
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" name="last_name" id="edit_last_name" class="form-control"
                                placeholder="" aria-describedby="helpId" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" name="first_name" id="edit_first_name" class="form-control"
                                placeholder="" aria-describedby="helpId" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="middle_name" class="form-label">Middle Name</label>
                            <input type="text" name="middle_name" id="edit_middle_name" class="form-control"
                                placeholder="" aria-describedby="helpId" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="id_number" class="form-label">Gender</label>
                            <select name="gender" id="edit_gender" class="form-select id-number"
                                aria-describedby="helpId">
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
                            <input type="date" name="date_of_birth" id="edit_date_of_birth" class="form-control"
                                placeholder="" aria-describedby="helpId" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="home_address" class="form-label">Prefix</label>
                            <input type="text" name="extention" id="extention_id" class="form-control"
                                placeholder="" aria-describedby="helpId">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="place_of_birth" class="form-label">Place of Birth</label>
                            <input type="text" name="place_of_birth" id="edit_place_of_birth"
                                class="form-control" placeholder="" aria-describedby="helpId" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="nationality" class="form-label">Nationality</label>
                            <input type="text" name="nationality" id="edit_nationality" class="form-control"
                                placeholder="" aria-describedby="helpId" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="religion" class="form-label">Religion</label>
                            <input type="text" name="religion" id="edit_religion" class="form-control"
                                placeholder="" aria-describedby="helpId" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="text" name="control_number" id="edit_contact_number"
                                class="form-control" placeholder="" aria-describedby="helpId" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control"
                                placeholder="" aria-describedby="helpId" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="home_address" class="form-label">Home Address</label>
                            <input type="text" name="home_address" id="edit_home_address" class="form-control"
                                placeholder="" aria-describedby="helpId" required>
                        </div>
                    </div>
                    <div class="row">
                        <div>
                            <div>
                                <hr style="border: none; height: 2px; background-color: #000; margin: 10px 0;">
                            </div>
                        </div>
                        <h5 class="form-label">Present Address</h5>

                        <div class="col-md-3 mb-3">
                            <label for="region" class="form-label">Select Region</label>
                            <select id="municipalityy" name="regioncode" class="form-select">
                                <option value="">Select region</option>
                            </select>
                            <input type="hidden" id="hidden-region-name_edit" name="regionname">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="municipality" class="form-label">Select Province/Municipality</label>
                            <select id="cities-provincee" name="municipality_code" class="form-select">
                                <option value="">Select province</option>
                            </select>
                            <input type="hidden" id="hidden-city-municipality-name_edit" name="municipality">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="municipality" class="form-label">Select Barangay</label>
                            <label for="barangayy" class="form-label">Province</label>
                            <select id="barangayss" name="barangay_code" class="form-select">
                                <option value="">Select barangay</option>
                            </select>
                            <input type="hidden" id="hidden-barangay-namee_edit" name="barangay">
                        </div>

                        {{-- <div class="col-md-3 mb-3">
                            <label for="island-group" class="form-label">Select Island Group</label>
                            <select id="island-groupp" name="island" class="form-select">
                                <option value="">Select Island Group</option>
                                <option value="luzon">Luzon</option>
                                <option value="visayas">Visayas</option>
                                <option value="mindanao">Mindanao</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="city-municipalityy" class="form-label">City/Municipality</label>
                            <select id="city-municipalityy" name="municipality_code" class="form-select">

                                <option value="">Select City/Municipality</option>
                            </select>
                            <input type="hidden" id="hidden-city-municipality-namee" name="municipality">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="barangayy" class="form-label">Barangay</label>
                            <select id="barangayy" name="barangay_code" class="form-select">
                                <option value="">Select Barangay</option>
                            </select>
                            <input type="hidden" id="hidden-barangay-namee" name="barangay">
                        </div> --}}
                        <div class="col-md-1 mb-1">
                            <label for="home_address" class="form-label">House No.</label>
                            <input type="text" name="houseno" id="houseno_id" class="form-control"
                                placeholder="Optional" aria-describedby="helpId">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="home_address" class="form-label">Street Name</label>
                            <input type="text" name="streetname" id="streetname_id" class="form-control"
                                placeholder="zone/street/purok" aria-describedby="helpId">
                        </div>
                    </div>
                    <div class="row">
                        <div>
                            <div>
                                <hr style="border: none; height: 2px; background-color: #000; margin: 10px 0;">
                            </div>
                        </div>
                        <h5 class="form-label">School Attended</h5>
                        <div class="col-md-8 mb-3">
                            <label for="elementary" class="form-label">Elementrary</label>
                            <input type="text" name="elementary" id="edit_elementary" class="form-control"
                                aria-describedby="helpId">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="year_graduated_elem" class="form-label">Year Graduated</label>
                            <input type="text" name="year_graduated_elem" id="edit_year_graduated_elem"
                                class="form-control" placeholder="" aria-describedby="helpId">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="junior_highschool" class="form-label">Junior High School</label>
                            <input type="text" name="junior_high_school" id="edit_junior_high_school"
                                class="form-control" placeholder="" aria-describedby="helpId">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="year_graduated" class="form-label">Year Graduated</label>
                            <input type="text" name="year_graduated_elem_jhs" id="edit_year_graduated_elem_jhs"
                                class="form-control" placeholder="" aria-describedby="helpId">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="senior_highschool" class="form-label">Senior High School</label>
                            <input type="text" name="senior_high_school" id="edit_senior_high_school"
                                class="form-control" placeholder="" aria-describedby="helpId">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="year_graduated" class="form-label">Year Graduated</label>
                            <input type="text" name="year_graduated_elem_shs" id="edit_year_graduated_elem_shs"
                                class="form-control" placeholder="" aria-describedby="helpId">
                        </div>
                    </div>
                    <div class="row">
                        <div>
                            <div>
                                <hr style="border: none; height: 2px; background-color: #000; margin: 10px 0;">
                            </div>
                        </div>
                        <h5 class="form-label">Parent Information</h5>
                        <div class="col-md-5 mb-3">
                            <label for="mother_fullname" class="form-label">Mother Full Name</label>
                            <input type="text" name="mothers_fullname" id="edit_mothers_fullname"
                                class="form-control" aria-describedby="helpId">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="occupation" class="form-label">Occupation</label>
                            <select name="occupation_mother" id="edit_occupation_mother"
                                class="form-select id-number" aria-describedby="helpId">
                                <option value="Goverment">Goverment</option>
                                <option value="Private">Private</option>
                                <option value="OFW">OFW</option>
                                <option value="Farmer">Farmer</option>
                                <option value="Farmer">HouseWife</option>
                                <option value="Retired">Retired Government</option>
                                <option value="Retired Private">Retired Private</option>
                                <option value="Unemployed">Unemployed</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="occupation" class="form-label">Contact Number</label>
                            <input type="text" name="contact_number_mother" id="edit_contact_number_mother"
                                class="form-control" placeholder="" aria-describedby="helpId">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="father_fullname" class="form-label">Father Full Name</label>
                            <input type="text" name="fathers_fullname" id="edit_fathers_fullname"
                                class="form-control" aria-describedby="helpId">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="civil_status" class="form-label">Father Occupation</label>
                            <select name="occupation_father" id="edit_occupation_father"
                                class="form-select id-number" aria-describedby="helpId">
                                <option value="">Select Work</option>
                                <option value="Goverment">Goverment</option>
                                <option value="Private">Private</option>
                                <option value="OFW">OFW</option>
                                <option value="Farmer">Farmer</option>
                                <option value="Retired">Retired Government</option>
                                <option value="Retired Private">Retired Private</option>
                                <option value="Unemployed">Unemployed</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="occupation" class="form-label">Contact Number</label>
                            <input type="text" name="contact_number_father" id="edit_contact_number_father"
                                class="form-control" placeholder="" aria-describedby="helpId">
                        </div>
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

@push('scripts')
    <script>
        function createaccount(id, id_number, sy_enrolled, school_year, last_name, first_name, middle_name, gender,
            civil_status, date_of_birth, place_of_birth, nationality, religion, course_id, admission_date, campus_id,
            discount_id, control_number, email, home_address, type_of_students, year_level, elementary,
            year_graduated_elem, junior_high_school, year_graduated_elem_jhs, senior_high_school,
            year_graduated_elem_shs, mothers_fullname, occupation_mother, contact_number_mother,
            fathers_fullname, occupation_father, contact_number_father, island, municipality, barangay, municipality_code,
            barangay_code,
            extention, streetname, houseno, regioncode, regionname
        ) {
            // Set all the basic fields
            // console.log(municipality);
            $('#edit_id').val(id);
            $('#edit_id_number').val(id_number);
            $('#edit_sy_enrolled').val(sy_enrolled);
            $('#edit_school_year').val(school_year);
            $('#edit_last_name').val(last_name);
            $('#edit_first_name').val(first_name);
            $('#edit_middle_name').val(middle_name);
            $('#edit_gender').val(gender);
            $('#edit_civil_status').val(civil_status);
            $('#edit_date_of_birth').val(date_of_birth);
            $('#edit_place_of_birth').val(place_of_birth);
            $('#edit_nationality').val(nationality);
            $('#edit_religion').val(religion);
            course_select_edit.val(course_id).trigger('change.select2');
            $('#edit_admission_date_id').val(admission_date);
            $('#edit_campus_idss').val(campus_id);
            $('#edit_discount_id_select2').val(discount_id);
            $('#edit_contact_number').val(control_number);
            $('#edit_email').val(email);
            $('#edit_home_address').val(home_address);
            $('#edit_type_of_students_id').val(type_of_students);
            $('#year_level_iddd').val(year_level);
            $('#edit_elementary').val(elementary);
            $('#edit_year_graduated_elem').val(year_graduated_elem);
            $('#edit_junior_high_school').val(junior_high_school);
            $('#edit_year_graduated_elem_jhs').val(year_graduated_elem_jhs);
            $('#edit_senior_high_school').val(senior_high_school);
            $('#edit_year_graduated_elem_shs').val(year_graduated_elem_shs);
            $('#edit_mothers_fullname').val(mothers_fullname);
            $('#edit_occupation_mother').val(occupation_mother);
            $('#edit_contact_number_mother').val(contact_number_mother);
            $('#edit_fathers_fullname').val(fathers_fullname);
            $('#edit_occupation_father').val(occupation_father);
            $('#edit_contact_number_father').val(contact_number_father);
            $('#extention_id').val(extention);

            $('#hidden-region-name_edit').val(regionname);


            $('#hidden-city-municipality-name_edit').val('');

            $('#barangayss').val(barangay_code);
            $('#hidden-barangay-namee_edit').val(barangay);

            $('#municipalityy').val(regioncode).trigger('change');
            $.ajax({
                url: '/superadmin/cities-province',
                type: 'GET',
                data: {
                    regionCode: regioncode
                },
                success: function(response) {
                    const citiesSelect = $('#cities-provincee');
                    citiesSelect.empty().append('<option value="">Select province</option>');
                    response.forEach(cityProvince => {
                        if (cityProvince.regionCode === regioncode) {
                            citiesSelect.append(
                                `<option value="${cityProvince.code}">${cityProvince.name}</option>`
                            );
                        }
                    });
                    citiesSelect.val(municipality_code).trigger('change');
                },
                error: function() {
                    alert('Error fetching cities/provinces.');
                }
            });

            // Fetch and set barangay based on saved barangay_code
            $.ajax({
                url: '/superadmin/barangay',
                type: 'GET',
                data: {
                    regionCode: regioncode,
                    municipalityCode: municipality_code
                },
                success: function(response) {
                    const barangaySelect = $('#barangayss');
                    barangaySelect.empty().append('<option value="">Select barangay</option>');
                    response.forEach(barangay => {
                        barangaySelect.append(
                            `<option value="${barangay.code}">${barangay.name}</option>`);
                    });
                    barangaySelect.val(barangay_code).trigger('change');
                },
                error: function() {
                    alert('Error fetching barangays.');
                }
            });



            $('#edit_form').attr('action', location.href + '/' + id);

        }
    </script>
    <script>
        //update ui   
        let course_select_edit;
        $(document).ready(function() {
            course_select_edit = $('#course_id_select2_edit').select2({
                dropdownParent: $('#editCreateAccount'),
                dropdownAutoWidth: true
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            $.ajax({
                url: '/superadmin/region',
                type: 'GET',
                success: function(response) {
                    let regionSelect = $('#municipalityy');
                    regionSelect.empty();
                    regionSelect.append(`<option value="">Select region</option>`);

                    response.forEach(function(region) {
                        regionSelect.append(
                            `<option value="${region.code}">${region.name}</option>`
                        );
                    });
                },
                error: function() {

                }
            });


            $('#municipalityy').on('change', function() {
                let selectedRegionCode = $(this).val();
                let selectedRegionName = $(this).find('option:selected').text();

                $('#hidden-region-name').val(selectedRegionName);


                $.ajax({
                    url: '/superadmin/cities-province',
                    type: 'GET',
                    data: {
                        regionCode: selectedRegionCode
                    },
                    success: function(response) {
                        let citiesProvinceSelect = $('#cities-provincee');
                        citiesProvinceSelect.empty(); // Clear existing options
                        citiesProvinceSelect.append(
                            `<option value="">Select province</option>`);

                        // Filter provinces based on selected regionCode
                        response.forEach(function(cityProvince) {
                            if (cityProvince.regionCode === selectedRegionCode) {
                                citiesProvinceSelect.append(
                                    `<option value="${cityProvince.code}">${cityProvince.name}</option>`
                                );
                            }
                        });
                    },
                    error: function() {
                        alert('Error fetching cities/provinces.');
                    }
                });
            });


            $('#cities-provincee').on('change', function() {
                let selectedMunicipalityCode = $(this).val();
                let selectedRegionCode = $('#municipalityy').val();
                let selectedMunicipalityName = $(this).find('option:selected').text();

                $('#hidden-city-municipality-name_edit').val(selectedMunicipalityName);

                $.ajax({
                    url: '/superadmin/barangay',
                    type: 'GET',
                    data: {
                        regionCode: selectedRegionCode,
                        municipalityCode: selectedMunicipalityCode
                    },
                    success: function(response) {
                        let barangaySelect = $('#barangayss');


                        barangaySelect.empty();
                        barangaySelect.append(`<option value="">Select barangay</option>`);

                        if (Array.isArray(response) && response.length > 0) {
                            response.forEach(function(barangay) {
                                console.log('Adding barangay:', barangay.name);
                                barangaySelect.append(
                                    `<option value="${barangay.code}">${barangay.name}</option>`
                                );
                            });

                        } else {

                            barangaySelect.append(
                                `<option value="">No barangays found</option>`);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching barangays:', error);
                        console.error('Response:', xhr.responseText);
                        alert(
                            'Error fetching barangays. Please check the console for details.'
                        );
                    }
                });
            });
            $('#barangayss').on('change', function() {
                let selectedBarangayName = $(this).find('option:selected').text();
                $('#hidden-barangay-namee_edit').val(selectedBarangayName);


            });
        });
    </script>
@endpush
