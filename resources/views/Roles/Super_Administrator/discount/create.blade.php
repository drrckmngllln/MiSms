<!--  Modal content for the above example -->
<div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
    aria-hidden="true" id="createDiscount">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Discount Creation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('superadmin.discount.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="d-flex justify-content-center">
                    </div>
                    <div class="form-group">
                        <label>Discount Type</label>
                        <select name="code" id="code_1" class="form-select" aria-describedby="helpId">
                            <option value="">Select</option>
                            <option value="TUITION FEE/UNITS">TUITION FEE/UNITS</option>
                            <option value="Sons & Daughters of Employee">Sons & Daugters of Employees </option>
                            <option value="Sisters and Brothers of Employee">Sisters and Brothers of Employee </option>
                            <option value="Immediate Ward-Niece/Nephew & 1st Degree Cousin Employee">Immediate
                                Ward-Niece/Nephew & 1st Degree Cousin Employee</option>
                            <option value="TOP1/ Class Valedictorian">TOP1/ Class Valedictorian</option>
                            <option value="TOP2/ Class Salutatorian">TOP2/ Class Salutatorian</option>
                            <option value="TOP3/ 1st Honorable Mention">TOP3/ 1st Honorable Mention</option>
                            <option value="TOP4/ 2nd Honorable Mention">TOP4/ 2nd Honorable Mention</option>
                            <option value="TOP5/ 3rd Honorable Mention">TOP5/ 3rd Honorable Mention</option>
                            <option value="TOP 6-10">TOP 6-10</option>
                            <option value="TOP 11-20">TOP 11-20</option>
                            <option value="Average 85% and Above">Average 85% and Above</option>
                            <option value="Sons/Daugthers of AFP,PBP,PARAMILITARY Personnel">Sons/Daugthers of
                                AFP,PBP,PARAMILITARY Personnel</option>
                            <option value="Sons/Daugthers of Highschool & Elementary Teachers">Sons/Daugthers of
                                Highschool & Elementary Teachers</option>
                            <option value="Sons/Daugthers of Health Workers">Sons/Daugthers of Health Workers</option>
                            <option value="CASH">CASH</option>
                            <option value="Brother & Sisters Dicount Students">Brother & Sisters Dicount Students
                            </option>
                            <option value="MCNP-ISAP SCHOLAR/GRANTEES">MCNP-ISAP SCHOLAR/GRANTEES</option>
                            <option value="Orphans Stay Out">Orphans Stay Out</option>
                            <option value="SK CHAIRMAN">SK CHAIRMAN</option>
                            <option value="Sons/Daughters of BRGY.CAPTAIN">Sons/Daughters of BRGY.CAPTAIN</option>
                            <option value="100% Discount on Tuition Fee ORPHANS">Institutional Discount (Atheletic,Socio
                                Cultural & School Publication)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Discount Code</label>
                        <input type="text" class="form-control" name="discount_code" id="discount_code"
                            placeholder="Ex.ACADEMIC" required>
                    </div>
                    <div class="form-group">
                        <label for="discount_target" class="form-label">Discount Target</label>
                        <select name="discount_target" id="discount_target" class="form-select id-number"
                            aria-describedby="helpId">
                            <option value="">Select Discount</option>
                            <option value="Tuition Fee 100%">Tuition Fee 100%</option>
                            <option value="Tuition Fee 50%">Tuition Fee 50%</option>
                            <option value="Tuition Fee 100%/Misc Fee 100%">Tuition Fee 100% / Misc Fee 100%</option>
                            <option value="Misc Fee 100%">Misc Fee 100%</option>
                            {{-- <option value="Tuition Fee 80%/Misc Fee 100%">Tuition Fee 80%/Misc Fee 100%</option> --}}
                            <option value="35% Discount Crim/Ca">35% Discount Crim/Ca
                            </option>
                            <option value="cash 3000">Cash 3000</option>
                            <option value="5% Discount Tuition Fee Only">5% Discount Tuition Fee Only</option>
                            <option value="10% Discount Tuition Fee Only">10% Discount Tuition Fee Only</option>
                            <option value="100% MCNP-ISAP SCHOLAR/GRANTEES">100% MCNP-ISAP SCHOLAR/GRANTEES</option>
                            <option value="100% Discount on Tuition Fee ORPHANS">100%
                                Discount on Tuition Fee
                                only ORPHANS stay-out</option>
                            <option value="25% Discount on Tuition Fee">25% Discount on Tuition Fee only
                            </option>
                            <option value="25% Discount on Tuition Fee SONS/DAUGTHERS OF BRGY.CAPTAIN">SONS/DAUGTHERS OF
                                BRGY.CAPTAIN</option>
                            <option value="2000 Discount TOP 6-10">TOP 6-10</option>
                            <option value="1000 Discount TOP 11-20">TOP 11-20</option>
                            <option value="500 Discount Average 85% and ABOVE">Average 85% and ABOVE</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <select name="description" id="description" class="form-select id-number"
                            aria-describedby="helpId">
                            <option value="">Select</option>
                            <option value="TUITION FEE/UNITS">TUITION FEE/UNITS</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Discount Type</label>
                        <input type="text" class="form-control" name="discount_type" id="discount_type"
                            placeholder="Ex.Academic Scholar" required>
                    </div>
                    <div class="form-group">
                        <label>Discount Percentage</label>
                        <input type="text" class="form-control" name="discount_percentage" id="discount_percentage"
                            placeholder="Ex.100" required>
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
    <script>
        $(document).ready(function() {
            $('#code_1').select2({
                dropdownParent: $('#createDiscount'),
                dropdownAutoWidth: true
            });
        });
    </script>
@endpush
