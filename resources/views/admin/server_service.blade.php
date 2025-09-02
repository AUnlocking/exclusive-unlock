@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card table-card">
            <div class="card-header service-card-header" style="padding: 12px 15px">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h5 class="mb-3 mb-sm-0">Server Service</h5>
                    <div class="d-flex gap-2">
                        <input type="search" class="form-control py-2" id="service-search" placeholder="Search"  />
                        <button type="button" class="btn btn-light-primary border-primary rounded py-2" data-bs-toggle="modal" data-bs-target="#addNewService"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
            </div>
            <div class="card-header selected-card-header" style="padding: 11px 15px; display:none;background:#dfe8f6; border-top-left-radius:10px; border-top-right-radius:10px">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h5 class="mb-3 mb-sm-0" id="selectedcount">Server Service List</h5>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-success service-active-btn">Active</button>
                        <button type="button" class="btn btn-danger service-inactive-btn">Inactive</button>
                        <button type="button" class="btn btn-danger service-delete-btn"><i class="fas fa-trash-alt"></i> <span class="d-none d-sm-inline-block">Delete</span></button>
                    </div>
                </div>
            </div>
            <div class="card-body pb-0">
                <div class="table-responsive ">
                    <table id="data-table" class="display table px-5">
                        <thead>
                            <tr>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="card-footer" style="padding: 12px 15px">
                <button type="button" class="btn btn-icon btn-light-primary ser-page-prev"><i class="fas fa-angle-left"></i></button>
                <button type="button" class="btn btn-icon btn-light-primary ser-page-next" style="margin-right: auto"><i class="fas fa-angle-right"></i></button>
            </div>
        </div>
    </div>
</div>
{{-- Canvas --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="service-details" aria-labelledby="servicedetailsLabel" style="width: 850px">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="announcementLabel">EDIT SERVICE</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <div class="d-block d-md-flex">
            <div class="customer-m-menu" id="menu">
                <button type="button" data-section="general" class="active btn rounded-0"><span>General</span></button>
                <button type="button" data-section="pricing" class="btn rounded-0"><span>Pricing</span></button>
                <button type="button" data-section="connect" class="btn rounded-0"><span>Connect</span></button>
                <button type="button" data-section="field" class="btn rounded-0"><span>Field</span></button>
                <button type="button" data-section="image" class="btn rounded-0"><span>Image</span></button>
                <button type="button" data-section="seo" class="btn rounded-0"><span>SEO</span></button>
                <button type="button" data-section="more" class="btn rounded-0"><span>More</span></button>
            </div>
            <div class="customer-m-menu-content" id="content" >
                <div id="general" class="section">
                    <div class="row mb-3">
                        <label for="service_status" class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            <select id="service_status" class="form-control">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="service_title" class="col-sm-3 col-form-label">Title</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="service_title" placeholder="Title" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="service_slug" class="col-sm-3 col-form-label">Slug</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="service_slug" placeholder="Slug" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="service_duration" class="col-sm-3 col-form-label">Duration</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="service_duration" placeholder="Duration" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="service_delivery" class="col-sm-3 col-form-label">Delivery Time</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="service_delivery" placeholder="Delivery Time" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="service_article" class="col-sm-3 col-form-label">Article</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="service_article" cols="30" rows="20" placeholder="Article"></textarea>
                        </div>
                        <input type="hidden" id="service_id" required />
                    </div>
                </div>
                <div id="connect" class="section">
                    <div class="api-assigned"></div>
                    <div class="card-header pb-0">
                        <ul class="nav nav-tabs analytics-tab border-bottom" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active m-0" id="api-tab" data-bs-toggle="tab" data-bs-target="#api-tab-pane" type="button" role="tab" aria-controls="api-tab-pane" aria-selected="true" >Connect Api</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="inventory-tab" data-bs-toggle="tab" data-bs-target="#inventory-tab-pane" type="button" role="tab" aria-controls="inventory-tab-pane" aria-selected="true">Connect Inventory</button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="api-tab-pane" role="tabpanel" aria-labelledby="api-tab" tabindex="0">
                            <ul class="list-group list-group-flush mt-3">
                                <div>
                                    <select id="api_list" class="form-control"></select>
                                </div>
                                <div class="card table-card mt-3 api-service-lists">
                                    <div class="card-header" style="padding: 12px 15px">
                                        <div class="d-sm-flex align-items-center justify-content-between">
                                            <h6 class="mb-3 mb-sm-0">API Service List</h6>
                                            <div class="d-flex gap-1">
                                                <input type="search" class="form-control py-2" id="remote-search" placeholder="Search" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pb-0">
                                        <div class="table-responsive ">
                                            <table id="remote-service-list" class="display table px-5">
                                                <thead>
                                                    <tr>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer" style="padding: 12px 15px">
                                        <button type="button" class="btn btn-icon btn-primary rem-ser-page-prev"><i class="fas fa-angle-left"></i></button>
                                        <button type="button" class="btn btn-icon btn-primary rem-ser-page-next" style="margin-right: auto"><i class="fas fa-angle-right"></i></button>
                                    </div>
                                </div>
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="inventory-tab-pane" role="tabpanel" aria-labelledby="inventory-tab-label" tabindex="0">
                            <ul class="list-group list-group-flush mt-3">
                                <form id="inventory-form">
                                    <div class="mb-3 d-flex" style="gap:10px">
                                        <div style="width:calc(100% - 110px)">
                                            <select class="form-control inventory-list" name="service_id" id="inventory-id" required>

                                            </select>
                                        </div>
                                        <div style="width:110px; text-align: center">
                                            <button class="btn btn-primary rounded" id="add-custom-price-button" type="submit" style="padding:11px; width:100%">
                                                <i class="fas fa-link"></i> Connect
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="field" class="section">
                        <div class="input-group mb-3" style="border-bottom: 2px dotted #bec8d0; padding-bottom:20px">
                            <input type="text" id="new-field-name" class="form-control" aria-describedby="button-addon2" placeholder="Field Name">
                            <input type="text" id="new-field-desc" class="form-control" aria-describedby="button-addon2" placeholder="Field Description">
                            <button class="btn btn-primary" id="add-new-field" type="button" style="border-top-right-radius:8px; border-bottom-right-radius:8px; width:100px"><i class="fas fa-plus"></i> Add</button>
                        </div>
                    <div class="custom-fields"></div>
                </div>
                <div id="pricing" class="section">
                    <div class="mb-4 pb-4 border-bottom">
                        <select name="" class="form-control" id="price_type">
                            <option value="fixed_profit">Fixed Profit</option>
                            <option value="fixed_price">Fixed Price</option>
                            <option value="percentage_base">Percentage Profit</option>
                        </select>
                    </div>
                    <div class="alert alert-danger fix-price-alert py-3 mb-4" role="alert" style="display: none">
                        Auto-updating the price is not supported for the API by this method, so be careful.
                    </div>
                    <div class="row mb-3">
                        <label for="base_price" class="col-sm-4 col-form-label">Purchase Price</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" class="form-control" id="base_price" placeholder="Price" required />
                                <div class="input-group-text justify-content-center" style="width: 60px">$</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="customer_profit" class="col-sm-4 col-form-label">Customer <span class="price_tag"></span></label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" class="form-control" id="customer_profit" placeholder="Price" required />
                                <div class="input-group-text justify-content-center price_icon" style="width: 60px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="reseller_profit" class="col-sm-4 col-form-label">Reseller <span class="price_tag"></span></label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" class="form-control" id="reseller_profit" placeholder="Price" required />
                                <div class="input-group-text justify-content-center price_icon" style="width: 60px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="distributor_profit" class="col-sm-4 col-form-label">Distributor <span class="price_tag"></span></label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" class="form-control" id="distributor_profit" placeholder="Price" required />
                                <div class="input-group-text justify-content-center price_icon" style="width: 60px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="webowner_profit" class="col-sm-4 col-form-label">Web Owner <span class="price_tag"></span></label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" class="form-control" id="webowner_profit" placeholder="Price" required />
                                <div class="input-group-text justify-content-center price_icon" style="width: 60px"></div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="alert alert-primary" role="alert">
                        <h4 class="alert-heading">Price Calculation</h4>
                        <div style="padding-bottom: 5px;margin-bottom:5px;"><b>Customer (base+profit):</b> <span class="customer-total-price float-end"></span></div>
                        <div style="padding-bottom: 5px;margin-bottom:5px;"><b>Reseller (base+profit):</b> <span class="reseller-total-price float-end"></span></div>
                        <div style="padding-bottom: 5px;margin-bottom:5px;"><b>Distributor (base+profit):</b> <span class="distributor-total-price float-end"></span></div>
                        <div style="padding-bottom: 5px;margin-bottom:5px;"><b>Web Owner (base+profit):</b> <span class="webowner-total-price float-end"></span></div>
                    </div> --}}
                </div>

                <div id="image" class="section"></div>

                <div id="seo" class="section">
                    <div class="row mb-3">
                        <label for="service_kw1" class="col-sm-3 col-form-label">Keyword 1</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="service_kw1" placeholder="Keyword 1" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="service_kw2" class="col-sm-3 col-form-label">Keyword 2</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="service_kw2" placeholder="Keyword 2" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="service_kw3" class="col-sm-3 col-form-label">Keyword 3</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="service_kw3" placeholder="Keyword 3" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="service_kw4" class="col-sm-3 col-form-label">Keyword 4</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="service_kw4" placeholder="Keyword 4" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="service_kw5" class="col-sm-3 col-form-label">Keyword 5</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="service_kw5" placeholder="Keyword 5" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="service_meta_desc" class="col-sm-3 col-form-label">Meta Description</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="service_meta_desc" cols="30" rows="10" placeholder="Meta Description"></textarea>
                        </div>
                    </div>
                </div>
                <div id="more" class="section">
                    <div class="row mb-3">
                        <label for="download_url" class="col-sm-3 col-form-label">Download URL</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="download_url" placeholder="Enter URL" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="login_url" class="col-sm-3 col-form-label">Login URL</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="login_url" placeholder="Enter URL" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="register_url" class="col-sm-3 col-form-label">Register URL</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="register_url" placeholder="Enter URL" required />
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <label for="" class="col-sm-3 col-form-label">Tag</label>
                        <div class="col-sm-9">
                            <div class="form-check mt-3">
                                <input class="form-check-input input-primary service-tag" type="checkbox" id="tag13" value="Process by" />
                                <label class="form-check-label" for="tag13">Process by (Auto detect API or Manual)</label>
                            </div>
                            <div class="form-check mt-3">
                                <input class="form-check-input input-primary service-tag" type="checkbox" id="tag12" value="Register an account before submit" />
                                <label class="form-check-label" for="tag12">Register an account before submit</label>
                            </div>
                            <div class="form-check mt-3">
                                <input class="form-check-input input-primary service-tag" type="checkbox" id="tag11" value="Working on business days only" />
                                <label class="form-check-label" for="tag11">Working on business days only</label>
                            </div>
                            <div class="form-check mt-2">
                                <input class="form-check-input input-primary service-tag" type="checkbox" id="tag1" value="Service available 24/7" />
                                <label class="form-check-label" for="tag1">Service available 24/7</label>
                            </div>
                            <div class="form-check mt-2">
                                <input class="form-check-input input-primary service-tag" type="checkbox" id="tag2" value="No refund for bad requests" />
                                <label class="form-check-label" for="tag2">No refund for bad requests</label>
                            </div>
                            <div class="form-check mt-2">
                                <input class="form-check-input input-primary service-tag" type="checkbox" id="tag3" value="No refund for wrong email" />
                                <label class="form-check-label" for="tag3">No refund for wrong email</label>
                            </div>
                            <div class="form-check mt-2">
                                <input class="form-check-input input-primary service-tag" type="checkbox" id="tag4" value="No refund for wrong username" />
                                <label class="form-check-label" for="tag4">No refund for wrong username</label>
                            </div>
                            <div class="form-check mt-2">
                                <input class="form-check-input input-primary service-tag" type="checkbox" id="tag5" value="No refund for wrong IMEI" />
                                <label class="form-check-label" for="tag5">No refund for wrong IMEI</label>
                            </div>
                            <div class="form-check mt-2">
                                <input class="form-check-input input-primary service-tag" type="checkbox" id="tag6" value="No refund for wrong SN" />
                                <label class="form-check-label" for="tag6">No refund for wrong SN</label>
                            </div>
                            <div class="form-check mt-2">
                                <input class="form-check-input input-primary service-tag" type="checkbox" id="tag7" value="No refund for wrong serial number" />
                                <label class="form-check-label" for="tag7">No refund for wrong serial number</label>
                            </div>
                            <div class="form-check mt-2">
                                <input class="form-check-input input-primary service-tag" type="checkbox" id="tag8"  />
                                <label class="form-check-label" for="tag8">Refund available if not work</label>
                            </div>
                            <div class="form-check mt-2">
                                <input class="form-check-input input-primary service-tag" type="checkbox" id="tag9" value="Unlock guaranteed" />
                                <label class="form-check-label" for="tag9">Unlock guaranteed</label>
                            </div>
                            <div class="form-check mt-2">
                                <input class="form-check-input input-primary service-tag" type="checkbox" id="tag10" value="No cancellation allowed" />
                                <label class="form-check-label" for="tag10">No cancellation allowed</label>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="offcanvas-footer">
        <button type="button" class="btn btn-primary rounded-0 w-100" id="update-service" style="height: 42px">
            <i class="fas fa-check-circle"></i> Update
            <span class="spinner-border spinner-border-sm d-none" id="loadingSpinnerSuccess" role="status"></span>
        </button>
    </div>
