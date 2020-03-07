<?php

use Jman\Core\App;
use Jman\Core\View;
use Jman\Models\Category;
use Jman\Models\Item;

/** @var Item $item */
$item = View::getData('item');

/** @var Category[] $categories */
$categories = View::getData('categories');

?>

<?php include_once BASE_PATH . "/views/_header_with_top_nav.inc.php"; ?>

<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-12 col-md-6">

            <div class="card" id="container_update_item">
                <div class="card-header">Edit Item: <?= $item->item_name ?></div>
                <div class="card-body">


                    <input type="hidden" id="field_item_id" value="<?= $item->id ?>">

                    <div class="form-group">
                        <label for="field_item_name">Item name</label>
                        <input type="text" class="form-control" id="field_item_name" value="<?= stripslashes($item->item_name) ?>">
                    </div>

                    <div class="form-group">
                        <label for="field_item_description">Description</label>
                        <textarea class="form-control" id="field_item_description" rows="5"><?= $item->description ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="field_item_category">Category</label>
                        <select id="field_item_category" class="form-control">
                            <?php foreach ($categories as $category): ?>
                                <?php $selected = $category->id == $item->category_id ? "selected" : ""; ?>
                                <option value="<?= $category->id ?>" <?= $selected ?> ><?= $category->category_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="field_gold_quality">Gold quality (k)</label>
                                <input type="text" class="form-control text-right" id="field_gold_quality" value="<?= $item->gold_quality ?>">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="field_weight">Weight (g)</label>
                                <input type="text" class="form-control text-right" id="field_weight" value="<?= $item->weight ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="field_stock_price">Stock price (<?= $item->getStockPriceString() ?>)</label>
                                <input type="text" class="form-control text-right" id="field_stock_price" value="<?= $item->stock_price ?>">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="field_quantity">Quantity</label>
                                <input type="text" class="form-control text-right" id="field_quantity" value="<?= $item->quantity ?>">
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <button id="btn_update_item" class="btn btn-success" type="submit">Update</button>
                        <a href="<?= App::createURL('/items') ?>" class="btn btn-warning">Cancel</a>
                    </div>

                </div>
            </div>

        </div><!--.col-->

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Extra</div>
                <div class="card-body">

                    <div class="">
                        <h3>Meta data</h3>
                        <table class="table table-bordered ">
                            <tbody>
                            <tr>
                                <td style="width: 110px">Added on</td>
                                <td><?= $item->getAddedOn() ?></td>
                            </tr>
                            <tr>
                                <td>Last updated</td>
                                <td><?= $item->getUpdatedAt() ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

<script src="<?= App::getSiteURL() ?>/assets/js/views/items/update_item.view-min.js" defer></script>
<?php include BASE_PATH . "/views/_footer.inc.php"; ?>
