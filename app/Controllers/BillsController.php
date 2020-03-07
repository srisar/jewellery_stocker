<?php


namespace Jman\Controllers;


use Jman\Core\AppRequest;
use Jman\Core\View;

class BillsController
{

    public function viewAddBill(AppRequest $request)
    {

        View::render('/bills/add_bill.view');
    }

}