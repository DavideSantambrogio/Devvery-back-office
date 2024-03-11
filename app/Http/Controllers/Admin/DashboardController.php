<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $restaurant = Restaurant::where('user_id', Auth::id())->first();
        return view('admin.dashboard', compact('user', 'restaurant'));
    }
}
