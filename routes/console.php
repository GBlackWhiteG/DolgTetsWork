<?php

use App\Http\Services\GoogleSheetsService;
use App\Models\Order;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    $orders = array_map(function ($ell) {
        return array_values($ell);
    }, Order::allowed()->get()->toArray());

    (new GoogleSheetsService())->writeSheet($orders);
})->everyMinute();
