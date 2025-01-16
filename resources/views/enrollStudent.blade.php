<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <title>MCNP-ISAP</title>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        /* Header styles */
        header {
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo {
            width: 120px;
            height: 60px;
        }

        .university-name {
            font-size: 1.25rem;
            font-weight: bold;
            color: #515863;
        }

        .university-campus {
            font-size: 1rem;
        }

        nav {
            position: relative;
        }

        nav ul {
            display: flex;
            list-style-type: none;
            gap: 2rem;
        }

        nav a {
            text-decoration: none;
            color: #4a5568;
        }

        nav a:hover {
            color: #2d3748;
        }

        /* Hamburger menu styles */
        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
        }

        .hamburger div {
            width: 25px;
            height: 3px;
            background-color: #4a5568;
        }

        .mobile-nav {
            display: none;
            flex-direction: column;
            background-color: white;
            position: absolute;
            top: 100%;
            right: 0;
            width: 200px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);
        }

        .mobile-nav ul {
            flex-direction: column;
            padding: 1rem;
        }

        .mobile-nav a {
            padding: 0.5rem 1rem;
            display: block;
            color: #4a5568;
            border-bottom: 1px solid #e2e8f0;
        }

        .mobile-nav a:last-child {
            border-bottom: none;
        }

        .mobile-nav a:hover {
            background-color: #f7fafc;
        }

        /* Hero section styles */
        .hero {
            position: relative;
            width: 100%;
            height: 80vh;
            overflow: hidden;
        }

        .video-frame {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Content grid styles */
        .content-grid {
            max-width: 1200px;
            margin: 3rem auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            padding: 0 1rem;
        }

        .card {
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .card-image {
            height: 200px;
            background-size: cover;
            background-position: center;
        }

        .card-content {
            padding: 1rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .card-description {
            color: #718096;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            nav ul {
                display: none;
            }

            .hamburger {
                display: flex;
            }

            .mobile-nav {
                display: flex;
            }

            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        .container {
            margin: auto;

        }



        label {
            display: block;
            font-size: 1rem;
            margin-bottom: 0.5rem;
            color: #000;
        }

        .required::after {
            content: " *";
            color: #ff0000;
        }

        input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #000;
            border-radius: 4px;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.3s ease;
        }

        input:focus {
            border-color: #00b8b8;
            box-shadow: 0 0 0 1px #00b8b8;
        }

        @media (max-width: 640px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="header-content">
            <div class="logo-container">
                <img src="{{ asset('frontend/images/mcnp-isap.png') }}" alt="University Logo" class="logo">
                <div>
                    <div class="university-name">Medical Colleges of Northern Philippines</div>
                    <div class="university-name">International School of Asia and the Pacific</div>
                    <div class="university-campus">Alimanao Peñablanca Campus</div>
                </div>
            </div>
            <nav>
                <div class="hamburger" id="hamburger">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <ul class="desktop-nav">

                </ul>
                <div class="mobile-nav" id="mobileNav">
                    <ul>

                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <form action="{{ route('student.save') }}" method="POST">
        @csrf
        @method('POST')
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="id_number" class="form-label">Type of Students</label>
                    <select name="type_of_students" id="type_of_students_id" class="form-select id-number" required
                        aria-describedby="helpId">
                        <option value="">Select Type</option>
                        <option value="Freshman">Freshman</option>
                        <option value="Transferee">Transferee</option>
                        <option value="Regular">Regular</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="course" class="form-label">Course</label>
                    <select name="course_id" id="course_id_select2" class="form-select id-number" required
                        aria-describedby="helpId">
                        <option value="">Select Course</option>
                        @foreach ($courses as $cs)
                            <option value="{{ $cs->id }}">{{ $cs->code }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="course" class="form-label">Department</label>
                    <select name="discount_id" id="discount_id_select2" class="form-select id-number" required
                        aria-describedby="helpId">
                        <option value="">Select Department</option>

                        @foreach ($departments as $dm)
                            <option value="{{ $dm->id }}">{{ $dm->code }}</option>
                        @endforeach

                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="campus_id" class="form-label">Campus</label>
                    <select name="campus_id" id="campus_idss" class="form-select id-number" required
                        aria-describedby="helpId">
                        <option value="">Select Campus</option>

                        @foreach ($campus as $cm)
                            <option value="{{ $cm->id }}">{{ $cm->code }}</option>
                        @endforeach

                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="id_number" class="form-label">Date of Admission</label>
                    <input type="text" name="admission_date" id="admission_date_id" class="form-control" required
                        placeholder="" aria-describedby="helpId" readonly>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="id_number" class="form-label">ID Number</label>
                    <input type="text" name="id_number" id="id_number_iddd" class="form-control" required
                        placeholder="N/A" aria-describedby="helpId" readonly>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" required placeholder=""
                        aria-describedby="helpId">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" required placeholder=""
                        aria-describedby="helpId">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="middle_name" class="form-label">Middle Name</label>
                    <input type="text" name="middle_name" id="middle_name" class="form-control" required
                        placeholder="" aria-describedby="helpId">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="civil_status" class="form-label">Gender</label>
                    <select name="gender" id="gender" class="form-select id-number" required
                        aria-describedby="helpId">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="civil_status" class="form-label">Civil Status</label>
                    <select name="civil_status" id="edit_civil_status" class="form-select id-number" required
                        aria-describedby="helpId">
                        <option value="">Select Status</option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" required
                        placeholder="" aria-describedby="helpId">
                </div>

                <div class="col-md-3 mb-3">
                    <label for="place_of_birth" class="form-label">Place of Birth</label>
                    <input type="text" name="place_of_birth" id="place_of_birth" class="form-control" required
                        placeholder="" aria-describedby="helpId">
                </div>

                <div class="col-md-3 mb-3">
                    <label for="nationality" class="form-label">Nationality</label>
                    <input type="text" name="nationality" id="nationality" class="form-control" required
                        placeholder="" aria-describedby="helpId">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="religion" class="form-label">Religion</label>
                    <input type="text" name="religion" id="religion" class="form-control" required
                        placeholder="" aria-describedby="helpId">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="control_number" class="form-label">Contact Number</label>
                    <input type="text" name="control_number" id="control_number" class="form-control" required
                        placeholder="" aria-describedby="helpId">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required
                        placeholder="" aria-describedby="helpId">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="home_address" class="form-label">Prefix</label>
                    <input type="text" name="extention" id="extention_id" class="form-control"
                        placeholder="Optional" aria-describedby="helpId">
                </div>
            </div>
            <div class="row">
                <div>
                    <hr style="border: none; height: 2px; background-color: #000; margin: 10px 0;">
                </div>
                <h5 class="form-label">Present Address</h5>
                <div class="col-md-3 mb-3">
                    <label for="municipality" class="form-label">Select Region</label>
                    <select id="municipality" name="regioncode" class="form-select">
                        <option value="">Select region</option>
                    </select>
                    <input type="hidden" id="hidden-region-name" name="regionname">
                </div>

                <div class="col-md-3 mb-3">
                    <label for="municipality" class="form-label">Select Province/Municipality</label>
                    <select id="cities-province" name="municipality_code" class="form-select">
                        <option value="">Select province</option>
                    </select>
                    <input type="hidden" id="hidden-municipality-name" name="municipality">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="municipality" class="form-label">Select Barangay</label>

                    <select id="barangays" name="barangay_code" class="form-select">
                        <option value="">Select barangay</option>
                    </select>
                    <input type="hidden" id="hidden-barangay-name" name="barangay">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="municipality" class="form-label">Others</label>
                    <input type="text" name="otherLives" id="otherLives" class="form-control"
                        aria-describedby="helpId" placeholder="Optional">

                </div>

                {{-- <div class="col-md-3 mb-3">
                    <label for="island-group" class="form-label">Select Island Group</label>
                    <select id="island-group" name="island" class="form-select">
                        <option value="">Select Island Group</option>
                        <option value="luzon">Luzon</option>
                        <option value="visayas">Visayas</option>
                        <option value="mindanao">Mindanao</option>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="city-municipality" class="form-label">Select City/Municipality</label>
                    <select id="city-municipality" name="municipality_code" class="form-select">
                        <option value="">Select City/Municipality</option>
                    </select>
                    <input type="hidden" id="hidden-city-municipality-name" name="municipality">
                </div>

                <div class="col-md-3 mb-3">
                    <label for="barangay" class="form-label">Barangay</label>
                    <select id="barangay" name="barangay_code" class="form-select">
                        <option value="">Select Barangay</option>
                    </select>
                    <input type="hidden" id="hidden-barangay-name" name="barangay">
                </div> --}}
                <div class="col-md-1 mb-1">
                    <label for="home_address" class="form-label">House No.</label>
                    <input type="text" name="houseno" id="houseno" class="form-control" placeholder="Optional"
                        aria-describedby="helpId">
                </div>
                <div class="col-md-2 mb-2">
                    <label for="home_address" class="form-label">Street Name</label>
                    <input type="text" name="streetname" id="streetname" class="form-control"
                        placeholder="zone/street/purok" aria-describedby="helpId">
                </div>
            </div>
            <div class="row">
                <div>
                    <hr style="border: none; height: 2px; background-color: #000; margin: 10px 0;">
                </div>
                <h5 class="form-label">School Attended</h5>

                <div class="col-md-8 mb-3">
                    <label for="elementary" class="form-label">Elementary</label>
                    <input type="text" name="elementary" id="elementary" class="form-control" required
                        aria-describedby="helpId">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="year_graduated_elem" class="form-label">Year Graduated</label>
                    <input type="text" name="year_graduated_elem" id="year_graduated_elem" class="form-control"
                        required placeholder="" aria-describedby="helpId">
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label for="junior_high_school" class="form-label">Junior High School</label>
                    <input type="text" name="junior_high_school" id="junior_high_school" class="form-control"
                        required placeholder="" aria-describedby="helpId">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="year_graduated_elem_jhs" class="form-label">Year Graduated</label>
                    <input type="text" name="year_graduated_elem_jhs" id="year_graduated_elem_jhs"
                        class="form-control" required placeholder="" aria-describedby="helpId">
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label for="senior_highschool" class="form-label">Senior High School</label>
                    <input type="text" name="senior_high_school" id="senior_high_school" class="form-control"
                        required placeholder="" aria-describedby="helpId">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="year_graduated" class="form-label">Year Graduated</label>
                    <input type="text" name="year_graduated_elem_shs" id="year_graduated_elem_shs"
                        class="form-control" required placeholder="" aria-describedby="helpId">
                </div>
            </div>
            <div class="row">
                <div>
                    <hr style="border: none; height: 2px; background-color: #000; margin: 10px 0;">
                </div>
                <h5 class="form-label">Parent Information</h5>
                <div class="col-md-5 mb-3">
                    <label for="mother_fullname" class="form-label">Mother Full Name</label>
                    <input type="text" name="mothers_fullname" id="mothers_fullname" class="form-control"
                        required aria-describedby="helpId">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="civil_status" class="form-label">Mother Occupation</label>
                    <select name="occupation_mother" id="occupation_mother" class="form-select id-number" required
                        aria-describedby="helpId">
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
                    <input type="text" name="contact_number_mother" id="contact_number_mother"
                        class="form-control" required placeholder="" aria-describedby="helpId">
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 mb-3">
                    <label for="fathers_fullname" class="form-label">Father Full Name</label>
                    <input type="text" name="fathers_fullname" id="fathers_fullname" class="form-control"
                        required aria-describedby="helpId">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="civil_status" class="form-label">Father Occupation</label>
                    <select name="occupation_father" id="occupation_father" class="form-select id-number" required
                        aria-describedby="helpId">
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
                    <label for="contact_number_father" class="form-label">Contact Number</label>
                    <input type="text" name="contact_number_father" id="contact_number_father"
                        class="form-control" required placeholder="" aria-describedby="helpId">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success waves-effect waves-light mt-2"
                    style="float: left;">Save</button>
            </div>
        </div>


    </form>


    <script>
        const hamburger = document.getElementById("hamburger");
        const mobileNav = document.getElementById("mobileNav");

        hamburger.addEventListener("click", () => {
            mobileNav.classList.toggle("active");
        });
    </script>
    <script>
        var CurrentDate = new Date();

        var formattedDate = CurrentDate.toISOString().split('T')[0];

        document.getElementById("admission_date_id").value = formattedDate;
    </script>

</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Populate regions in the first dropdown
        $.ajax({
            url: '/region',
            type: 'GET',
            success: function(response) {
                let regionSelect = $('#municipality');
                regionSelect.empty();
                regionSelect.append(`<option value="">Select region</option>`);

                response.forEach(function(region) {
                    regionSelect.append(
                        `<option value="${region.code}">${region.name}</option>`
                    );
                });
            },
            error: function() {
                toastr.warning('Refresh again the page.');
            }
        });


        $('#municipality').on('change', function() {

            let selectedRegionCode = $(this).val();
            let selectedRegionName = $(this).find('option:selected').text();

            $('#hidden-region-name').val(selectedRegionName);


            $.ajax({
                url: '/cities-province',
                type: 'GET',
                data: {
                    regionCode: selectedRegionCode
                },
                success: function(response) {
                    let citiesProvinceSelect = $('#cities-province');
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


        $('#cities-province').on('change', function() {
            let selectedMunicipalityCode = $(this).val();
            let selectedRegionCode = $('#municipality').val();
            let selectedMunicipalityName = $(this).find('option:selected').text();

            $('#hidden-municipality-name').val(selectedMunicipalityName);

            $.ajax({
                url: '/barangay',
                type: 'GET',
                data: {
                    regionCode: selectedRegionCode,
                    municipalityCode: selectedMunicipalityCode
                },
                success: function(response) {
                    let barangaySelect = $('#barangays');


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
                        console.log('No barangays found or invalid response format');
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
        $('#barangays').on('change', function() {
            let selectedBarangayName = $(this).find('option:selected').text();
            $('#hidden-barangay-name').val(selectedBarangayName);


        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif
</script>
<script>
    $(document).ready(function() {
        function generateAutoIncrementValue(lastIdNumber) {
            var currentYear = new Date().getFullYear();
            var currentValue = parseInt(lastIdNumber.slice(-4)) ||
                0;
            var newValue = currentValue + 1;
            var paddedValue = ('000' + newValue).slice(-4);
            return currentYear + '-' + paddedValue;
        }

        $.ajax({
            url: '{{ route('get.LastIdNumber') }}',
            method: 'GET',
            success: function(response) {
                console.log(response);
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

</html>
