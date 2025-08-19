<?php

namespace App\Http\Controllers;

use App\Http\Services\GoogleSheetsService;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::orderByDesc('created_at')->paginate(50);
        $settings = Setting::first();

        return view('welcome', compact('orders', 'settings'));
    }

    public function store(): RedirectResponse
    {
        $data = request()->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'delivery_date' => 'required|date|after:yesterday',
            'status' => ['required', Rule::in(['Allowed', 'Prohibited'])]
        ]);

        $order = Order::create($data);

        (new GoogleSheetsService())->appendRowToSheet($order);

        return redirect()->back();
    }

    public function update(): RedirectResponse
    {
        $data = request()->validate([
            'update_order_id' => 'required|exists:orders,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:510',
            'delivery_date' => 'required|date',
            'status' => ['required', Rule::in(['Allowed', 'Prohibited'])]
        ]);

        $order = Order::find($data['update_order_id']);

        $order->update($data);

        return redirect()->back();
    }

    public function delete(): RedirectResponse
    {
        $data = request()->validate([
            'delete_order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::find($data['delete_order_id']);

        $order->delete();

        (new GoogleSheetsService())->deleteRowFromSheet($data['delete_order_id']);

        return redirect()->back();
    }

    public function test(): RedirectResponse
    {
        $orders = array_map(function ($ell) {
            return array_values($ell);
        }, Order::allowed()->get()->toArray());

        (new GoogleSheetsService())->writeSheet($orders);

        return redirect()->route('index');
    }

    public function fillDb(): RedirectResponse
    {
        collect([
            Order::factory(500)->make(),
            Order::factory(500)->prohibited()->make(),
        ])->flatten()->shuffle()->each(fn ($order) => $order->save());

        return redirect()->back();
    }

    public function clearDb(): RedirectResponse
    {
        Order::truncate();

        return redirect()->back();
    }

    public function clearGoogleSheet(): RedirectResponse
    {
        (new GoogleSheetsService())->clearSheet();

        return redirect()->back();
    }

    public function fetch($count = null): string
    {
        Artisan::call('app:get-google-comments', [
            '--count' => $count,
            '-v' => true
        ]);

        $output = Artisan::output();

        return $output;
    }
}
