 <!--  Modal content for the above example -->
 <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
     aria-hidden="true">
     <div class="modal-dialog modal-xl">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="myExtraLargeModalLabel">Student Creation</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <form action="{{ route('superadmin.studentapplicant.store') }}" method="POST"
                     enctype="multipart/form-data">
                     @csrf
                     <div class="d-flex justify-content-center">
                     </div>
                     <div class="form-group">
                         <label for="id_number" class="form-label">Semester</label>
                         <select name="semester" id="semester" class="form-select id-number" aria-describedby="helpId">
                             <option value="">Select Semester</option>
                             <option value="1">1</option>
                         </select>
                     </div>
                     <div class="form-group">
                         <label for="id_number" class="form-label">ID Number</label>
                         <select name="id_number" id="id_number" class="form-select id-number"
                             aria-describedby="helpId">
                             <option value="">Select ID Number</option>
                         </select>
                     </div>
                     <div class="form-group">
                         <label>Last Name</label>
                         <input type="text" class="form-control" name="last_name" id="last_name" value="">
                     </div>
                     <div class="form-group">
                         <label>First Name</label>
                         <input type="text" class="form-control" name="first_name" id="first_name" value="">
                     </div>
                     <div class="form-group">
                         <label>Middle Name</label>
                         <input type="text" name="middle_name" id="middle_name" class="form-control" value="">
                     </div>
                     <div class="form-group">
                         <label for="suffix" class="form-label">Suffix</label>
                         <select name="suffix" id="suffix" class="form-select" aria-describedby="helpId">
                             <option value="">Select</option>
                             <option value="Jr.">Jr.</option>
                             <option value="II">II</option>
                             <option value="III">III</option>
                             <option value="IV">IV</option>
                         </select>
                     </div>
                     <div class="form-group">
                         <label for="gender" class="form-label">Gender</label>
                         <select name="gender" id="gender" class="form-select" aria-describedby="helpId">
                             <option value="">Select</option>
                             <option value="Male">Male</option>
                             <option value="Female">Female</option>
                         </select>
                     </div>
                     <div class="form-group">
                         <label for="date_of_birth" class="form-label">Date of Birth</label>
                         <input type="date" name="date_of_birth" id="date_of_birth" class="form-control"
                             placeholder="" aria-describedby="helpId" value="">
                     </div>
                     <div class="form-group">
                         <label>Place of Birth</label>
                         <input type="text" class="form-control" name="place_of_birth" id="place_of_birth"
                             value="">
                     </div>
                     <div class="form-group">
                         <label>Nationality</label>
                         <input type="text" class="form-control" name="nationality" id="nationality" value="">
                     </div>
                     <div class="form-group">
                         <label>Religion</label>
                         <input type="text" class="form-control" name="religion" id="religion" value="">
                     </div>

                     <label for="inputState">Select Status</label>
                     <select id="inputState" class="form-control" name="status">
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
 </div>

 @push('scripts')
     <script>
         document.addEventListener("DOMContentLoaded", function() {
             const semesterSelect = document.getElementById("semester");
             const idNumberSelect = document.getElementById("id_number");

             semesterSelect.addEventListener("change", function() {
                 const selectedSemester = semesterSelect.value;
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
             });
         });
     </script>
 @endpush
