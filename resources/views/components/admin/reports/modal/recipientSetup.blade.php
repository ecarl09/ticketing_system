<div class="modal fade" id="priorityModal" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered mt-6" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-1 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                    <h6 class="mb-1" id="staticBackdropLabel">Recipient List</h6>
                </div>
                <div class="row p-2">

                    <input type="hidden" name="_token" id="csrf_status" value="{{Session::token()}}">
                    <input type="hidden" name="_method" id="method_delete" value="DELETE">
                    
                    <form class="row" id="recipientsForm">
                        @csrf

                        <div class="col-5">
                            <label class="sr-only" for="email">Email</label>
                            <input class="form-control" id="email" name="email" type="email"  placeholder="Recipient Email" />
                        </div>
                        <div class="col-5">
                            <select class="form-select" id="chapter" name="chapter">
                                <option value="" disabled="" selected="">Select a Chapter...</option>
                                <option >BUPHARCO</option>
                                <option>MAHESECO</option>
                                <option>MCDC</option>
                                <option>MMG Aklan</option>
                                <option>MMG Aklan Specialty Clinic</option>
                                <option>MMG Albay</option>
                                <option>MMG Bislig</option>
                                <option>MMG Bohol</option>
                                <option>MMG Bulacan</option>
                                <option>MMG Calapan</option>
                                <option>MMG CamSur</option>
                                <option>MMG Davao</option>
                                <option>MMG Dipolog</option>
                                <option>MMG Federation</option>
                                <option>MMG GenSan</option>
                                <option>MMG Masbate</option>
                                <option>MMG Metro Rizal</option>
                                <option>MMG Palawan</option>
                                <option>MMG Pasig</option>
                                <option>MMG Qatar</option>
                                <option>MMG Quezon</option>
                                <option>MMG Sorsogon</option>
                                <option>MMG Tacurong</option>
                                <option>MMG Tagum</option>
                                <option>MMG Zambales</option>
                                <option>PMPC</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" type="button" id="saveRecipient">Save</button>
                            </div>
                        </div>
                    </form>

                    <div class="col-12"><hr></div>

                    <div class="table-responsive scrollbar">
                        <table class="table table-sm" id="emailsListTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Chapter</th>
                                    <th class="text-end" scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="emailListTableContent">

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>