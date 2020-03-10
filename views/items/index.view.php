<?php

use Jman\Core\App;
use Jman\Core\View;
use Jman\Models\Category;
use Jman\Models\Item;

/** @var Item[] $items */
$items = View::getData('items');

$title = View::getData('title');


?>

<?php include_once BASE_PATH . "/views/_header_with_top_nav.inc.php"; ?>

<div class="container-fluid">

    <div class="row">

        <div class="col-12">

            <div class="alert alert-primary">
                <div class="row">

                    <div class="col">

                        <div class="input-group">
                            <input type="text" id="field_query" name="field_query" class="form-control" placeholder="search for items">
                            <div class="input-group-append">
                                <button class="btn btn-success" id="btn_search">Search</button>
                                <div class="input-group-text">

                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="check_show_empty" name="check_show_empty">
                                        <label class="custom-control-label" for="check_show_empty">Show empty items</label>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="float-left" id="txt_title"><?= $title ?></div>
                    <div class="float-right">
                        <a href="<?= App::updateURL(['se' => 1]) ?>" class="btn btn-sm btn-dark">Show empty items</a>
                        <a href="<?= App::updateURL(['se' => 0]) ?>" class="btn btn-sm btn-dark">Hide empty items</a>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-bordered table-striped table-responsive-sm" id="dt_items">
                        <thead>
                        <tr>
                            <th>Item</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th class="text-right">Gold Quality</th>
                            <th class="text-right">Weight</th>
                            <th class="text-right">Stock Price</th>
                            <th class="text-right">Quantity</th>
                            <th class="text-right">Total Value</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><a href="<?= App::createURL('/items/edit', ['id' => $item->id]) ?>"><?= stripslashes($item->item_name) ?></a></td>
                                <td><?= $item->description ?></td>
                                <td><?= $item->getCategory() ?></td>
                                <td class="text-right"><?= $item->gold_quality ?></td>
                                <td class="text-right"><?= $item->weight ?></td>
                                <td class="text-right"><?= $item->getStockPriceString() ?></td>
                                <td class="text-right"><?= $item->quantity ?></td>
                                <td class="text-right"><?= $item->getTotalValueString() ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>

        </div>


    </div>

</div>

<script src="<?= App::getSiteURL() ?>/assets/js/views/items/view_all_items.view-min.js" defer></script>
<?php include BASE_PATH . "/views/_footer.inc.php"; ?>
