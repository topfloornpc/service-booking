<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function home()
    {
        $services = Service::where('is_active', true)
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact('services'));
    }

    public function index()
    {
        $services = Service::where('is_active', true)
            ->latest()
            ->paginate(9);

        return view('services.index', compact('services'));
    }

    public function show(Service $service)
    {
        $slots = $service->slots()
            ->where('is_active', true)
            ->where('start_at', '>=', now())
            ->orderBy('start_at')
            ->limit(50)
            ->get();

        return view('services.show', compact('service', 'slots'));
    }
}
