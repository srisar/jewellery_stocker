<?php

use Jman\Core\App;
use Jman\Core\View;
use Jman\Models\Bill;
use Jman\Models\BillItem;
use Jman\Models\Category;

/** @var Bill $bill */
$bill = View::getData('bill');

/** @var BillItem[] $billItems */
$billItems = $bill->getBillItems();

?>

<?php include_once BASE_PATH . "/views/_header_with_top_nav.inc.php"; ?>

<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-12 col-md-8">

            <div class="card" id="container_add_bill">
                <div class="card-header">Edit bill : <?= $bill->id ?></div>
                <div class="card-body">

                    <input type="hidden" id="bill_id" name="bill_id" value="<?= $bill->id ?>">

                    <div class="row mb-3">
                        <div class="col-6">

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Bill date</span>
                                </div>
                                <input type="text" class="form-control date_field" id="field_bill_date" value="<?= $bill->bill_date ?>">
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="field_customer_name">Customer name</label>
                                <input type="text" class="form-control" id="field_customer_name" value="<?= $bill->customer_name ?>">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="field_contact_number">Contact number</label>
                                <input type="text" class="form-control" id="field_contact_number" value="<?= $bill->contact_number ?>">
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="field_address">Address</label>
                        <textarea class="form-control" id="field_address" rows="3"><?= $bill->address ?></textarea>
                    </div>

                    <hr>

                    <table class="table table-striped table-bordered data_table" id="dt_bill_items">
                        <thead>
                        <tr>
                            <th>Item</th>
                            <th style="width: 50px">Quantity</th>
                            <th style="width: 130px">Price</th>
                            <th style="width: 130px">Subtotal</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($billItems as $item): ?>
                            <tr>
                                <td><?= $item->getItem()->item_name ?></td>
                                <td><?= $item->quantity ?></td>
                                <td><?= App::toCurrencyString($item->price) ?></td>
                                <td><?= App::toCurrencyString($item->quantity * $item->price) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>


                   <div class="row my-3">
                      <div class="col-4">
                          <div class="input-group">
                              <div class="input-group-prepend">
                                  <span class="input-group-text">Bill total</span>
                              </div>
                              <input type="text" class="form-control text-right" value="<?= App::toCurrencyString($bill->bill_total) ?>">
                          </div>
                      </div>
                   </div>

                    <hr>

                    <div class="text-right">
                        <button id="btn_save_bill" class="btn btn-success" type="button">Update</button>
                        <button id="btn_delete_item" class="btn btn-danger" type="button">Delete</button>
                        <a href="<?= App::createURL('/bills') ?>" class="btn btn-warning">Cancel</a>
                    </div>


                </div>
            </div>

        </div>


    </div>

</div>


<!-- Modal: Delete confirm -->
<div class="modal fade" id="modal_delete_bill_confirm" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_select_bill_item_title">Confirm Delete?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

               <p>Are you sure you want to delete the bill?</p>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btn_delete_confirm">Yes, Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>


<script src="<?= App::getSiteURL() ?>/assets/js/views/bills/edit_bill.view-min.js" defer></script>
<?php include BASE_PATH . "/views/_footer.inc.php"; ?>
