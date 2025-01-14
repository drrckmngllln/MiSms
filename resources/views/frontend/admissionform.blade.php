<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCNP-ISAP</title>
    <link rel="stylesheet" href="{{ asset('frontend/cssAdmission/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/styleAdmission.css') }}">
</head>

<body>
    <div class="container-fluid bg text-light py-3">
        <header class="text-center">
            <h1 class="display-6">Create Student Account</h1>
        </header>
    </div>
    <section class="container my-2 bg-light w-100 text-dark text-bold p-2">
        <form class="row g-3 p-3 needs-validation" novalidate>
            <div class="col-md-4">
                <label for="" class="form-label">Type of Student<span
                        class="badge text-danger fs-6 top-0">*</span></label>
                <select class="form-select" id="" required>
                    <option selected disabled value="">Choose...</option>
                    <option>...</option>
                </select>
                <div class="invalid-feedback">
                    Please select a type of student.
                </div>
                <div class="valid-feedback">
                    Good!
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Course<span class="badge text-danger fs-6 top-0">*</span></label>
                <input type="text" class="form-control" id="" placeholder="" required>
                <div class="valid-feedback">
                    Good!
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Date of Admission<span class="badge text-danger fs-6 top-0">*</span></label>
                <select class="form-select" id="" required>
                    <option selected disabled value="">Choose...</option>
                    <option>...</option>
                </select>
                <div class="invalid-feedback">
                    Please select a date of admission.
                </div>
                <div class="valid-feedback">
                    Good!
                </div>
            </div>
            <hr>
            <h5 class="h5">Student Information</h5>
            <div class="col-md-3">
                <label for="" class="form-label">ID Number</label>
                <input type="text" class="form-control" id="" disabled value="N/A">
            </div>
            <div class="col-md-6">
                <label for="" class="form-label d-none">School Year</label>
                <input type="text" class="form-control d-none" id=""required>
            </div>
            <div class="col-md-3">
                <label for="" class="form-label">Last Name<span
                        class="badge text-danger fs-6 top-0">*</span></label>
                <input type="text" class="form-control" id="" placeholder="" required>
                <div class="valid-feedback">
                    Good!
                </div>
            </div>
            <div class="col-md-3">
                <label for="" class="form-label">First Name<span
                        class="badge text-danger fs-6 top-0">*</span></label>
                <input type="text" class="form-control" id="" placeholder="" required>
                <div class="valid-feedback">
                    Good!
                </div>
            </div>
            <div class="col-md-3">
                <label for="" class="form-label">Middle Name<span
                        class="badge text-danger fs-6 top-0">*</span></label>
                <input type="text" class="form-control" id="" placeholder="" required>
                <div class="valid-feedback">
                    Good!
                </div>
            </div>
            <div class="col-md-3">
                <label for="" class="form-label">Gender<span
                        class="badge text-danger fs-6 top-0">*</span></label>
                <select id="" class="form-select" required>
                    <option selected disabled value>Choose...</option>
                    <option>...</option>
                </select>
                <div class="invalid-feedback">
                    Please select a gender.
                </div>
                <div class="valid-feedback">
                    Good!
                </div>
            </div>
            <div class="col-md-3">
                <label for="" class="form-label">Civil Status<span
                        class="badge text-danger fs-6 top-0">*</span></label>
                <select id="inputState" class="form-select" required>
                    <option selected disabled value>Choose...</option>
                    <option>...</option>
                </select>
                <div class="invalid-feedback">
                    Please select a civil status.
                </div>
                <div class="valid-feedback">
                    Good!
                </div>
            </div>
            <div class="col-md-3">
                <label for="" class="form-label">Date of Birth<span
                        class="badge text-danger fs-6 top-0">*</span></label>
                <input type="text" class="form-control" id="" placeholder="" required>
                <div class="valid-feedback">
                    Good!
                </div>
            </div>
            <div class="col-md-3">
                <label for="" class="form-label">Place of Birth<span
                        class="badge text-danger fs-6 top-0">*</span></label>
                <input type="text" class="form-control" id="" placeholder="" required>
                <div class="valid-feedback">
                    Good!
                </div>
            </div>
            <div class="col-md-3">
                <label for="" class="form-label">Nationality<span
                        class="badge text-danger fs-6 top-0">*</span></label>
                <input type="text" class="form-control" id="" placeholder="" required>
                <div class="valid-feedback">
                    Good!
                </div>
            </div>
            <div class="col-md-3">
                <label for="" class="form-label">Contact Number<span
                        class="badge text-danger fs-6 top-0">*</span></label>
                <input type="text" class="form-control" id="" placeholder="" required>
                <div class="valid-feedback">
                    Good!
                </div>
            </div>
            <div class="col-md-3">
                <label for="" class="form-label">Email<span
                        class="badge text-danger fs-6 top-0">*</span></label>
                <input type="text" class="form-control" id="" placeholder="" required>
                <div class="valid-feedback">
                    Good!
                </div>
            </div>
            <div class="col-md-6">
                <label for="" class="form-label">Home Address<span
                        class="badge text-danger fs-6 top-0">*</span></label>
                <input type="text" class="form-control" id="" placeholder="" required>
                <div class="valid-feedback">
                    Good!
                </div>
            </div>
            <hr>
            <h5 class="h5">School Attended</h5>
            <div class="col-md-8">
                <label for="" class="form-label">Elementary<span
                        class="badge text-danger fs-6 top-0">*</span></label>
                <input type="text" class="form-control" id="" placeholder="" required>
                <div class="valid-feedback">
                    Good!
                </div>
            </div>
            <div class="col-md-4">
                <label for="" class="form-label">Year Graduated<span
                        class="badge text-danger fs-6 top-0">*</span></label>
                <input type="text" class="form-control" id="" placeholder="" required>
                <div class="valid-feedback">
                    Good!
                </div>
            </div>
            <div class="col-md-8">
                <label for="" class="form-label">Junior High-School<span
                        class="badge text-danger fs-6 top-0">*</span></label>
                <input type="text" class="form-control" id="" placeholder="" required>
                <div class="valid-feedback">
                    Good!
                </div>
            </div>
            <div class="col-md-4">
                <label for="" class="form-label">Year Graduated<span
                        class="badge text-danger fs-6 top-0">*</span></label>
                <input type="text" class="form-control" id="" placeholder="" required>
                <div class="valid-feedback">
                    Good!
                </div>
            </div>
            <div class="col-md-8">
                <label for="" class="form-label">Senior High-School<span
                        class="badge text-danger fs-6 top-0">*</span></label>
                <input type="text" class="form-control" id="" placeholder="" required>
                <div class="valid-feedback">
                    Good!
                </div>
            </div>
            <div class="col-md-4">
                <label for="" class="form-label">Year Graduated<span
                        class="badge text-danger fs-6 top-0">*</span></label>
                <input type="text" class="form-control" id="" placeholder="" required>
                <div class="valid-feedback">
                    Good!
                </div>
            </div>
            <hr>
            <h5 class="h5">Parent Information</h5>
            <div class="col-md-6">
                <label for="" class="form-label">Mother Full Name<span
                        class="badge text-danger fs-6 top-0">*</span></label>
                <input type="text" class="form-control" id=""
                    placeholder="Ex. Lastname, Firstname, Middlename" required>
                <div class="valid-feedback">
                    Good!
                </div>
            </div>
            <div class="col-md-3">
                <label for="" class="form-label">Occupation<span
                        class="badge text-danger fs-6 top-0">*</span></label>
                <input type="text" class="form-control" id="" placeholder="" required>
                <div class="valid-feedback">
                    Good!
                </div>
            </div>
            <div class="col-md-3">
                <label for="" class="form-label">Contact Number<span
                        class="badge text-danger fs-6 top-0">*</span></label>
                <input type="text" class="form-control" id="" placeholder="" required>
                <div class="valid-feedback">
                    Good!
                </div>
            </div>

            <div class="col-md-6">
                <label for="" class="form-label">Father Full Name<span
                        class="badge text-danger fs-6 top-0">*</span></label>
                <input type="text" class="form-control" id=""
                    placeholder="Ex. Lastname, Firstname, Middlename" required>
                <div class="valid-feedback">
                    Good!
                </div>
            </div>
            <div class="col-md-3">
                <label for="" class="form-label">Occupation<span
                        class="badge text-danger fs-6 top-0">*</span></label>
                <input type="text" class="form-control" id="" placeholder="" required>
                <div class="valid-feedback">
                    Good!
                </div>
            </div>
            <div class="col-md-3">
                <label for="" class="form-label">Contact Number<span
                        class="badge text-danger fs-6 top-0">*</span></label>
                <input type="text" class="form-control" id="" placeholder="" required>
                <div class="valid-feedback">
                    Good!
                </div>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                <button class="btn btn-danger me-md-2 rounded-4" type="button">Close</button>
                <button class="btn btn-primary rounded-4" type="submit">Submit</button>
            </div>
        </form>
    </section>
    <script src="dist/js/bootstrap.bundle.min.js"></script>
    <script src="custom.js"></script>
</body>

</html>
