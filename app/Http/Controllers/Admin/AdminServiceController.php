<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required','string','max:120'],
            'description' => ['nullable','string'],
            'duration_minutes' => ['required','integer','min:10','max:300'],
            'price' => ['required','numeric','min:0'],
            'is_active' => ['nullable'],
        ]);

        $data['slug'] = Str::slug($data['title']);
        $data['is_active'] = $request->boolean('is_active');

        $base = $data['slug'];
        $i = 2;
        while (Service::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $base . '-' . $i++;
        }

        Service::create($data);

        return redirect()->route('admin.services.index')->with('status', 'Service created');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'title' => ['required','string','max:120'],
            'description' => ['nullable','string'],
            'duration_minutes' => ['required','integer','min:10','max:300'],
            'price' => ['required','numeric','min:0'],
            'is_active' => ['nullable'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($data['title'] !== $service->title) {
            $slug = Str::slug($data['title']);
            $base = $slug;
            $i = 2;
            while (Service::where('slug', $slug)->where('id', '!=', $service->id)->exists()) {
                $slug = $base . '-' . $i++;
            }
            $data['slug'] = $slug;
        }

        $service->update($data);

        return redirect()->route('admin.services.index')->with('status', 'Service updated');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return back()->with('status', 'Service deleted');
    }
}
