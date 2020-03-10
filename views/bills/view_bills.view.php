<?php

use Jman\Core\App;
use Jman\Core\View;
use Jman\Models\Bill;
use Jman\Models\Category;
use Jman\Models\Item;

/** @var Bill[] $bills */
$bills = View::getData('bills');

$title = View::getData('title');
?>

<?php include_once BASE_PATH . "/views/_header_with_top_nav.inc.php"; ?>

<div class="container-fluid">

    <div class="row">

        <div class="col-12">

            <div class="alert alert-primary">
                <div class="row">

                    <div class="col">

                        <form action="<?= App::createURL('/bills') ?>" method="get">
                            <div class="input-group">
                                <input type="text" id="field_query" name="q" class="form-control" placeholder="search for bills">
                                <div class="input-group-append">

                                    <button class="btn btn-success" id="btn_search">Search</button>


                                    <div class="input-group-text">

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="check_enable_date_range" name="check_enable_date_range">
                                            <label class="custom-control-label" for="check_enable_date_range">With date range</label>
                                        </div>

                                    </div>


                                </div>
                                <div class="input-group-append">
                                    <div class="input-group-text">End Date</div>
                                </div>
                                <input type="text" class="form-control date_field" id="field_date_start" name="date_start" style="max-width: 120px">
                                <div class="input-group-append">
                                    <div class="input-group-text">End Date</div>
                                </div>
                                <input type="text" class="form-control date_field" name="date_end" id="field_date_end" style="max-width: 120px">
                            </div>

                        </form>

                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-header"><?= $title ?></div>
                <div class="card-body">

                    <table class="table table-bordered table-striped data_table table-responsive-sm">
                        <thead>
                        <tr>
                            <th style="width: 50px">Bill No.</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Contact</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th style="width: 50px">Action</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($bills as $bill): ?>
                            <tr>
                                <td><a href="<?= App::createURL('/bills/edit', ['id' => $bill->id]) ?>"><?= $bill->id ?></a></td>
                                <td><?= $bill->bill_date ?></td>
                                <td><?= $bill->customer_name ?></td>
                                <td><?= $bill->contact_number ?></td>
                                <td>
                                    <ul class="list-group">
                                        <?php foreach ($bill->getBillItems() as $item): ?>
                                            <li class="list-group-item"><?= $item->getItem()->item_name; ?></li>
                                        <?php endforeach; ?>
                                    </ul>

                                </td>
                                <td><?= $bill->getBillTotalString() ?></td>
                                <td>
                                    <a class="btn btn-sm btn-warning" href="<?= App::createURL('/bills/edit', ['id' => $bill->id]) ?>">Edit</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>

        </div>


    </div>

</div>

<script src="<?= App::getSiteURL() ?>/assets/js/views/bills/view_bills.view-min.js" defer></script>
<?php include BASE_PATH . "/views/_footer.inc.php"; ?>
