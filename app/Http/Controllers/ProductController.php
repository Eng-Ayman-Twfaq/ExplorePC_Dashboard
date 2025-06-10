<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Merchant; // تأكد من وجود هذا النموذج
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
{
    $query = Product::with(['merchant']);

    // فلترة حسب البحث
    if ($request->has('search') && $request->search != '') {
        $query->where('name', 'like', '%'.$request->search.'%')
              ->orWhere('description', 'like', '%'.$request->search.'%');
    }

    // فلترة حسب التاجر (التعديل الجديد)
    if ($request->has('MerchantId') && $request->MerchantId != '') {
        $query->where('MerchantId', $request->MerchantId);
    }

    // فلترة حسب الفئة
    if ($request->has('category') && $request->category != '') {
        $query->where('category', $request->category);
    }

    // فلترة حسب السعر
    if ($request->has('min_price') && $request->min_price != '') {
        $query->where('price', '>=', $request->min_price);
    }
    if ($request->has('max_price') && $request->max_price != '') {
        $query->where('price', '<=', $request->max_price);
    }

    // فلترة حسب الكمية
    if ($request->has('stock') && $request->stock != '') {
        if ($request->stock == 'in_stock') {
            $query->where('stockQuantity', '>', 0);
        } elseif ($request->stock == 'out_of_stock') {
            $query->where('stockQuantity', '<=', 0);
        }
    }

    // فلترة حسب التقييم
    if ($request->has('rating') && $request->rating != '') {
        $query->where('ratings', '>=', $request->rating);
    }

    // ترتيب النتائج
    if ($request->has('sort')) {
        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->latest();
                break;
            case 'rating':
                $query->orderBy('ratings', 'desc');
                break;
            default:
                $query->latest();
        }
    } else {
        $query->latest();
    }

    $products = $query->paginate(10);

    if ($request->wantsJson()) {
        return response()->json($products);
    }

    // جلب الفئات والتجار المتاحة لعرضها في الفلتر
    $categories = Product::select('category')->distinct()->pluck('category');
    $merchants = Merchant::select('MerchantId', 'name')->get(); // تأكد من استيراد نموذج Merchant

    return view('products.index', compact('products', 'categories', 'merchants'));
}

public function showFirstProduct()
{
    // جلب المنتج الأول حسب ID
     $product = Product::find(1); // أو Product::first()
    // $product = Product::where(3,"name","a"); // أو Product::first()

    if (!$product) {
        abort(404); // إذا لم يوجد منتج برقم 1
    }

    return view('products.show', compact('product'));

    // $products = Product::orderBy('created_at', 'desc')->get();

    // return view('products.show', compact('products'));
}

    public function create()
    {
        $merchants = Merchant::all(); // جلب جميع التجار
        return view('products.create', compact('merchants'));
    }

    // حفظ المنتج في قاعدة البيانات
    public function store(Request $request)
    {

       // dd($request->all());
        // التحقق من صحة البيانات
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'MerchantId' => 'required|exists:merchants,MerchantId',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stockQuantity' => 'required|integer|min:0',
            'category' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'ratings' => 'nullable|numeric|min:0|max:5'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;

            // للتأكد من المسار
            // \Log::info('Image saved at: ' . $imagePath);
        }
        // $validated['ratings'] = $validated['ratings'] ?? null;
        // إنشاء المنتج
        Product::create($validated);

        return redirect()->route('products.index')
                         ->with('success', 'تمت إضافة المنتج بنجاح!');
    }

    // public function edit(Product $product) // Route Model Binding
    // {
    //     return view('products.show', compact('product'));
    // }

    public function showAllProducts(Request $request)
{
    // try {
        // جلب جميع المنتجات مع العلاقات (إذا وجدت)
        $products = Product::with(['merchant'])
            ->latest()
            ->get();

        // إذا لم يكن هناك منتجات
        if ($products->isEmpty()) {
            return response()->json([
                'message' => 'لا توجد منتجات متاحة'
            ], 200);

            // أو لعرض صفحة بلاد بيانات:
            // return view('products.empty');
        }

        // عرض البيانات حسب نوع الطلب (API أو ويب)
        if ($request->wantsJson()) {
            return response()->json($products);
        }

        return view('products.show', compact('products'));

    // } catch (\Exception $e) {
    //     \Log::error('خطأ في عرض المنتجات: ' . $e->getMessage());

    //     return back()->with('error', 'حدث خطأ تقني. الرجاء المحاولة لاحقاً');
    // }
}

public function destroy($productId)
    {
        // try {
            // البحث عن المنتج أو إظهار خطأ 404 إذا لم يوجد
            $product = Product::findOrFail($productId);

            // حذف الصورة المرفقة إذا كانت موجودة
            if ($product->image && Storage::exists($product->image)) {
                Storage::delete($product->image);
            }

            // حذف المنتج من قاعدة البيانات
            $product->delete();

            return redirect()->route('products.index')
                           ->with('success', 'تم حذف المنتج بنجاح');

        // } catch (\Exception $e) {
        //     \Log::error('خطأ في حذف المنتج: ' . $e->getMessage());

        //     return back()->with('error', 'حدث خطأ أثناء حذف المنتج');
        // }
    }

     /**
     * عرض نموذج التعديل
     */
    public function edit($productId)
    {
        $product = Product::findOrFail($productId);
        $merchants = Merchant::all();
        return view('products.edit', compact('product', 'merchants'));
    }

    /**
     * تحديث المنتج في قاعدة البيانات
     */
    public function update(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $validated = $request->validate([
            // 'MerchantId' => 'required|exists:merchants,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'stockQuantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ratings' => 'nullable|numeric|min:0|max:5'
        ]);

        // تحديث الصورة إذا تم رفع جديدة
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إن وجدت
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $product->update($validated);

        return redirect()->route('products.index')
                        ->with('success', 'تم تحديث المنتج بنجاح');
    }

    public function show(Product $product)
{
    // تحميل العلاقات إذا لزم الأمر
    $product->load('merchant', 'reviews.user');

    return view('products.show', compact('product'));
}
}
