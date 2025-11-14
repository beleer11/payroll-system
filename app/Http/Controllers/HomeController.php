<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Charge;
use App\Models\Country;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home', [
            'stats' => $this->getStats(),
            'countries' => Country::all(),
            'employees' => Employee::all(),
            'charges' => Charge::all()
        ]);
    }

    private function getStats()
    {
        return [
            'total_employees' => Employee::count(),
            'total_charges' => Charge::count(),
            'total_countries' => Country::count(),
            'recent_employees' => Employee::with(['birthplace', 'boss'])
                ->latest()
                ->take(5)
                ->get()
        ];
    }
}
