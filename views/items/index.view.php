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

            <div class="card">
                <div class="card-header"><?= $title ?></div>
                <div class="card-body">

                    <table class="table table-bordered table-striped data_table table-responsive-sm">
                        <thead>
                        <tr>
                            <th>Item</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Gold Quality</th>
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
                                <td><?= $item->gold_quality ?></td>
                                <td><?= $item->weight ?></td>
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

<script src="<?= App::getSiteURL() ?>/assets/js/views/items/add_items.view-min.js" defer></script>
<?php include BASE_PATH . "/views/_footer.inc.php"; ?>
