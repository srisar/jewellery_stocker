<?php


namespace Jman\Controllers;


use Jman\Core\App;
use Jman\Core\AppRequest;
use Jman\Core\Database;
use Jman\Core\JsonResponse;
use Jman\Core\View;
use Jman\Models\Category;
use Jman\Models\Item;
use PDOException;

class ItemsController
{


    public function viewItems(AppRequest $request)
    {


        $categoryId = $request->getParams()->getInt('category_id');

        if (!is_null($categoryId)) {

            $category = Category::find($categoryId);

            if (!empty($category)) {

                $items = Item::getItemsByCategory($category);

                View::setData('items', $items);
                View::setData('title', "Items by {$category}");
                View::render('/items/index.view');
                return;

            } else {
                App::redirect("/");
            }


        }

        $items = Item::findAll();

        View::setData('items', $items);
        View::setData('title', "All Items");
        View::render('/items/index.view');
        return;
    }

    public function viewAddItem(AppRequest $request)
    {

        $categories = Category::findAll();

        View::setData('categories', $categories);
        View::render('/items/add_item.view');
    }

    /**
     * Add new item
     * @param AppRequest $request
     */
    public function actionAddItem(AppRequest $request)
    {
        $requiredFields = [
            'item_name' => $request->getParams()->getString('item_name'),
            'category_id' => $request->getParams()->getString('category_id'),
            'quantity' => $request->getParams()->getFloat('quantity'),
            'stock_price' => $request->getParams()->getString('stock_price'),
            'gold_quality' => $request->getParams()->getInt('gold_quality'),
            'weight' => $request->getParams()->getFloat('weight'),
        ];

        $optionalFields = [
            'description' => $request->getParams()->getString('description'),
        ];

        foreach ($requiredFields as $k => $v) {
            if ($v == null) {
                $response = new JsonResponse("Invalid/missing field: {$k}");

                $response->setStatusCode400();
                $response->emit();
                return;
            }
        }

        $item = new Item();

        $item->item_name = $requiredFields['item_name'];
        $item->category_id = $requiredFields['category_id'];
        $item->stock_price = $requiredFields['stock_price'];
        $item->quantity = $requiredFields['quantity'];
        $item->gold_quality = $requiredFields['gold_quality'];
        $item->weight = $requiredFields['weight'];

        $item->description = $optionalFields['description'];

        try {
            if ($item->insert()) {

                $lastInsertedId = (Database::get_instance())->lastInsertId();

                $item = Item::find($lastInsertedId);

                $response = new JsonResponse($item);
                $response->setStatusCode200();
                $response->emit();

                return;

            } else {
                $response = new JsonResponse("Item adding failed.");
                $response->setStatusCode400();;
                $response->emit();
            }
        } catch (PDOException $exception) {
            $response = new JsonResponse($exception->getMessage());
            $response->setStatusCode400();;
            $response->emit();
        }

    }

    public function viewEditItem(AppRequest $request)
    {
        $id = $request->getParams()->getInt('id');

        if (empty($id)) {
            App::redirect('/');
        }

        $item = Item::find($id);
        $categories = Category::findAll();

        View::setData('categories', $categories);
        View::setData('item', $item);

        View::render('/items/edit.view');

    }

    /**
     * @param AppRequest $request
     */
    public function actionEditItem(AppRequest $request)
    {
        $requiredFields = [
            'item_name' => $request->getParams()->getString('item_name'),
            'category_id' => $request->getParams()->getString('category_id'),
            'quantity' => $request->getParams()->getInt('quantity'),
            'stock_price' => $request->getParams()->getString('stock_price'),
            'id' => $request->getParams()->getString('id'),
            'gold_quality' => $request->getParams()->getInt('gold_quality'),
            'weight' => $request->getParams()->getFloat('weight'),
        ];

        $optionalFields = [
            'description' => $request->getParams()->getString('description'),
        ];

        foreach ($requiredFields as $k => $v) {
            if ($v == null) {
                $response = new JsonResponse("Invalid/missing field: {$k}");

                $response->setStatusCode400();
                $response->emit();
                return;
            }
        }

        $item = Item::find($requiredFields['id']);

        $item->item_name = $requiredFields['item_name'];
        $item->category_id = $requiredFields['category_id'];
        $item->stock_price = $requiredFields['stock_price'];
        $item->quantity = $requiredFields['quantity'];
        $item->gold_quality = $requiredFields['gold_quality'];
        $item->weight = $requiredFields['weight'];

        $item->description = $optionalFields['description'];

        try {
            if ($item->update()) {

                // $item = Item::find($item->id);

                $response = new JsonResponse($item);
                $response->setStatusCode200();
                $response->emit();

                return;

            } else {
                $response = new JsonResponse("Item update failed.");
                $response->setStatusCode400();;
                $response->emit();
            }
        } catch (PDOException $exception) {
            $response = new JsonResponse($exception->getMessage());
            $response->setStatusCode400();;
            $response->emit();
        }
    }

    public function actionSearchItems(AppRequest $request)
    {
        $keyword = $request->getParams()->getString('keyword') ?? "";

        try {

            $items = Item::search($keyword);

            if (!empty($items)) {
                foreach ($items as $item) {
                    $item->category_name = $item->getCategory()->category_name;
                    $item->stock_price_string = $item->getStockPriceString();
                }
            }

            $response = new JsonResponse($items);
            $response->setStatusCode200();
            $response->emit();


        } catch (PDOException $exception) {
            $response = new JsonResponse($exception->getMessage());
            $response->setStatusCode400();;
            $response->emit();
        }
    }

    public function actionGetItems(AppRequest $request)
    {

        $count = $request->getParams()->getInt('count') ?? 10;

        try {

            $items = Item::findAll($count);

            $response = new JsonResponse($items);
            $response->setStatusCode200();
            $response->emit();


        } catch (PDOException $exception) {
            $response = new JsonResponse($exception->getMessage());
            $response->setStatusCode400();;
            $response->emit();
        }

    }

}