<div class="col-sm-6 col-md-4 col-xl-3">
    <div class="my-4 text-center">
        <!-- Your content here -->
    </div>

    <!-- Modal content for the above example -->
    <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Fees Creation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="" method="POST" enctype="multipart/form-data" id="Fees_Save">
                                    @method('POST')
                                    @csrf
                                    <div class="d-flex justify-content-center">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 mb-3">
                                            <label>Code</label>
                                            <input type="text" class="form-control" name="course_code"
                                                id="course_code_id" readonly>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="course_id" class="form-label">Course</label>
                                            <select name="course_id" id="course_id" class="form-select id-number"
                                                aria-describedby="helpId" required>
                                                <option value="" selected disabled>--Select One--</option>
                                                @foreach ($courses as $course)
                                                    <option value="{{ $course->id }}">{{ $course->code }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label>Year Level</label>
                                            <input type="text" class="form-control" name="year_level"
                                                id="year_level_id" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="free_type_id" class="form-label" required>Fee type</label>
                                            <select name="free_type_id" id="free_type_id" class="form-select"
                                                aria-describedby="helpId">
                                                <option value="" selected disabled>--Select One--</option>
                                                {{-- @foreach ($feescategories as $feescategory)
                                                    <option value="{{ $feescategory->id }}">{{ $feescategory->freetype }}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label>Amount</label>
                                            <input type="text" class="form-control" name="amount" id="amount_1"
                                                readonly>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Remarks</label>
                                            <input type="text" class="form-control" name="remarks" id="remarks"
                                                required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Total</label>
                                            <input type="t" class="form-control" id="total_id" readonly>
                                        </div>
                                    </div>
                            </div>
                            <table id="datatable-add-unit"
                                class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Fee Type Id</th>
                                        <th>Fee Type</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary waves-effect waves-light"
                                    id="addButton">Add</button>
                                <button type="submit" class="btn btn-success" id="SaveInfo">Save</button>
                                </form>
                            </div>
                        </div><!-- /.card -->
                    </div><!-- /.col-12 -->
                </div><!-- /.modal-body -->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div><!-- /.col-sm-6 col-md-4 col-xl-3 -->
@push('scripts')
    <script>
        //course by feetype
        $(document).ready(function() {
            $('#course_id').on('change', function(event) {
                const course_id = event.target.value;
                // console.log('course_id', course_id);
                $.ajax({
                    url: location.origin + '/superadmin/course/by_feetype/' +
                        course_id,
                    method: 'GET',
                    success: function(data) {
                        console.log('section', data);

                        const select_curr = $('#free_type_id');
                        select_curr.empty();
                        select_curr.append($("<option>").text("--Available Fee Types--").val(
                            '').attr(
                            'selected', true).attr('disabled', true));
                        for (const curr of data) {
                            const newOption = $("<option>").text(curr.freetype).val(curr
                                .id).attr('data-amount', curr.amount).attr('data-freetype',
                                curr.freetype)
                            select_curr.append(newOption);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });
            // KAPAG NA SELECT YUNG FEE TYPE MAPUPUMTA ITO SA AMOUNT
            $('#free_type_id').on('change', function(event) {
                var selectedOptionText = $(this).find(':selected').data('amount');
                console.log(selectedOptionText);
                $('#amount_1').val(selectedOptionText);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            const dt = $('#datatable-add-unit').DataTable();
            const totalInput = $('#total_id');

            $('#addButton').on('click', function() {
                const freetype = $('#free_type_id option:selected').data('freetype');
                const free_type_id = $('#free_type_id').val();
                const amount_1 = $('#amount_1').val();

                const freetypeid = $('#free_type_id option:selected').val();

                // Add a delete button to each row
                const deleteButton =
                    '<button class="btn btn-danger delete-row"><i class="ri-delete-bin-fill"></i></button>';
                dt.row.add([freetypeid, freetype, '₱' + amount_1, deleteButton]).draw();
                $('#free_type_id').val('');

                // Add amount to total
                const oldTotal = parseFloat(totalInput.val().replace('₱', '')) || 0;
                const newTotal = oldTotal + parseFloat(amount_1);
                totalInput.val('₱' + newTotal.toFixed(2));
            });

            $('#datatable-add-unit').on('click', '.delete-row', function() {
                const tr = $(this).closest('tr');
                const rowAmount = parseFloat(dt.row(tr).data()[1].replace('₱', ''));

                const amount_1 = $('#amount_1').val('');

                // Subtract amount from total
                const oldTotal = parseFloat(totalInput.val().replace('₱', '')) || 0;
                const newTotal = oldTotal - rowAmount;
                totalInput.val('₱' + newTotal.toFixed(2));

                dt.row(tr).remove().draw();
            });
        });
    </script>
    <script>
        // Saving content of yajra data tables
        $(document).ready(function() {
            $('#Fees_Save').on('submit', function(event) {
                event.preventDefault();

                // Kukunin niya yung values yung sa loob ng form itong serializeArray
                const formValues = $(this).serializeArray();
                const formData = new FormData();

                console.log(formValues);

                formValues.forEach((item) => {
                    formData.append(item.name, item.value);
                })
                const dt = $("#datatable-add-unit").DataTable();
                // formData.append('fees', dt.data().toArray());

                dt.data().toArray().forEach((item) => {
                    formData.append('fees[]', JSON.stringify(item));
                    console.log(item)
                })
                $.ajax({
                    url: '{{ route('superadmin.feetype.store') }}',
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(data) {
                        console.log(data);
                        location.reload();
                    }
                })
            });
        });
    </script>
    <script>
        //pag na select yung course tas kapag nag input ng year level mapupunta ito sa input na course_code_id 
        $(document).ready(function() {
            $('#year_level_id').on('change', function() {
                const year_level = $(this).val();
                const course = $('#course_id option:selected').text();

                const yearleveltocourse = course + '-' + year_level;

                $('#course_code_id').val(yearleveltocourse);
            })
        })
    </script>
@endpush
