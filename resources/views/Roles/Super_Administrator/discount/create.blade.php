<!--  Modal content for the above example -->
<div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
    aria-hidden="true">
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
                        <label>Code</label>
                        <input type="text" class="form-control" name="code" id="code" required>
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
                            <option value="25% Discount on Tuition Fee SK CHAIRMAN">25% Discount on Tuition Fee only,SK
                                CHAIRMAN</option>
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
                            <option value="">Select Discount</option>
                            <option value="TUITION FEE/UNITS">TUITION FEE/UNITS</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Discount Percentage</label>
                        <input type="text" class="form-control" name="discount_percentage" id="discount_percentage"
                            required>
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
