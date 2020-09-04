<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class FeedController extends Controller
{
    public function index (Request $request) {
        // Create options for the API
        $guid = $request->get('guid');

        $shop = User::where('guid', $request->get('guid'))->firstOrFail();
        $result = $shop->api()->rest('GET', '/admin/products.json');
        Log::info(json_encode($result['body']['products']));

        return response(Storage::get($guid.'.xml'), 200, [
            'Content-Type' => 'application/xml'
        ]);


        return view('test');
    }
}
