<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SiteController extends Controller
{
    public function index()
    {
        return redirect()->route('user.transaction.log');
    }

    public function changeLang(Request $request)
    {
        App::setLocale($request->lang);
        session()->put('locale', $request->lang);
        return redirect()->back()->with('success', __('Successfully Changed Language'));
    }
}
