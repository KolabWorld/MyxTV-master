<footer class="main-footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 fw-medium f-12 text-right">
                © Copyright 2023 MyxTV Media. All rights reserved.
            </div>
        </div>
    </div>
</footer>
<div class="modal fade show" id="promocode" tabindex="-1" role="dialog" aria-labelledby="loginpopupTitle" style="display: none; padding-left: 15px;" aria-modal="true">
    <div class="modal-dialog modal-dialog-slideout" role="document">
        <input type="hidden" name="offer_id" id="offer_id" class="offer_id"
            value="{{ isset($offer) && $offer ? $offer->id : 0 }}">
        <div class="modal-content bg-white">
            <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                <div class="modal-header d-block pt-5 px-3 px-sm-5 border-0">
                    <div class="pt-3">
                        <button type="button" class="close search-btn addaddressbtn p-0" data-dismiss="modal" aria-label="Close">
                            <img src="/assets/admin/images/close.png" width="40px">
                        </button>
                        <div class="head-title">
                            <h2>Promocode</h2>
                            <h5>Add/Edit promocode</h5>
                        </div> 
                        <div class="dashbed-border-bottom mt-3"></div>
                    </div>
                </div>
                <div class="modal-body pt-3 pb-5 px-3 px-sm-5">
                    {{-- <div class="text-right mb-2">
                        <a href="#" class="text-success text-right fw-bold f-12">
                            Download Template
                        </a>
                    </div>
                    <div class="form-group innerappform uploadformbox">
                        <label>
                            Upload Bulk Promocode
                        </label>
                        <input type="text" class="form-control" disabled=""
                         placeholder="(Excel file only)">
                        <div class="upload-btn-wrapper up-loposition">
                            <button class="uploadBtn">Upload</button>
                            <input type="file" name="promo_code_file" accept=".xls,.xlsx"> 
                        </div>
                        <a href="#" class="text-primary text-right fw-bold f-12">
                            View File
                        </a>
                    </div> --}}
                    <p class="text-center orpromocodeline">
                        <span>Add Manually</span>
                    </p>
                    <table class="table datatbalennew">
                        <thead>
                            <tr> 
                                <th>S.No</th>
                                <th>Promocode</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="appendRow">
                            <tr>
                                <td>1</td>
                                <td>
                                    <input type="text" name="promo_codes[0][promo_code]" class="inputpromocode" required>
                                    <div class="errPromocode" id="errPromocode"></div>
                                </td> 
                                <td>
                                    <a id="addRow" href="javascript:void(0);" class="text-primary">
                                        <i class="fas fa-plus-square"></i>
                                    </a> 
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="message-section" id="message-section"></div>
                    <a type="button" class="btn btn-primary mt-3 px-5 submit_promo" id="submit_promo">Submit</a>
                </div>
            </form>
        </div>
    </div>
</div>