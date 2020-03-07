<?php


namespace Jman\Controllers;



use Carbon\Carbon;
use Jman\Models\Category;
use Jman\Models\Item;

class TestController
{

    public function test_a()
    {
        var_dump(Item::search('nk'));

    }

}