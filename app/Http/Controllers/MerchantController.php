<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    /**
     * عرض قائمة التجار
     */
    // public function index()
    // {
    //     $merchants = Merchant::all();
    //     return view('merchants.index', compact('merchants'));
    // }
    public function index(Request $request)
    {
        $merchants = Merchant::query();

        // فلترة حسب اسم التاجر
        if ($request->has('name') && $request->name != '') {
            $merchants->where('name', 'like', '%'.$request->name.'%');
        }

        // فلترة حسب اسم المتجر
        if ($request->has('storename') && $request->storename != '') {
            $merchants->where('storename', 'like', '%'.$request->storename.'%');
        }

        // فلترة حسب التقييم
        if ($request->has('rating') && $request->rating != '') {
            $merchants->where('rating', '>=', $request->rating);
        }

        $merchants = $merchants->paginate(10);

        return view('merchants.index', compact('merchants'));
    }
    /**
     * عرض نموذج إضافة تاجر جديد
     */
    public function create()
    {
        return view('merchants.create');
    }

    /**
     * حفظ التاجر الجديد في قاعدة البيانات
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'storename' => 'required|string|max:255',
            'email' => 'nullable|email|unique:merchants,email',
            'phoneNumber' => 'required|string|max:20',
            'Address' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5',
            'password' => 'nullable|string|min:6' // جعل كلمة السر اختيارية
        ]);

        $merchantData = $validated;
        if (isset($validated['password'])) {
            $merchantData['password'] = bcrypt($validated['password']);
        }
    
        Merchant::create($merchantData);
    
        return redirect()->route('merchants.index')
            ->with('success', 'تم إضافة التاجر بنجاح');
    }

    /**
     * عرض بيانات تاجر معين
     */
    public function show(Merchant $merchant)
    {
        return view('merchants.show', compact('merchant'));
    }

    /**
     * عرض نموذج تعديل التاجر
     */
   // app/Http/Controllers/MerchantController.php

// دالة التعديل
public function edit($MerchantId)
{
    $merchant = Merchant::findOrFail($MerchantId);
    return view('merchants.edit', compact('merchant'));
}

// دالة التحديث
public function update(Request $request, $MerchantId)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'storename' => 'required|string|max:255',
        'email' => 'nullable|email|unique:merchants,email,'.$MerchantId.',MerchantId',
        'phoneNumber' => 'required|string|max:20',
        'Address' => 'nullable|string',
        'rating' => 'nullable|numeric|min:0|max:5'
    ]);

    $merchant = Merchant::findOrFail($MerchantId);
    $merchant->update($validated);

    return redirect()->route('merchants.index')
        ->with('success', 'تم تحديث بيانات التاجر بنجاح');
}

// دالة الحذف
public function destroy($MerchantId)
{
    $merchant = Merchant::findOrFail($MerchantId);
    $merchant->delete();

    return redirect()->route('merchants.index')
        ->with('success', 'تم حذف التاجر بنجاح');
}
}
