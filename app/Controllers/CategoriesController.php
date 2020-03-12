<?php


namespace Jman\Controllers;


use Jman\Core\App;
use Jman\Core\AppRequest;
use Jman\Core\JsonResponse;
use Jman\Core\View;
use Jman\Models\Category;

class CategoriesController
{

    /**
     * @param AppRequest $request
     */
    function viewCategoriesPage(AppRequest $request)
    {


        $selectedCategoryId = $request->getParams()->getInt('selected_id') ?? 1;

        $categories = Category::findAll();
        $selectedCategory = Category::find($selectedCategoryId);

        View::setData('categories', $categories);
        View::setData('selected_category', $selectedCategory);

        View::render('/categories/categories.view');


    }

    /**
     * @param AppRequest $request
     */
    function viewEditCategory(AppRequest $request)
    {
        $categoryId = $request->getParams()->getInt('id');


        if (!empty($categoryId)) {

            $selectedCategory = Category::find($categoryId);
            $categories = Category::findAll();

            View::setData('categories', $categories);
            View::setData('selected_category', $selectedCategory);
            View::render('/categories/edit.view');

        } else {
            App::redirect('/');
        }

    }

    function actionAddCategory(AppRequest $request)
    {

        $categoryName = $request->getParams()->getString('category_name');

        if (!empty($categoryName)) {

            $newCategory = new Category();
            $newCategory->init($categoryName);

            $exists = Category::existing($categoryName);

            if(!$exists){
                $result = $newCategory->insert();

                if (!empty($result)) {
                    $response = new JsonResponse(['category' => Category::find($result)]);
                    $response->emit();

                    return;

                } else {
                    $response = new JsonResponse(['category' => null]);
                    $response->setStatusCode400();
                    $response->emit();
                }

                return;
            }else{
                $response = new JsonResponse("Category already exists.");
                $response->setStatusCode400();
                $response->emit();
            }



            return;

        } else {
            $response = new JsonResponse("Category name cannot be empty.");
            $response->setStatusCode400();
            $response->emit();
        }


    }

    public function actionFindCategory(AppRequest $request)
    {

        $categoryId = $request->getParams()->getInt('id');

        if (!empty($categoryId)) {

            $selectedCategory = Category::find($categoryId);

            if (!empty($selectedCategory)) {
                $response = new JsonResponse(['category' => $selectedCategory]);
                $response->emit();
            }


        } else {
            $response = new JsonResponse("Invalid category id: {$categoryId}");
            $response->setStatusCode400();
            $response->emit();
        }

    }

    public function actionEditCategory(AppRequest $request)
    {


        $fields = [
            'id' => $request->getParams()->getInt('id'),
            'category_name' => $request->getParams()->getString('category_name'),
        ];

        foreach ($fields as $k => $v) {
            if (empty($v)) {
                $response = new JsonResponse(["Invalid/missing field: {$k}", $fields]);

                $response->setStatusCode400();
                $response->emit();
                return;
            }
        }

        $exists = Category::existing($fields['category_name']);

        if (!$exists) {


            $category = Category::find($fields['id']);
            $category->category_name = $fields['category_name'];

            $result = $category->update();

            if ($result) {
                $response = new JsonResponse($category);
                $response->emit();
                return;
            }

            $response = new JsonResponse("Failed updating category.");
            $response->emit();
            return;

        } else {
            $response = new JsonResponse("Category already exists.");
            $response->setStatusCode400();
            $response->emit();

            return;
        }

    }

}