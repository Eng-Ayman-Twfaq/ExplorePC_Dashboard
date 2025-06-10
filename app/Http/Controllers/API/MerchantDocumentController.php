<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MerchantDocument;
use Illuminate\Http\Request;

class MerchantDocumentController extends Controller
{
   /**
     * إضافة وثيقة جديدة للتاجر
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'MerchantId' => 'required|exists:merchants,MerchantId',
            'documentType' => 'required|string|max:255',
            'documentImage' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // رفع الصورة
        if ($request->hasFile('documentImage')) {
            $path = $request->file('documentImage')->store('documents', 'public');
            $validated['documentImage'] = $path;
        }

        // تعيين الحالة الافتراضية "قيد الانتظار"
        $validated['status'] = 'pending';
        $validated['uploadDate'] = now();

        $document = MerchantDocument::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'تم رفع الوثيقة بنجاح وهي قيد المراجعة',
            'document' => $document
        ], 201);
    }

    /**
     * الحصول على حالة الوثيقة
     */
    public function checkStatus($documentId)
    {
        $document = MerchantDocument::findOrFail($documentId);

        return response()->json([
            'status' => 'success',
            'document_status' => $document->status,
            'document' => $document
        ]);
    }

    /**
     * تحديث حالة الوثيقة (للوحة التحكم)
     */
    public function updateStatus(Request $request, $documentId)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $document = MerchantDocument::findOrFail($documentId);
        $document->update(['status' => $request->status]);

        return response()->json([
            'status' => 'success',
            'message' => 'تم تحديث حالة الوثيقة',
            'document' => $document
        ]);
    }

     /**
     * جلب وثيقة التاجر
     *
     * @param  int  $merchantId
     * @return \Illuminate\Http\Response
     */
    public function show($merchantId)
    {
        try {
            $document = MerchantDocument::where('MerchantId', $merchantId)
                ->latest()
                ->first();

            if (!$document) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'لم يتم العثور على وثيقة للتاجر'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'document' => [
                    'documentId' => $document->documentId,
                    'documentType' => $document->documentType,
                    'documentImage' => asset('storage/' . $document->documentImage),
                    'uploadDate' => $document->uploadDate,
                    'status' => $document->status,
                    'created_at' => $document->created_at,
                    'updated_at' => $document->updated_at
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء جلب الوثيقة'
            ], 500);
        }
    }

    /**
     * جلب جميع وثائق التاجر
     *
     * @param  int  $merchantId
     * @return \Illuminate\Http\Response
     */
    public function index($merchantId)
    {
        try {
            $documents = MerchantDocument::where('MerchantId', $merchantId)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($document) {
                    return [
                        'documentId' => $document->documentId,
                        'documentType' => $document->documentType,
                        'documentImage' => asset('storage/' . $document->documentImage),
                        'uploadDate' => $document->uploadDate,
                        'status' => $document->status,
                        'created_at' => $document->created_at->format('Y-m-d H:i:s'),
                    ];
                });

            return response()->json([
                'status' => 'success',
                'documents' => $documents
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء جلب الوثائق'
            ], 500);
        }
    }
}
