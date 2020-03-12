<?php

use Jman\Core\App;
use Jman\Core\View;
use Jman\Models\Category;


?>

<?php include_once BASE_PATH . "/views/_header_with_top_nav.inc.php"; ?>

<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-12 col-md-8">

            <div class="card" id="container_add_bill">
                <div class="card-header">Add new bill</div>
                <div class="card-body">

                    <div class="row mb-3">
                        <div class="col-6">

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Bill date</span>
                                </div>
                                <input type="text" class="form-control date_field" id="field_bill_date">
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="field_customer_name">Customer name</label>
                                <input type="text" class="form-control" id="field_customer_name" value="">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="field_contact_number">Contact number</label>
                                <input type="text" class="form-control" id="field_contact_number" value="">
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="field_address">Address</label>
                        <textarea class="form-control" id="field_address" rows="3"></textarea>
                    </div>


                    <div class="alert alert-light">

                        <div class="text-right mb-3">
                            <button class="btn btn-primary" id="btn_open_modal_add_item">Add item</button>
                        </div>

                        <table class="table table-striped table-bordered" id="dt_bill_items">
                            <thead>
                            <tr>
                                <th>Item</th>
                                <th style="width: 50px">Quantity</th>
                                <th style="width: 100px">Price</th>
                                <th style="width: 100px">Subtotal</th>
                                <th style="width: 50px">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>


                    <div class="text-right">
                        <button id="btn_save_bill" class="btn btn-success" type="button">Save</button>
                        <a href="<?= App::createURL('/items') ?>" class="btn btn-warning">Cancel</a>
                    </div>

                </div>
            </div>

        </div>


    </div>

</div>


<!-- Modal: Select Item -->
<div class="modal fade" id="modal_select_bill_item" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_select_bill_item_title">Select item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" id="field_search_items" value="">
                        <div class="input-group-append">
                            <button class="btn btn-success" id="btn_search_items">Search</button>
                        </div>
                    </div>
                </div>


                <div class="mb-3">
                    <table class="table table-bordered table-striped" id="dt_search_bill_items">
                        <thead>
                        <tr>
                            <th>Action</th>
                            <th>Item</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th class="dt-right">Gold Quality</th>
                            <th class="text-right">Weight</th>
                            <th class="text-right">Stock Price</th>
                            <th class="text-right">Quantity</th>
                        </tr>
                        </thead>
                        <tbody id="tbody_search_results">

                        </tbody>
                    </table>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script src="<?= App::getSiteURL() ?>/assets/js/views/bills/add_bill.view-min.js" defer></script>
<?php include BASE_PATH . "/views/_footer.inc.php"; ?>