</div>
{{-- Thumbnail Modal --}}
<div class="modal fade modal-animate" id="addImg" tabindex="-1" aria-labelledby="addIMG" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 950px;">
        <div class="modal-content">
            <div class="modal-header gap-2 overflow-auto">
                <div>
                    <form id="uploadForm" enctype="multipart/form-data">
                        @csrf
                        <label for="uploadimg" class="media-upload-btn"><i class="fas fa-cloud-upload-alt"></i></label>
                        <label class="media-upload-loader"><span class="spinner-border spinner-border-sm" id="loadingSpinnerSuccess" role="status"></span></label>
                        <input type="file" class="form-control py-2" name="image" id="uploadimg" accept="image/*" style="width: 150px; display: none">
                    </form>
                </div>
                <input type="search" class="form-control py-2 media-search" placeholder="Search" style="width: 200px">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="height: 500px; overflow:auto">
                <div class="table-responsive " style="border: 1px solid #efefef">
                    <table id="modal-img-list" class="display table px-5">
                        <thead >
                            <tr>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-icon btn-primary page-prev"><i class="fas fa-angle-left"></i></button>
                <button type="button" class="btn btn-icon btn-primary page-next" style="margin-right: auto"><i class="fas fa-angle-right"></i></button>
                <div class="show-preview"></div>
                <button type="button" class="btn btn-light-primary selectIMG" style="display: none"><i class="fas fa-check-circle"></i> Select</button>
            </div>
        </div>
    </div>
</div>
{{-- ACTIVE - Modal --}}
<div class="modal fade modal-animate" id="confirmActive" tabindex="-1" aria-labelledby="confirmActiveLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="confirmActiveLabel">Are you sure to active?</h5>
                    <div class="modal-selected-count"></div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 250px; overflow:auto"><ol id="activeServiceList"></ol></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-success" id="confirmActiveAction"><i class="fas fa-check-circle"></i> Active</button>
            </div>
        </div>
    </div>
