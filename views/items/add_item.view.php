<?php

use Jman\Core\App;
use Jman\Core\View;
use Jman\Models\Category;


/** @var Category[] $categories */
$categories = View::getData('categories');

?>

<?php include_once BASE_PATH . "/views/_header_with_top_nav.inc.php"; ?>

<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-12 col-md-6">

            <div class="card" id="container_add_item">
                <div class="card-header">Add new item</div>
                <div class="card-body">

                    <div class="form-group">
                        <label for="field_item_name">Item name</label>
                        <input type="text" class="form-control" id="field_item_name" value="">
                    </div>

                    <div class="form-group">
                        <label for="field_item_description">Description</label>
                        <textarea class="form-control" id="field_item_description" rows="5"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="field_item_category">Category</label>
                        <select id="field_item_category" class="form-control">
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category->id ?>"><?= $category->category_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="field_gold_quality">Gold quality (k)</label>
                                <input type="text" class="form-control text-right" id="field_gold_quality" value="22">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="field_weight">Weight (g)</label>
                                <input type="text" class="form-control text-right" id="field_weight" value="0">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="field_stock_price">Stock price</label>
                                <input type="text" class="form-control text-right" id="field_stock_price" value="0">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="field_quantity">Quantity</label>
                                <input type="text" class="form-control text-right" id="field_quantity" value="1">
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <button id="btn_save_item" class="btn btn-success" type="submit">Save</button>
                        <a href="<?= App::createURL('/items') ?>" class="btn btn-warning">Cancel</a>
                    </div>

                </div>
            </div>

        </div>


    </div>

</div>

<script src="<?= App::getSiteURL() ?>/assets/js/views/items/add_items.view-min.js" defer></script>
<?php include BASE_PATH . "/views/_footer.inc.php"; ?>
