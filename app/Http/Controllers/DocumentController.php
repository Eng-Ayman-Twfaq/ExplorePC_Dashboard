<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\MerchantDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $merchants = Merchant::all();
        $documents = MerchantDocument::with('merchant');

        // فلترة حسب التاجر
        if ($request->has('merchant_id') && $request->merchant_id != '') {
            $documents->where('MerchantId', $request->merchant_id);
        }

        // فلترة حسب الحالة
        if ($request->has('status') && $request->status != '') {
            $documents->where('status', $request->status);
        }

        $documents = $documents->paginate(10);

        return view('documents.index', compact('documents', 'merchants'));
    }
    // public function index()
    // {
    //     $documents = MerchantDocument::with('merchant')->get();
    //     return view('documents.index', compact('documents'));
    // }

    /**
     * Show the form for creating a new resource.
     */
   // app/Http/Controllers/DocumentController.php
   public function create()
   {
       $merchants = Merchant::all(); // جلب جميع التجار
       return view('documents.create', compact('merchants'));
   }

   public function store(Request $request)
   {
       $validated = $request->validate([
           'MerchantId' => 'required|exists:merchants,MerchantId',
           'documentType' => 'required|string|max:255',
           'documentImage' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
           'status' => 'required|string'
       ]);

       // رفع الصورة
       if ($request->hasFile('documentImage')) {
           $path = $request->file('documentImage')->store('documents', 'public');
           $validated['documentImage'] = $path;
       }

       $validated['uploadDate'] = now();

       MerchantDocument::create($validated);

       return redirect()->route('documents.index')
           ->with('success', 'تم إضافة الوثيقة بنجاح');
   }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // عرض نموذج التعديل
public function edit($documentId)
{
    $document = MerchantDocument::with('merchant')->findOrFail($documentId);
    return view('documents.edit', compact('document'));
}

// معالجة التعديل
public function update(Request $request, $documentId)
{
    $document = MerchantDocument::findOrFail($documentId);

    $validated = $request->validate([
        'documentType' => 'required|string|max:255',
        'documentImage' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'status' => 'required|string'
    ]);

    if ($request->hasFile('documentImage')) {
        // حذف الملف القديم
        Storage::disk('public')->delete($document->documentImage);

        // رفع الملف الجديد
        $path = $request->file('documentImage')->store('documents', 'public');
        $validated['documentImage'] = $path;
    }

    $document->update($validated);

    return redirect()->route('documents.index')
        ->with('success', 'تم تحديث الوثيقة بنجاح');
}

// معالجة الحذف
public function destroy($documentId)
{
    $document = MerchantDocument::findOrFail($documentId);

    // حذف الملف من التخزين
    Storage::disk('public')->delete($document->documentImage);

    $document->delete();

    return redirect()->route('documents.index')
        ->with('success', 'تم حذف الوثيقة بنجاح');
}
}