</div>
{{-- INACTIVE - Modal --}}
<div class="modal fade modal-animate" id="confirmInactive" tabindex="-1" aria-labelledby="confirmInactiveLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="confirmActiveLabel">Are you sure to inactive?</h5>
                    <div class="modal-selected-count"></div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 250px; overflow:auto"><ol id="inactiveServiceList"></ol></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-danger" id="confirmInactiveAction"><i class="fas fa-ban"></i> Inactive</button>
            </div>
        </div>
    </div>
</div>
{{-- Delete - Modal --}}
<div class="modal fade modal-animate" id="confirmDelete" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="confirmDeleteLabel">Are you sure to delete?</h5>
                    <div class="modal-selected-count"></div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 250px; overflow:auto"><ol id="deleteServiceList"></ol></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-danger" id="confirmDeleteAction"><i class="fas fa-trash-alt"></i> Delete</button>
            </div>
        </div>
    </div>
</div>
{{-- Modal --}}
<div class="modal fade modal-animate" id="addNewService" tabindex="-1" aria-labelledby="addNewService" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="new-service-form">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewServiceLabel">Add new server service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="new-service-name" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="new-service-name" placeholder="Service Name" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="new-service-duration" class="col-sm-3 col-form-label">Duration</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="new-service-duration" placeholder="1 Year" required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="new-service-delivery-time" class="col-sm-3 col-form-label">Delivery Time</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="new-service-delivery-time" placeholder="1-5 Minute" required />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="new-update-button" type="submit">
                        <i class="fas fa-check-circle"></i> Add
                    </button>
                    <button class="btn btn-primary lh-1" id="new-loader-button" type="button" style="display:none;padding:11px" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<svg xmlns="http://www.w3.org/2000/svg" style="display: none">
    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path>
    </symbol>
    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path>
    </symbol>
    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
    </symbol>
</svg>

