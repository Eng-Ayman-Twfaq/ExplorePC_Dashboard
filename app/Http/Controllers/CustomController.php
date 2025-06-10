<?php

namespace App\Http\Controllers;

use App\Models\Custom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Custom::query();

        // فلترة بالاسم
        if ($request->has('name')) {
            $query->where('UserName', 'like', '%'.$request->name.'%');
        }

        // فلترة بالبريد الإلكتروني
        if ($request->has('email')) {
            $query->where('email', 'like', '%'.$request->email.'%');
        }

        // فلترة برقم الهاتف
        if ($request->has('phone')) {
            $query->where('Phone', 'like', '%'.$request->phone.'%');
        }

        $customs = $query->latest()->paginate(10);

        return view('custom.index', [
            'customs' => $customs,
            'filters' => $request->all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('custom.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'UserName' => 'required|string|max:255',
            'email' => 'required|email|unique:customs,email',
            'UserPassword' => 'required|min:6',
            'Phone' => 'required|numeric',
            'Address' => 'required|string',
            'Image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('Image')) {
            $validated['Image'] = $request->file('Image')->store('customers', 'public');
        }

        Custom::create($validated);

        return redirect()->route('custom.index')->with('success', 'تمت إضافة العميل بنجاح');
    }

    public function show(Custom $custom)
    {
        return view('custom.show', compact('custom'));
    }

    public function edit(Custom $custom)
    {
        return view('custom.edit', compact('custom'));
    }

    public function update(Request $request, Custom $custom)
    {
        $validated = $request->validate([
            'UserName' => 'required|string|max:255',
            'email' => 'required|email|unique:customs,email,'.$custom->UserId.',UserId',
            'UserPassword' => 'sometimes|min:6',
            'Phone' => 'required|numeric',
            'Address' => 'required|string',
            'Image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('Image')) {
            if ($custom->Image) {
                Storage::disk('public')->delete($custom->Image);
            }
            $validated['Image'] = $request->file('Image')->store('customers', 'public');
        }

        $custom->update($validated);

        return redirect()->route('custom.index')->with('success', 'تم تحديث بيانات العميل بنجاح');
    }

    public function destroy(Custom $customer)
    {
        if ($customer->Image) {
            Storage::disk('public')->delete($customer->Image);
        }
        $customer->delete();
        return redirect()->route('custom.index')->with('success', 'تم حذف العميل بنجاح');
    }
}
