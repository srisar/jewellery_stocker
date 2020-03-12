<?php


namespace Jman\Controllers;


use Jman\Core\App;
use Jman\Core\AppRequest;
use Jman\Core\Database;
use Jman\Core\JsonResponse;
use Jman\Core\View;
use Jman\Models\Bill;
use Jman\Models\Item;

class BillsController
{

    /**
     * @param AppRequest $request
     */
    public function viewBills(AppRequest $request)
    {

        $q = $request->getParams()->getString('q') ?? null;

        if (!is_null($q)) {

            $start_date = $request->getParams()->getString('date_start');
            $end_date = $request->getParams()->getString('date_end');

            if (explode(":", $q)[0] == "id") {
                $bills = empty(Bill::find(explode(":", $q)[1])) ? [] : [Bill::find(explode(":", $q)[1])];

            } else {

                if (!is_null($start_date) && !is_null($end_date)) {

                    $bills = Bill::search($q, [$start_date, $end_date]);

                } else {
                    $bills = Bill::search($q);
                }
            }


            View::setData('bills', $bills);
            View::setData('title', "Search results for {$q}");

            View::render('bills/view_bills.view');

        } else {
            $bills = Bill::findAll();

            View::setData('bills', $bills);
            View::setData('title', "Recent bills");

            View::render('bills/view_bills.view');
        }


    }

    /**
     * @param AppRequest $request
     */
    public function viewEditBill(AppRequest $request)
    {
        $id = $request->getParams()->getInt('id');

        if (!is_null($id)) {

            $bill = Bill::find($id);

            if (!is_null($bill)) {

                // display the edit bill view
                View::setData('bill', $bill);
                View::render('/bills/edit_bill.view');


            } else {
                App::redirect('/bills');
            }


        } else {
            App::redirect('/bills');
        }

    }

    /**
     * @param AppRequest $request
     */
    public function viewAddBill(AppRequest $request)
    {

        View::render('/bills/add_bill.view');
    }

    /**
     * Add a new bill into db
     * @param AppRequest $request
     */
    public function actionAddBill(AppRequest $request)
    {
        $requiredFields = [
            "bill_date" => $request->getParams()->getString("bill_date"),
            "customer_name" => $request->getParams()->getString("customer_name"),
            "items" => $request->getParams()->get("items")
        ];

        $optionalFields = [
            "contact_number" => $request->getParams()->getString("contact_number"),
            "address" => $request->getParams()->getString("address"),
        ];

        foreach ($requiredFields as $k => $v) {
            if ($v == null) {
                $response = new JsonResponse("Invalid/missing field: {$k}");

                $response->setStatusCode400();
                $response->emit();
                return;
            }
        }


        $bill = new Bill();
        $bill->bill_date = $requiredFields['bill_date'];
        $bill->customer_name = $requiredFields['customer_name'];
        $bill->contact_number = $optionalFields['contact_number'];
        $bill->address = $optionalFields['address'];

        try {

            $addedBill = $bill->insert($requiredFields['items']);

            if (!empty($addedBill)) {


                $response = new JsonResponse($addedBill);
                $response->setStatusCode200();
                $response->emit();

                return;
            }

        } catch (\PDOException $exception) {

            $response = new JsonResponse($exception->getMessage());
            $response->setStatusCode400();;
            $response->emit();

        }

    }

    /**
     * Deletes the bill, actually set deleted as 1
     *
     * @param AppRequest $request
     */
    public function actionDeleteBill(AppRequest $request)
    {
        $id = $request->getParams()->getInt('id');

        if (!is_null($id)) {

            try {

                $bill = Bill::find($id);

                if (!empty($bill)) {

                    if ($bill->delete()) {

                        $response = new JsonResponse("Deleted");
                        $response->emit();

                    } else {
                        $response = new JsonResponse("Error");
                        $response->setStatusCode400();
                        $response->emit();
                    }

                }


            } catch (\PDOException $exception) {
                $response = new JsonResponse($exception->getMessage());
                $response->setStatusCode400();;
                $response->emit();
            }

        }

    }

}