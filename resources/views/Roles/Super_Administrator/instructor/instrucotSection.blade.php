<!-- Modal content for the above example -->
<div class="modal fade bs-example-modal-xl" tabindex="-1" id="instructorSection" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Sections Handle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="edit_form" enctype="multipart/form-data">
                    @csrf
                    {{-- @method('PUT') --}}
                    <input type="text" name="section" id="section_iddd" hidden>
                    <input type="text" name="instructor" id="instructor_id" hidden>
                    <input type="text" name="instructor" id="full_name" hidden>


                    <table id="SectionHandle" class="table table-striped table-bordered"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Section</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>


            </div>
            {{-- <div class="modal-footer">
                <button type="submit" class="btn btn-success waves-effect waves-light mt-2"
                    style="float: left;">Save</button>
            </div> --}}
            </form>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

@push('scripts')
    <script>
        function instructorSection(id, full_name) {
            // console.log(full_name);
            localStorage.setItem('instructor_id', id);
            localStorage.setItem('full_name', full_name);


            $("#SectionHandle").DataTable().destroy();

            $("#SectionHandle").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/superadmin/sectionHandled/',
                    type: 'GET',
                    data: {
                        id: id
                    },
                },
                columns: [{
                        data: 'section',
                        name: 'section'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },

                ],


            });

        }
    </script>


    <script>
        function handleSectionWithSub(sectionId) {
            $('#section_iddd').val(sectionId)
            $('#sectionSubject').DataTable().ajax.reload();
        }
    </script>
@endpush
