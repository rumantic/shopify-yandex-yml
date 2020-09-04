<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class FeedController extends Controller
{
    public function index (Request $request) {
        // Create options for the API
        $shop = User::where('guid', $request->get('guid'))->firstOrFail();

        $result = $shop->api()->rest('GET', '/admin/products.json');
        Log::info(json_encode($result));

        return view('test');
    }
}
