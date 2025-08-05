<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view_stock'])->only(['index', 'show']);
    }
    public function index()
    {
        $stocks = Stock::with('product', 'attributes.attribute', 'attributes.attributeValue')->get();

        $uniqueStocks = $stocks->unique('product_id')->values();

        return view('admin.stocks.index', ['stocks' => $uniqueStocks]);
    }

    public function show($id)
    {
        $stocks = Stock::whereProductId($id)->with('product', 'attributes.attribute', 'attributes.attributeValue')->get();
        return view('admin.stocks.show', ['stocks' => $stocks]);
    }
}