@endsection
@section('footer_script')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // IF OFFCANVAS HIDE THEN CLEAR ALL DATA
        $(document).ready(function() {
            $('#service-details').on('hide.bs.offcanvas', function () {
                $('#menu button').removeClass('active');
                var section = $('[data-section="general"]');
                section.addClass('active');
                $('#new-field-name').val('');
                $('#new-field-desc').val('');
                $('#image').html(``);
            });
            $('#addImg').on('hidden.bs.modal', function () {
                $('.show-preview').html(``);
                $('.selectIMG').hide();
                $('.media-search').val('');
            });
        });
        // Service List - Data Table
        var table = $('#data-table').DataTable({
            processing: false,
            serverSide: true,
            lengthChange: false,
            info: false,
            footer: false,
            ajax: {
                url: '{{ route('fetch_server_service') }}',
                type: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                    $('#select-all').prop('checked', false);
                    $('table > thead').css('background-color', '');
                    $('.service-card-header').show();
                    $('.selected-card-header').hide();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
            },
            columns: [
                {
                    data: null,
                    title: '<input type="checkbox" id="select-all">',
                    className: 'text-left check-box',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `<input type="checkbox" class="row-checkbox" data-id="${row.id}" data-title="${row.title}" >`;
                    }
                },
                {
                    data: 'thumbnail',
                    title: 'LOGO',
                    className: 'text-left',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        return data ? `<img src="${data}" alt="Thumbnail" height="28" width="42" style="max-width: 100%;" class="rounded">` : 'No Image';
                    }
                },
                { data: 'title', title: 'SERVICE NAME', className: 'text-left', orderable: true, searchable: true },
                {
                    data: 'original_price',
                    title: 'BASE PRICE',
                    className: 'text-left',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        if (data === null || data === '' || isNaN(data)) {
                            return '-';
                        }
                        const balanceValue = parseFloat(data);
                        const displayValue = '$ ' + balanceValue.toFixed(2);
                        return displayValue;
                    }
                },
                { data: 'sells', title: 'SELLS', className: 'text-left', orderable: true, searchable: true, render: function(data) {
                    return '<i class="fas fa-chart-line"></i> ' + data;
                }},
                { data: 'views', title: 'VIEWS', className: 'text-left', orderable: true, searchable: true, render: function(data) {
                    return '<i class="fas fa-eye"></i> ' + data;
                }},
                { data: 'process_type', title: 'PROCESS', className: 'text-left', orderable: true, searchable: true },
                {
                    data: 'status',
                    title: '<span style="float:right">STATUS</span>',
                    className: 'text-left',
                    orderable: true,
                    searchable: true,
                    render: function(data) {
                        if (data === 'Active') {
                            return '<span class="badge bg-light-success fs-6 float-end">Active</span>';
                        } else if (data === 'Inactive') {
                            return '<span class="badge bg-light-danger fs-6 float-end">Inactive</span>';
                        }
                        return '<span class="badge bg-light-danger fs-6 float-end">Inactive</span>';
                    }
                },
            ],
            order: [[2, 'asc']],
            pageLength: 100,
            language: {
                search: "",
                searchPlaceholder: "Search...",
                lengthMenu: "_MENU_",
                paginate: {
                    previous: "<",
                    next: ">"
                }
            },
            initComplete: function () {
                $('.dataTables_length select').addClass('form-control ');
                $('.table-card .card-body .table tr th:first-child').css({
                    'padding-left': '17px',
                });
            },
            createdRow: function(row, data, dataIndex) {
                $('td', row).on('click', function(event) {
                    if ($(event.target).is('input[type="checkbox"], .check-box')) {
                        return;
                    }
                    loadServiceDetails(data.id);
                });
            },
            drawCallback: function(settings) {
                var api = this.api();
                var totalEntries = api.page.info().recordsTotal;
                $('.card-header h5').text('Server Service - ' + totalEntries);
                $('#server-count').text(totalEntries);
                $('.dataTables_wrapper .dataTables_paginate').hide();
                $('.dataTables_scrollBody').css('border-bottom', '0');
            }
        });
        // Add Custom Paginate for service data table
        $('.ser-page-prev').on('click', function() {
            table.page('previous').draw('page');
        });
        $('.ser-page-next').on('click', function() {
            table.page('next').draw('page');
        });
        // Seraching - Service datat table
        $('#service-search').on('input', function() {
            var searchValue = this.value;
            if (searchValue.length === 0) {
                table.search('').draw();
            } else {
                table.search(searchValue).draw();
            }
        });
        // Service Data table - Handle "Select All" checkbox
        $('#select-all').on('click', function() {
            var isChecked = $(this).prop('checked');
            $('.row-checkbox').prop('checked', isChecked);
            updateTitleBackground();
            updateRowBackground();
        });
        $('#data-table tbody').on('change', '.row-checkbox', function() {
            var selectedCount = $('.row-checkbox:checked').length;
            var totalRows = $('.row-checkbox').length;
            if (selectedCount === totalRows) {
                $('#select-all').prop('checked', true);
            } else {
                $('#select-all').prop('checked', false);
            }
            updateTitleBackground();
            updateRowBackground();
        });
        function updateTitleBackground() {
            var selectedCount = $('.row-checkbox:checked').length;
            if (selectedCount > 0) {
                $('.table > thead').css('background-color', 'rgb(234 246 242)');
                $('.service-card-header').hide();
                $('.selected-card-header').show();
                $('#selectedcount').html(`${selectedCount} selected`);
            } else {
                $('.table > thead').css('background-color', '');
                $('.service-card-header').show();
                $('.selected-card-header').hide();
            }
        }
        function updateRowBackground() {
            $('.row-checkbox:checked').each(function() {
                $(this).closest('tr').css('background-color', 'rgb(234 246 242)');
            });
            $('.row-checkbox:not(:checked)').each(function() {
                $(this).closest('tr').css('background-color', '');
            });
        }
        // Function to reload Service DataTable
        function reloadDataTable() {
            table.ajax.reload(null, false);
        }
        // Service Activate
        $('.service-active-btn').on('click', function(){
            var serviceID = [];
            var serviceTitle = [];
            $('.row-checkbox:checked').each(function() {
                var rowId = $(this).data('id');
                var title = $(this).data('title');
                if (rowId !== undefined && rowId !== null) {
                    serviceID.push(rowId);
                }
                if (title !== undefined && title !== null) {
                    serviceTitle.push(title);
                }
            });
            var listItems = serviceTitle.map(function(title) {
                return `<li style="margin-bottom:10px">${title}</li>`;
            }).join('');
            var selectedItemsCount = serviceTitle
            .map(function(title) {return title;}).length;
            $('.modal-selected-count').html(selectedItemsCount + ' item selected');
            $('#activeServiceList').html(listItems);
            $('#confirmActive').modal('show');
            if (serviceID.length > 0) {
                $('#confirmActiveAction').off('click').on('click', function(){
                    $.ajax({
                        url: '{{ route("service_active") }}',
                        type: 'POST',
                        data: JSON.stringify({ serviceID: serviceID }),
                        contentType: 'application/json',
                        beforeSend: function() {
                            $('.top-loader').show();
                        },
                        complete: function() {
                            $('.top-loader').hide();
                        },
                        success: function(response) {
                            new Notify({
                                status: `${response.success ? 'success' : 'error'}`,
                                text: response.message,
                                effect: 'fade',
                                speed: 300,
                                showIcon: true,
                                showCloseButton: false,
                                autoclose: true,
                                autotimeout: 3000,
                                position: 'left bottom',
                                type: 'filled',
                            });
                            if(response.success){
                                $('#select-all').prop('checked', false);
                                $('#data-table thead').css('background-color', '');
                                $('.service-card-header').show();
                                $('.selected-card-header').hide();
                                $('#confirmActive').modal('hide');
                                reloadDataTable();
                            }
                        },
                        error: function(xhr, status, error) {
                            $('#response').html('<p>An error occurred while uploading the service.</p>');
                        }
                    });
                })
            } else {
                alert('No service selected');
            }
        });
        // Service Inactive
        $('.service-inactive-btn').on('click', function(){
            var serviceID = [];
            var serviceTitle = [];
            $('.row-checkbox:checked').each(function() {
                var rowId = $(this).data('id');
                var title = $(this).data('title');
                if (rowId !== undefined && rowId !== null) {
                    serviceID.push(rowId);
                }
                if (title !== undefined && title !== null) {
                    serviceTitle.push(title);
                }
            });
            var listItems = serviceTitle.map(function(title) {
                return `<li style="margin-bottom:10px">${title}</li>`;
            }).join('');
            var selectedItemsCount = serviceTitle
            .map(function(title) {return title;}).length;
            $('.modal-selected-count').html(selectedItemsCount + ' item selected');
            $('#inactiveServiceList').html(listItems);
            $('#confirmInactive').modal('show');
            if (serviceID.length > 0) {
                $('#confirmInactiveAction').off('click').on('click', function(){
                    $.ajax({
                        url: '{{ route("service_inactive") }}',
                        type: 'POST',
                        data: JSON.stringify({ serviceID: serviceID }),
                        contentType: 'application/json',
                        beforeSend: function() {
                            $('.top-loader').show();
                        },
                        complete: function() {
                            $('.top-loader').hide();
                        },
                        success: function(response) {
                            new Notify({
                                status: `${response.success ? 'success' : 'error'}`,
                                text: response.message,
                                effect: 'fade',
                                speed: 300,
                                showIcon: true,
                                showCloseButton: false,
                                autoclose: true,
                                autotimeout: 3000,
                                position: 'left bottom',
                                type: 'filled',
                            });
                            if(response.success){
                                $('#select-all').prop('checked', false);
                                $('#data-table thead').css('background-color', '');
                                $('.service-card-header').show();
                                $('.selected-card-header').hide();
                                $('#confirmInactive').modal('hide');
                                reloadDataTable();
                            }
                        },
                        error: function(xhr, status, error) {
                            $('#response').html('<p>An error occurred while uploading the service.</p>');
                        }
                    });
                })
            } else {
                alert('No service selected');
            }
        });
        // Service Delete
        $('.service-delete-btn').on('click', function(){
            var serviceID = [];
            var serviceTitle = [];
            $('.row-checkbox:checked').each(function() {
                var rowId = $(this).data('id');
                var title = $(this).data('title');
                if (rowId !== undefined && rowId !== null) {
                    serviceID.push(rowId);
                }
                if (title !== undefined && title !== null) {
                    serviceTitle.push(title);
                }
            });
            var listItems = serviceTitle.map(function(title) {
                return `<li style="margin-bottom:10px">${title}</li>`;
            }).join('');
            var selectedItemsCount = serviceTitle
            .map(function(title) {return title;}).length;
            $('.modal-selected-count').html(selectedItemsCount + ' item selected');
            $('#deleteServiceList').html(listItems);
            $('#confirmDelete').modal('show');
            if (serviceID.length > 0) {
                $('#confirmDeleteAction').off('click').on('click', function(){
                    $.ajax({
                        url: '{{ route("service_delete") }}',
                        type: 'POST',
                        data: JSON.stringify({ serviceID: serviceID }),
                        contentType: 'application/json',
                        beforeSend: function() {
                            $('.top-loader').show();
                        },
                        complete: function() {
                            $('.top-loader').hide();
                        },
                        success: function(response) {
                            new Notify({
                                status: `${response.success ? 'success' : 'error'}`,
                                text: response.message,
                                effect: 'fade',
                                speed: 300,
                                showIcon: true,
                                showCloseButton: false,
                                autoclose: true,
                                autotimeout: 3000,
                                position: 'left bottom',
                                type: 'filled',
                            });
                            if(response.success){
                                $('#select-all').prop('checked', false);
                                $('#data-table thead').css('background-color', '');
                                $('.service-card-header').show();
                                $('.selected-card-header').hide();
                                $('#confirmDelete').modal('hide');
                                reloadDataTable();
                            }
                        },
                        error: function(xhr, status, error) {
                            $('#response').html('<p>An error occurred while deleting the service.</p>');
                        }
                    });
                })
            } else {
                alert('No service selected');
            }
        });
        // Calculate Customer + Reseller Total Price
        function updateTotalPrice() {
            var basePrice = parseFloat($('#base_price').val()) || 0;
            var customerProfit = parseFloat($('#customer_profit').val()) || 0;
            var resellerProfit = parseFloat($('#reseller_profit').val()) || 0;
            var distributorProfit = parseFloat($('#distributor_profit').val()) || 0;
            var webownerProfit = parseFloat($('#webowner_profit').val()) || 0;
            var customerTotalPrice = (basePrice + customerProfit).toFixed(2);
            var resellerTotalPrice = (basePrice + resellerProfit).toFixed(2);
            var distributorTotalPrice = (basePrice + distributorProfit).toFixed(2);
            var webownerTotalPrice = (basePrice + webownerProfit).toFixed(2);
            $('.customer-total-price').text('$' + customerTotalPrice);
            $('.reseller-total-price').text('$' + resellerTotalPrice);
            $('.distributor-total-price').text('$' + distributorTotalPrice);
            $('.webowner-total-price').text('$' + webownerTotalPrice);
        }
        $('#base_price, #customer_profit, #reseller_profit, #distributor_profit, #webowner_profit').on('input', function() {
            this.value = this.value.replace(/[^0-9.]/g, '');
            if ((this.value.match(/\./g) || []).length > 1) {
                this.value = this.value.replace(/\.(?=.*\.)/, '');
            }
            if (this.value.length > 8) {
                this.value = this.value.slice(0, 8);
            }
            updateTotalPrice();
        });
        // Show offcanvas with service data
        function loadServiceDetails(serviceID) {
            initMenu(serviceID);
            $.ajax({
                url: '/admin/fetch/server-details/' + serviceID,
                method: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                success: function(response) {
                    $('#service-details').offcanvas('show');
                    $('#service_id').val(response.service.id);
                    $('.service-name').text(response.service.title);
                    $('#service_status').val(response.service.status);
                    $('#service_title').val(response.service.title);
                    $('#service_slug').val(response.service.slug);
                    $('#service_duration').val(response.service.duration);
                    $('#service_delivery').val(response.service.delivery_time);
                    $('#service_article').val(response.service.article);
                    $('#price_type').val(response.service.price_type);
                    $('#base_price').val(response.service.original_price);
                    $('#customer_profit').val(response.service.customer_profit_amount);
                    $('#reseller_profit').val(response.service.reseller_profit_amount);
                    $('#distributor_profit').val(response.service.distributor_profit_amount);
                    $('#webowner_profit').val(response.service.webowner_profit_amount);
                    $('#webowner_profit').val(response.service.webowner_profit_amount);
                    $('#service_kw1').val(response.service.kw1);
                    $('#service_kw2').val(response.service.kw2);
                    $('#service_kw3').val(response.service.kw3);
                    $('#service_kw4').val(response.service.kw4);
                    $('#service_kw5').val(response.service.kw5);
                    $('#service_meta_desc').val(response.service.meta_description);
                    $('#download_url').val(response.service.tool_download);
                    $('#login_url').val(response.service.login_url);
                    $('#register_url').val(response.service.register_url);

                    if (response.api && Array.isArray(response.api)) {
                        let apiOptions = '<option value="0">Choose API</option>';
                        apiOptions += response.api.map(api => {
                            return `<option value="${api.id}">${api.api_name}</option>`;
                        }).join('');
                        $('#api_list').html(apiOptions);
                    }

                    if (response.inventory && Array.isArray(response.inventory)) {
                        let inventoryOptions = '<option value="">Choose Inventory</option>';
                        inventoryOptions += response.inventory.map(inventory => {
                            return `<option value="${inventory.id}">${inventory.name}</option>`;
                        }).join('');
                        $('.inventory-list').html(inventoryOptions);
                    }

                    $('.service-tag').prop('checked', false);
                    if (response.service.service_tags) {
                        let tags = response.service.service_tags.split(',').map(tag => tag.trim());
                        $('.service-tag').each(function() {
                            if (tags.includes($(this).val())) {
                                $(this).prop('checked', true);
                            } else {
                                $(this).prop('checked', false);
                            }
                        });
                    };
                    $('.api-service-lists').hide();
                    updateTotalPrice();
                    priceType(response.service.price_type);
                },
                error: function(xhr, status, error) {
                    alert('Error loading details: ' + error);
                },
            });
        }
        // MENU FUNCTION INITIALIZE
        function initMenu(serviceID) {
            $('.section').hide();
            $('#general').show();
            $('#menu button').off('click').on('click', function() {
                const section = $(this).data('section');
                $('.section').hide();
                $('#menu button').removeClass('active');
                $(this).addClass('active');
                $('#' + section).show();
                if (section === 'field') {fetchField(serviceID);}
                if (section === 'connect') {assignedAPI(serviceID);}
                if (section === 'image') {loadIMG(serviceID);}
            });
        }

        // ON CHANGE PRICING TYPE
        $('#price_type').on('change', function(){
            var type = $(this).val();
            priceType(type);
            $('#customer_profit').val('')
            $('#reseller_profit').val('')
            $('#distributor_profit').val('')
            $('#webowner_profit').val('')
            if(type == 'fixed_price'){
                $('.fix-price-alert').show();
            }
            else{
                $('.fix-price-alert').hide();
            }
        })
        // PRICE TYPE PROCESS
        function priceType(type){
            if(type == 'fixed_profit'){
                $('.price_tag').text('Profit');
                $('.price_icon').text('$');
            }
            else if(type == 'fixed_price'){
                $('.price_tag').text('Price');
                $('.price_icon').text('$');
            }
            else{
                $('.price_tag').text('Percentage');
                $('.price_icon').text('%');
            }
        }


        // START - MENU FIELD
        function fetchField(serviceID) {
            $.ajax({
                url: '/admin/fetch/service-field/' + serviceID,
                type: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                    $('.custom-fields').html(`
                         <span class="placeholder col-3 rounded" style="background:#eaeffc"></span> <span class="placeholder col-3 rounded" style="background:#eaeffc"></span> <span class="placeholder col-2 rounded" style="background:#eaeffc; float:right"></span> <br>
                         <span class="placeholder col-3 rounded" style="background:#eaeffc"></span> <span class="placeholder col-3 rounded" style="background:#eaeffc"></span> <span class="placeholder col-2 rounded" style="background:#eaeffc; float:right"></span> <br>
                         <span class="placeholder col-3 rounded" style="background:#eaeffc"></span> <span class="placeholder col-3 rounded" style="background:#eaeffc"></span> <span class="placeholder col-2 rounded" style="background:#eaeffc; float:right"></span> <br>
                         <span class="placeholder col-3 rounded" style="background:#eaeffc"></span> <span class="placeholder col-3 rounded" style="background:#eaeffc"></span> <span class="placeholder col-2 rounded" style="background:#eaeffc; float:right"></span> <br>
                         <span class="placeholder col-3 rounded" style="background:#eaeffc"></span> <span class="placeholder col-3 rounded" style="background:#eaeffc"></span> <span class="placeholder col-2 rounded" style="background:#eaeffc; float:right"></span> <br>
                    `);
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                success: function(response) {
                    if (response.success) {
                        let fieldsHtml = '';
                        response.fields.forEach(function(field) {
                            fieldsHtml += `
                                <div class="input-group mb-3" data-field-id="${field.id}">
                                    <input type="text" class="form-control" name="fields[${field.id}][name]" placeholder="Name" value="${field.name}">
                                    <input type="text" class="form-control" name="fields[${field.id}][desc]" placeholder="Description" value="${field.desc !== null && field.desc !== undefined ? field.desc : ''}">
                                    <button class="btn btn-outline-secondary edit-button" type="button">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-outline-secondary delete-button" type="button" style="border-top-right-radius:8px; border-bottom-right-radius:8px;">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            `;
                        });
                        $('.custom-fields').html(fieldsHtml);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error synchronizing API: ' + error);
                },
            });
        }
        // END - MENU FIELD

        // ADD NEW SERVICE FIELD
        $(document).ready(function() {
            $('#add-new-field').on('click', function() {
                var formData = {
                    new_field: $('#new-field-name').val(),
                    new_desc: $('#new-field-desc').val(),
                    service_id: $('#service_id').val(),
                };
                if (!formData.new_field || !formData.service_id) {
                    new Notify({
                        status: 'error',
                        text: 'Fields name is required.',
                        effect: 'fade',
                        speed: 300,
                        showIcon: true,
                        showCloseButton: false,
                        autoclose: true,
                        autotimeout: 3000,
                        position: 'left bottom',
                        type: 'filled',
                    });
                    return false;
                }
                $.ajax({
                    url: '/admin/add/new-field',
                    method: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $('.top-loader').show();
                    },
                    complete: function() {
                        $('.top-loader').hide();
                    },
                    success: function(response) {
                        new Notify({
                            status: response.success ? 'success' : 'error',
                            text: response.message,
                            effect: 'fade',
                            speed: 300,
                            showIcon: true,
                            showCloseButton: false,
                            autoclose: true,
                            autotimeout: 3000,
                            position: 'left bottom',
                            type: 'filled',
                        });
                        if (response.success) {
                            var serviceID = $('#service_id').val();
                            fetchField(serviceID);
                            $('#new-field-name').val('');
                            $('#new-field-desc').val('');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error occurred while adding..', error);
                    }
                });
            });
        });


        // START - DELETE SERVICE FIELD
        $(document).on('click', '.delete-button', function() {
            var fieldId = $(this).closest('.input-group').data('field-id');
            if (confirm('Are you sure to delete this field?')) {
                deleteField(fieldId);
            }
        });
        function deleteField(fieldId) {
            $.ajax({
                url: '/admin/del/service-field/' + fieldId,
                type: 'DELETE',
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                success: function(response) {
                    new Notify({
                        status: response.success ? 'success' : 'error',
                        text: response.message,
                        effect: 'fade',
                        speed: 300,
                        showIcon: true,
                        showCloseButton: false,
                        autoclose: true,
                        autotimeout: 3000,
                        position: 'left bottom',
                        type: 'filled',
                    });
                    if (response.success) {
                        var serviceID = $('#service_id').val();
                        fetchField(serviceID);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error deleting field: ' + error);
                }
            });
        }
        // END - DELETE SERVICE FIELD

        // START - UPDATE SERVICE FIELDS
        $(document).on('click', '.edit-button', function() {
            var fieldId = $(this).closest('.input-group').data('field-id');
            var updatedName = $(this).closest('.input-group').find('input[name="fields[' + fieldId + '][name]"]').val();
            var updatedDesc = $(this).closest('.input-group').find('input[name="fields[' + fieldId + '][desc]"]').val();
            if (updatedName.trim() === "") {
                new Notify({
                    status: 'error',
                    text: 'Field name is required.',
                    effect: 'fade',
                    speed: 300,
                    showIcon: true,
                    showCloseButton: false,
                    autoclose: true,
                    autotimeout: 3000,
                    position: 'left bottom',
                    type: 'filled',
                });
                return;
            }
            updateField(fieldId, updatedName, updatedDesc);
        });
        function updateField(fieldId, updatedName, updatedDesc) {
            $.ajax({
                url: '/admin/update/service-field/' + fieldId,
                type: 'PUT',
                data: {
                    name: updatedName,
                    description: updatedDesc
                },
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                success: function(response) {
                    new Notify({
                        status: response.success ? 'success' : 'error',
                        text: response.message,
                        effect: 'fade',
                        speed: 300,
                        showIcon: true,
                        showCloseButton: false,
                        autoclose: true,
                        autotimeout: 3000,
                        position: 'left bottom',
                        type: 'filled',
                    });
                    if (response.success) {
                        var serviceID = $('#service_id').val();
                        fetchField(serviceID);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error updating field: ' + error);
                }
            });
        }
        // END - UPDATE SERVICE FIELDS

        // START - FETCH REMOTE SERVICE LIST
        $('#api_list').on('change', function() {
            let ApiId = $(this).val();
            fetchRemoteService(ApiId);
        });
        function fetchRemoteService(ApiId){
            if ($.fn.dataTable.isDataTable('#remote-service-list')) {
                $('#remote-service-list').DataTable().clear().destroy();
            }
            $('#remote-service-list').empty();
            var table = $('#remote-service-list').DataTable({
                processing: false,
                serverSide: true,
                lengthChange: false,
                info: false,
                footer: false,
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                ajax: {
                    url: '/admin/fetch/remote-service/' + ApiId,
                    type: 'GET',
                    beforeSend: function() {
                        $('.top-loader').show();
                    },
                    complete: function() {
                        $('.top-loader').hide();
                    },
                },
                columns: [
                    {
                        data: 'added',
                        title: 'ADDED',
                        className: 'text-left',
                        orderable: false,
                        render: function(data, type, row) {
                            return '<span class="badge bg-success"><i class="fas fa-plus"></i> ADD</span>';
                        }

                    },
                    {
                        data: 'SERVICETYPE',
                        title: 'TYPE',
                        className: 'text-left',
                        orderable: false,
                        render: function(data, type, row) {
                            return data ? data : "-";
                        }
                    },
                    { data: 'CREDIT', title: 'PRICE', className: 'text-left', orderable: false },
                    { data: 'SERVICENAME', title: 'SERVICE NAME', className: 'text-left', orderable: false },
                ],
                pageLength: 9,
                language: {
                    paginate: {
                        previous: "<",
                        next: ">"
                    }
                },
                createdRow: function(row, data, dataIndex) {
                    $('td', row).on('click', function() {
                        setRemoteService(data.id, data.SERVICENAME);
                    });
                },
                drawCallback: function(settings) {
                    var api = this.api();
                    var totalRecords = api.page.info().recordsTotal;
                    if (totalRecords === 0) {
                        $('.dataTables_wrapper .dataTables_paginate').hide();
                        $('.dataTables_wrapper .dataTables_info').hide();
                        $('.api-service-lists').hide();
                    } else {
                        $('.dataTables_wrapper .dataTables_paginate').show();
                        $('.dataTables_wrapper .dataTables_info').show();
                        $('.api-service-lists').show();
                    }
                    $('.dataTables_wrapper .dataTables_paginate').hide();
                }
            });
            $('#remote-search').on('input', function() {
                var searchValue = this.value;
                if (searchValue.length === 0) {
                    table.search('').draw();
                } else {
                    table.search(searchValue).draw();
                }
            });
            $('.rem-ser-page-prev').on('click', function() {
                table.page('previous').draw('page');
            });
            $('.rem-ser-page-next').on('click', function() {
                table.page('next').draw('page');
            });
        }
        // END - FETCH REMOTE SERVICE LIST

        // START - ASSIGNED API
        function assignedAPI(serviceID){
            $('.api-assigned').html(``);
            $.ajax({
                url: '/admin/fetch-assigned-api/' + serviceID,
                type: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                    $('.api-assigned').html(`
                        <div class="alert mb-4" role="alert" style="height: 120px; border: 1px solid #e7eaee">
                            <h4 class="alert-heading"><span class="placeholder col-3 rounded" style="background:#eaeffc"></span></h4>
                            <p>
                                <span class="placeholder col-3 rounded" style="background:#eaeffc"></span> <br>
                                <span class="placeholder col-3 rounded" style="background:#eaeffc"></span> <span class="placeholder col-3 rounded" style="background:#eaeffc"></span>
                            </p>
                        </div>
                    `);
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                success: function(response) {
                    if (response.success) {
                        // Ensure response.service exists and api_id is available
                        if(response.connected == 'Manual'){
                            $('.api-assigned').html(`
                                <div class="alert alert-warning mb-4" role="alert" style="height: 120px; display:flex; align-items:center; justify-content:center">
                                    <h4 class="text-muted">
                                        Nothing conected!
                                    </h4>
                                </div>
                            `);
                        }
                        else{
                            $('.api-assigned').html(`
                                <div class="alert alert-success mb-4" role="alert" style="height: 120px">
                                    <h4 class="alert-heading">Conected with <span class="badge btn-light-danger float-end unlink-api" style="cursor:pointer"><i class="fas fa-unlink"></i></span></h4>
                                    <p>
                                        ${response.connected}: ${response.connectedName} <br>
                                        ${response.reference}
                                    </p>
                                </div>
                            `);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error updating field: ' + error);
                }
            });
        }
        // END - ASSIGNED API

        // START - SET REMOTE SERVICE
        function setRemoteService(remoteID, remoteName) {
            var confirmAction = confirm("Are you sure to connect with this service?\n" + remoteName);
            if (confirmAction) {
                $.ajax({
                    url: '/admin/set-remote-service/' + remoteID,
                    type: 'POST',
                    data: {
                        serviceID: $('#service_id').val(),
                    },
                    beforeSend: function() {
                        $('.top-loader').show();
                    },
                    complete: function() {
                        $('.top-loader').hide();
                    },
                    success: function(response) {
                        new Notify({
                            status: response.success ? 'success' : 'error',
                            text: response.message,
                            effect: 'fade',
                            speed: 300,
                            showIcon: true,
                            showCloseButton: false,
                            autoclose: true,
                            autotimeout: 3000,
                            position: 'left bottom',
                            type: 'filled',
                        });
                        if (response.success) {
                            assignedAPI(response.serviceId);
                            reloadDataTable();
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error updating field: ' + error);
                    }
                });
            }
        }
        // END - SET REMOTE SERVICE

        // START - UNLINK API
        $(document).on('click', '.unlink-api', function() {
            var serviceID = $('#service_id').val();
            var confirmAction = confirm('Are you sure to disconnect?');
            if (confirmAction) {
                $.ajax({
                    url: '/admin/unlick-api/' + serviceID,
                    type: 'GET',
                    data: {
                        serviceID: $('#service_id').val(),
                    },
                    beforeSend: function() {
                        $('.top-loader').show();
                    },
                    complete: function() {
                        $('.top-loader').hide();
                    },
                    success: function(response) {
                        new Notify({
                            status: response.success ? 'success' : 'error',
                            text: response.message,
                            effect: 'fade',
                            speed: 300,
                            showIcon: true,
                            showCloseButton: false,
                            autoclose: true,
                            autotimeout: 3000,
                            position: 'left bottom',
                            type: 'filled',
                        });
                        if (response.success) {
                            assignedAPI(serviceID);
                            reloadDataTable();
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error updating field: ' + error);
                    }
                });
            }
        });
        // END - UNLINK API

        // Add Inventory
        $(document).ready(function() {
            $('#inventory-form').on('submit', function(event) {
                event.preventDefault();
                var formData = {
                    inventoryId: $('#inventory-id').val(),
                    serviceId: $('#service_id').val(),
                    _token: '{{ csrf_token() }}'
                };
                let missingFields = [];
                if (!formData.inventoryId) {
                    missingFields.push('inventory Id');
                }
                if (!formData.serviceId) {
                    missingFields.push('service Id');
                }
                if (missingFields.length > 0) {
                    let message = missingFields.join(', ') + ' is required';
                    new Notify({
                        status: 'error',
                        text: message,
                        effect: 'fade',
                        speed: 300,
                        showIcon: true,
                        showCloseButton: false,
                        autoclose: true,
                        autotimeout: 3000,
                        position: 'left bottom',
                        type: 'filled',
                    });
                    return false;
                }
                $.ajax({
                    url: '{{route('set_inventory')}}',
                    type: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $('.top-loader').show();
                    },
                    complete: function() {
                        $('.top-loader').hide();
                    },
                    success: function(response) {
                        new Notify({
                            status: response.success ? 'success' : 'error',
                            text: response.message,
                            effect: 'fade',
                            speed: 300,
                            showIcon: true,
                            showCloseButton: false,
                            autoclose: true,
                            autotimeout: 3000,
                            position: 'left bottom',
                            type: 'filled',
                        });
                        if (response.success) {
                            assignedAPI(response.serviceId);
                            reloadDataTable();
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error updating field: ' + error);
                    }
                });

            });
        });


        // START - UPDATE SERVICE
        $(document).on('click', '#update-service', function() {

            let selectedTags = $('.service-tag:checked').map(function() {
                return $(this).val();
            }).get();
            let tags = selectedTags.join(', ');

            var formData = {
                serviceID: $('#service_id').val(),
                Status: $('#service_status').val(),
                Title: $('#service_title').val(),
                Slug: $('#service_slug').val(),
                MinQNT: '',
                MaxQNT: '',
                Duration: $('#service_duration').val(),
                Delivery: $('#service_delivery').val(),
                Article: $('#service_article').val(),
                PriceType: $('#price_type').val(),
                BasePrice: $('#base_price').val(),
                CustomerProfit: $('#customer_profit').val(),
                ResellerProfit: $('#reseller_profit').val(),
                DistributorProfit: $('#distributor_profit').val(),
                WebownerProfit: $('#webowner_profit').val(),
                Kw1: $('#service_kw1').val(),
                Kw2: $('#service_kw2').val(),
                Kw3: $('#service_kw3').val(),
                Kw4: $('#service_kw4').val(),
                Kw5: $('#service_kw5').val(),
                metaDesc: $('#service_meta_desc').val(),
                downloadURL: $('#download_url').val(),
                loginURL: $('#login_url').val(),
                registerURL: $('#register_url').val(),
                tags: tags,
            };
            let missingFields = [];
            if (!formData.serviceID) {
                missingFields.push('Service ID');
            }
            if (!formData.Status) {
                missingFields.push('Status');
            }
            if (!formData.Title) {
                missingFields.push('Title');
            }
            if (!formData.Slug) {
                missingFields.push('Slug');
            }
            if (!formData.BasePrice) {
                missingFields.push('Base Price');
            }
            if (!formData.PriceType) {
                missingFields.push('Price type');
            }
            if (!formData.CustomerProfit) {
                missingFields.push('Customer Profit');
            }
            if (missingFields.length > 0) {
                let message = missingFields.join(', ') + ' is required';
                new Notify({
                    status: 'error',
                    text: message,
                    effect: 'fade',
                    speed: 300,
                    showIcon: true,
                    showCloseButton: false,
                    autoclose: true,
                    autotimeout: 3000,
                    position: 'left bottom',
                    type: 'filled',
                });
                return false;
            }
            $.ajax({
                url: '/admin/update-service',
                method: 'POST',
                data: formData,
                beforeSend: function() {
                    $('.top-loader').show();
                    $('#update-service').prop('disabled', true);
                    $('#loadingSpinnerSuccess').removeClass('d-none');
                },
                complete: function() {
                    $('.top-loader').hide();
                    $('#update-service').prop('disabled', false);
                    $('#loadingSpinnerSuccess').addClass('d-none');
                },
                success: function(response) {
                    new Notify({
                        status: response.success ? 'success' : 'error',
                        text: response.message,
                        effect: 'fade',
                        speed: 300,
                        showIcon: true,
                        showCloseButton: false,
                        autoclose: true,
                        autotimeout: 3000,
                        position: 'left bottom',
                        type: 'filled',
                    });
                    if (response.success) {
                        reloadDataTable();
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error occurred while updating..', error);
                }
            });
        });
        // END - UPDATE SERVICE

        // START - LOAD IMAGE
        function loadIMG(serviceID){
            $.ajax({
                url: '/admin/fetch-img/' + serviceID,
                method: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                success: function(response) {
                    if (response.success) {
                        let htmlIMG = `
                            <div class="row mb-4">
                                <label for="customer_profit" class="col-sm-3 col-form-label">
                                    Thumbnail
                                    <div class="d-flex gap-2">
                                        <div class="mt-3"><button type="button" class="btn btn-icon btn-primary add-thumb"><i class="fas fa-pencil-alt"></i></button></div>
                                        <div class="mt-3"><button type="button" class="btn btn-icon btn-danger remove-thumb"><i class="fas fa-trash-alt"></i></button></div>
                                    </div>
                                </label>
                                <div class="col-sm-9">
                                    <img src="${response.thumb}" alt="thumbnail" height="200" width="300" style="height:200px; max-width:100%" class="rounded">
                                </div>
                            </div>
                            <div class="row mt-4">
                                <label for="customer_profit" class="col-sm-3 col-form-label">
                                    Screenshot
                                    <div class="d-flex gap-2">
                                        <div class="mt-3"><button type="button" class="btn btn-icon btn-primary add-screenshot"><i class="fas fa-pencil-alt"></i></button></div>
                                        <div class="mt-3"><button type="button" class="btn btn-icon btn-danger remove-screenshot"><i class="fas fa-trash-alt"></i></button></div>
                                    </div>
                                </label>
                                <div class="col-sm-9">
                                    <img src="${response.screenshot}" alt="Screenshot" height="200" width="300" style="height:200px; max-width:100%" class="rounded">
                                </div>
                            </div>
                        `;
                        $('#image').html(htmlIMG);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error occurred while updating..', error);
                }
            });
        }
        // END - LOAD IMAGE

        // START - Remove image
        $(document).on('click', '.remove-thumb, .remove-screenshot', function(){
            var serviceID = $('#service_id').val();
            var action = $(this).hasClass('remove-thumb') ? 'remove-thumb' : 'remove-screenshot';
            $.ajax({
                url: '/admin/service/remove-img/' + serviceID + '/' + action,
                method: 'GET',
                beforeSend: function() {
                    $('.top-loader').show();
                },
                complete: function() {
                    $('.top-loader').hide();
                },
                success: function(response) {
                    if (response.success) {
                        new Notify({
                            status: 'success',
                            text: response.message,
                            effect: 'fade',
                            speed: 300,
                            showIcon: true,
                            showCloseButton: false,
                            autoclose: true,
                            autotimeout: 3000,
                            position: 'left bottom',
                            type: 'filled',
                        });
                        loadIMG(serviceID);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error occurred while updating..');
                }
            });
        });
        // END - Remove image
        // START - Add image
        $(document).on('click', '.add-thumb, .add-screenshot', function(){
            var serviceID = $('#service_id').val();
            var Action = $(this).hasClass('add-thumb') ? 'add-thumb' : 'add-screenshot';
            $('#addImg').modal('show');
            loadModalIMG(serviceID, Action);
        });
        function loadModalIMG(serviceID, Action){
            if ($.fn.dataTable.isDataTable('#modal-img-list')) {
                $('#modal-img-list').DataTable().clear().destroy();
            }
            var table = $('#modal-img-list').DataTable({
                processing: false,
                serverSide: false,
                lengthChange: false,
                info: false,
                ajax: {
                    url: '{{ route('fetch_modal_img') }}',
                    type: 'GET',
                    beforeSend: function() {
                        $('.top-loader').show();
                    },
                    complete: function() {
                        $('.top-loader').hide();
                    },
                },
                columns: [
                    {
                        data: 'media_name',
                        title: 'IMAGE',
                        className: 'text-left',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            return data ? `<img src="/media/${data}" alt="Thumbnail" width="70" height="47" class="rounded" >` : 'No Image';
                        }
                    },
                    {
                        data: 'media_name',
                        title: 'NAME',
                        className: 'text-left',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'media_size',
                        title: 'SIZE',
                        className: 'text-left',
                        orderable: true,
                        searchable: true,
                        render: function(data) {
                            if (data) {
                                if (data > 1024 * 1024) {
                                    return (data / (1024 * 1024)).toFixed(2) + ' MB';
                                } else if (data > 1024) {
                                    return (data / 1024).toFixed(2) + ' KB';
                                } else {
                                    return data + ' Bytes';
                                }
                            } else {
                                return '-';
                            }
                        }
                    },
                    {
                        data: 'media_width',
                        title: 'RESOLUTION',
                        className: 'text-left',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            if (data && row.media_height) {
                                return data + 'x' + row.media_height + ' px';
                            } else {
                                return '-';
                            }
                        }
                    },
                ],
                // order: [[1, 'asc']],
                pageLength: 100,
                language: {
                    search: "",
                    searchPlaceholder: "Search...",
                    lengthMenu: "_MENU_",
                    paginate: {
                        previous: "<",
                        next: ">"
                    }
                },
                pagingType: "simple",
                initComplete: function () {
                    $('.dataTables_length select').addClass('form-control dt-select-padding');
                },
                // Show offcanvas
                createdRow: function(row, data, dataIndex) {
                    $('td', row).on('click', function() {
                        showSelectBtn(data.media_name, serviceID, Action);
                        var imageUrl = data.media_name ? "/media/" + data.media_name : "";
                        if (imageUrl) {
                            $('.show-preview').html(`<img src="${imageUrl}" alt="Preview" style="max-width: 100%; max-height: 40px;" class="rounded">`).show();
                        } else {
                            $('.show-preview').hide();
                        }

                    });
                }
            });
            $('.page-prev').on('click', function() {
                table.page('previous').draw('page');
            });
            $('.page-next').on('click', function() {
                table.page('next').draw('page');
            });
            $('.media-search').on('input', function() {
                var searchValue = this.value;
                if (searchValue.length === 0) {
                    table.search('').draw();
                } else {
                    table.search(searchValue).draw();
                }
            });
            $(document).on('imageUploadSuccess', function() {
                // Refresh the DataTable
                table.ajax.reload();
            });
        }

        $(document).ready(function() {
            // When files are selected
            $('#uploadimg').on('change', function(e) {
                e.preventDefault();
                let formData = new FormData();
                $.each($('#uploadimg')[0].files, function(i, file) {
                    formData.append('image', file);
                });
                $.ajax({
                    url: '{{ route("upload_modal_img") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('.top-loader').show();
                        $('.media-upload-btn').hide();
                        $('.media-upload-loader').show();
                    },
                    complete: function() {
                        $('.top-loader').hide();
                        $('#uploadimg').val('');
                        $('.media-upload-btn').show();
                        $('.media-upload-loader').hide();
                    },
                    success: function(response) {
                        new Notify({
                            status: `${response.success ? 'success' : 'error'}`,
                            text: response.message,
                            effect: 'fade',
                            speed: 300,
                            showIcon: true,
                            showCloseButton: false,
                            autoclose: true,
                            autotimeout: 3000,
                            position: 'left bottom',
                            type: 'filled',
                        });
                        if(response.success){
                            $(document).trigger('imageUploadSuccess');

                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.log(xhr.responseText);
                        $('#response').html('<p>An error occurred while uploading the images.</p>');
                    }
                });
            });
        });
        // END - Add image

        function showSelectBtn(mediaName, serviceID, Action) {
            $('.selectIMG').show();
            $('.selectIMG').off('click').on('click', function() {
                $.ajax({
                    url: '/admin/service/add-img/' + serviceID + '/' + Action + '/' + mediaName,
                    method: 'GET',
                    beforeSend: function() {
                        $('.top-loader').show();
                    },
                    complete: function() {
                        $('.top-loader').hide();
                    },
                    success: function(response) {
                        if (response.success) {
                            new Notify({
                                status: 'success',
                                text: response.message,
                                effect: 'fade',
                                speed: 300,
                                showIcon: true,
                                showCloseButton: false,
                                autoclose: true,
                                autotimeout: 3000,
                                position: 'left bottom',
                                type: 'filled',
                            });
                            $('#addImg').modal('hide');
                            loadIMG(serviceID);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error occurred while updating..');
                    }
                });
            });
        }


        // START - ADD NEW SERVICE
        $(document).ready(function() {
            $('#new-service-form').submit(function(e) {
                e.preventDefault();
                $('#new-update-button').hide();
                $('#new-loader-button').show();
                // Prepare form data
                var formData = {
                    name: $('#new-service-name').val(),
                    duration: $('#new-service-duration').val(),
                    delivery: $('#new-service-delivery-time').val(),
                };
                $.ajax({
                    url: '{{ route('add_new_server') }}',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#new-update-button').show();
                        $('#new-loader-button').hide();
                        if (response.success) {
                            reloadDataTable();
                            loadServiceDetails(response.new_id);
                            $('#addNewService').modal('hide');
                            $('#new-service-form')[0].reset();
                        }
                        new Notify({
                            status: response.success ? 'success' : 'error',
                            text: response.message,
                            effect: 'fade',
                            speed: 300,
                            showIcon: true,
                            showCloseButton: false,
                            autoclose: true,
                            autotimeout: 3000,
                            position: 'left bottom',
                            type: 'filled',
                        });
                    },
                    error: function(xhr, status, error) {
                        $('#new-update-button').show();
                        $('#new-loader-button').hide();
                    }
                });
            });
        });
        // END - ADD NEW SERVICE

    })
</script>
@endsection
