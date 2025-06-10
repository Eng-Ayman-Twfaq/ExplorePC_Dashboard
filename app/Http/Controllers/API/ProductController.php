<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //
    public function index(Request $request)
{
    // إنشاء استعلام أساسي
    $query = Product::query();

    // تطبيق شرط التصفية إذا وُجد معامل `category` في الطلب
    if ($request->has('category')) {
        $query->where('category', $request->category);
    }

    // جلب النتائج
    $products = $query->get();

    if ($products->count() > 0) {
        return ProductResource::collection($products);
    } else {
        return response()->json([
            'message' => 'لا توجد منتجات متاحة بناءً على معايير البحث'
        ], 200);
    }
}

 /**
     * عرض جميع منتجات التاجر
     *
     * @param  int  $merchantId
     * @return \Illuminate\Http\Response
     */
    public function indexId($merchantId)
    {
        try {
            $products = Product::where('MerchantId', $merchantId)
                ->with('merchant')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($product) {
                    return [
                        'productId' => $product->productId,
                        'name' => $product->name,
                        'description' => $product->description,
                        'price' => $product->price,
                        'category' => $product->category,
                        'stockQuantity' => $product->stockQuantity,
                        'image' => $product->image ? asset('storage/' . $product->image) : null,
                        'ratings' => $product->calculateAverageRating(),
                        'created_at' => $product->created_at->format('Y-m-d H:i:s'),
                    ];
                });

            return response()->json([
                'status' => 'success',
                'products' => $products
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء جلب المنتجات'
            ], 500);
        }
    }

    /**
     * إضافة منتج جديد
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'MerchantId' => 'required|exists:merchants,MerchantId',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'stockQuantity' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $imagePath = $request->file('image')->store('products', 'public');

            $product = Product::create([
                'MerchantId' => $request->MerchantId,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'category' => $request->category,
                'stockQuantity' => $request->stockQuantity,
                'image' => $imagePath,
                'ratings' => 0,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'تم إضافة المنتج بنجاح',
                'product' => [
                    'productId' => $product->productId,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => asset('storage/' . $product->image),
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء إضافة المنتج'
            ], 500);
        }
    }

    /**
 * تحديث بيانات المنتج
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function update(Request $request, $productId)
{
    $product = Product::findOrFail($productId);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'category' => 'required|string|max:255',
        'stockQuantity' => 'required|integer|min:0',
        'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // استقبال البيانات مباشرة بدون حاجة إلى only()
    $product->name = $validated['name'];
    $product->description = $validated['description'];
    $product->price = $validated['price'];
    $product->category = $validated['category'];
    $product->stockQuantity = $validated['stockQuantity'];

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public');
        $product->image = $path;
    }

    $product->save();

    return response()->json([
        'status' => 'success',
        'message' => 'تم التحديث بنجاح',
        'product' => $product
    ], 200);
}
/**
 * حذف منتج
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function destroy($id)
{
    try {
        $product = Product::findOrFail($id);

        // حذف الصورة إذا كانت موجودة
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'تم حذف المنتج بنجاح'
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'حدث خطأ أثناء حذف المنتج'
        ], 500);
    }
}
}
