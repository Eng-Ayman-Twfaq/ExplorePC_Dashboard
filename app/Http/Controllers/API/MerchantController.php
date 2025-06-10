<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MerchantResource;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MerchantController extends Controller
{
     /**
     * تسجيل تاجر جديد عبر API
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:merchants,email',
            'phoneNumber' => 'required|string|max:20',
            'password' => 'required|string|min:6',
            'storename' => 'required|string|max:255',
            'Address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $merchant = Merchant::create([
            'name' => $request->name,
            'email' => $request->email,
            'phoneNumber' => $request->phoneNumber,
            'password' => Hash::make($request->password),
            'storename' => $request->storename,
            'Address' => $request->Address,
        ]);

        // إنشاء token لواجهة API
        // $token = $merchant->createToken('merchant_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'تم تسجيل التاجر بنجاح',
            'merchant' => new MerchantResource($merchant),
            // 'token' => $token
        ], 201);
    }

    /**
     * عرض جميع التجار
     */
    public function index()
    {
        $merchants = Merchant::all();
        return MerchantResource::collection($merchants);
    }

    /**
     * عرض تاجر معين
     */
    public function show(Merchant $merchant)
    {
        return new MerchantResource($merchant);
    }

    /**
     * تحديث بيانات التاجر
     */
    public function update(Request $request, Merchant $merchant)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:merchants,email,'.$merchant->MerchantId,
            'phoneNumber' => 'sometimes|string|max:20',
            'storename' => 'sometimes|string|max:255',
            'Address' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5',
            'password' => 'nullable|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $updateData = $request->only(['name', 'email', 'phoneNumber', 'storename', 'Address', 'rating']);

        if ($request->has('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $merchant->update($updateData);

        return new MerchantResource($merchant);
    }

    /**
     * حذف التاجر
     */
    public function destroy(Merchant $merchant)
    {
        $merchant->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'تم حذف التاجر بنجاح'
        ]);
    }

    /**
     * تسجيل الدخول للتاجر
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $merchant = Merchant::where('email', $request->email)->first();

        if (!$merchant || !Hash::check($request->password, $merchant->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'بيانات الاعتماد غير صحيحة'
            ], 401);
        }

        // $token = $merchant->createToken('merchant_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'تم تسجيل الدخول بنجاح',
            'merchant' => new MerchantResource($merchant),
            // 'token' => $token
        ]);
    }

    /**
     * تسجيل الخروج
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'تم تسجيل الخروج بنجاح'
        ]);
    }
}
