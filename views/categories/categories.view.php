<?php

use Jman\Core\App;
use Jman\Core\Exceptions\CoreException;
use Jman\Core\View;
use Jman\Models\Category;


/** @var Category[] $categories */
$categories = View::getData('categories');
$selectedCategory = View::getData('selected_category')


?>

<?php include_once BASE_PATH . "/views/_header_with_top_nav.inc.php"; ?>

<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-12 col-md-6">

            <div class="card">
                <div class="card-header">Categories</div>
                <div class="card-body">

                    <div class="alert alert-secondary">

                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Category name" id="field_category_name">
                            <div class="input-group-append">
                                <button class="btn btn-success" type="button" id="btn_add_category">Add</button>
                            </div>
                        </div>
                        <div id="message_add_category" class="mt-2 text-center"></div>

                    </div>

                    <table class="data_table table table-striped table-bordered table-responsive-sm">
                        <thead>
                        <tr>
                            <th>Category</th>
                            <th class="text-right">No. Items</th>
                            <th class="text-right">Total Value</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($categories as $category): ?>

                            <tr>
                                <td><a href="<?= App::createURL('/items', ['category_id' => $category->id]) ?>"><?= $category ?></a></td>
                                <td class="text-right"><?= $category->getItemsCount() ?></td>
                                <td class="text-right"></td>
                                <td class="text-right">
                                    <div class="category_edit">
                                        <a class="btn btn-sm btn-warning" href="<?= App::createURL('/categories/edit', ['id' => $category->id]) ?>">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>

                    <ul class="list-group">

                    </ul>
                </div>
            </div>

        </div>


    </div>

</div>

<script src="<?= App::getSiteURL() ?>/assets/js/views/categories/common-min.js" defer></script>
<script src="<?= App::getSiteURL() ?>/assets/js/views/categories/categories.view-min.js" defer></script>
<?php include BASE_PATH . "/views/_footer.inc.php"; ?>
