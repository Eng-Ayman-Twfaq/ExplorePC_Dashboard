<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Mail\ResetPasswordMail;
use Illuminate\Http\Request;
use App\Models\Custom;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Str;
class CustomerAuthController extends Controller
{
    //
    /**
     * Register a new customer
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'UserName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customs,email',
            'UserPassword' => 'required|string|min:6',
            'Phone' => 'required|numeric',
            'Address' => 'required|string|max:255',
            'Image' => 'nullable|string',
        ], [
            'email.unique' => 'هذا البريد الإلكتروني مسجل مسبقاً',
            'required' => 'حقل :attribute مطلوب',
            'min' => 'حقل :attribute يجب أن يكون على الأقل :min أحرف',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'فشل في التسجيل',
                'errors' => $validator->errors()
            ], 422);
        }

        $customer = Custom::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'تم التسجيل بنجاح',
            'customer' => new CustomerResource($customer)
        ], 201);
    }

    public function updateProfile(Request $request, $id)
{
    try {
        $customer = Custom::where('UserId', $id)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'UserName' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:customs,email,'.$customer->UserId.',UserId',
            'UserPassword' => 'sometimes|string|min:6',
            'Phone' => 'sometimes|numeric',
            'Address' => 'sometimes|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only(['UserName', 'email', 'Phone', 'Address']);
        
        if ($request->UserPassword) {
            $data['UserPassword'] = $request->UserPassword;
        }

        $customer->update($data);

        return response()->json([
            'status' => true,
            'message' => 'تم التحديث بنجاح',
            'data' => $customer
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'حدث خطأ في السيرفر',
            'error' => $e->getMessage()
        ], 500);
    }
}

    /**
     * Login customer and create token
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
{
    // التحقق من صحة البيانات المدخلة
    $request->validate([
        'email' => 'required|string|email',
        'UserPassword' => 'required|string',
    ]);

    // البحث عن العميل بواسطة البريد الإلكتروني
    $customer = Custom::where('email', $request->email)->first();

    // التحقق من وجود العميل ومطابقة كلمة المرور كنص صريح
    if (!$customer || $request->UserPassword != $customer->UserPassword) {
        throw ValidationException::withMessages([
            'email' => ['بيانات الدخول غير صحيحة'],
        ]);
    }

    // إنشاء توكن للعميل (إذا كنت تستخدم Sanctum/Passport)
    // $token = $customer->createToken('customer_token')->plainTextToken;

    // إرجاع الاستجابة
    return response()->json([
        'message' => 'تم تسجيل الدخول بنجاح',
        'customer' => new CustomerResource($customer),
        // 'token' => $token,
    ], 200);
}

    /**
     * Logout customer (Revoke the token)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    /**
     * Get the authenticated Customer
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function profile(Request $request)
    {
        return response()->json([
            'customer' => new CustomerResource($request->user()),
        ]);
    }




public function updateImage(Request $request, $id)
{
    // 1. التحقق من صحة البيانات
    $validator = Validator::make($request->all(), [
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation error',
            'errors' => $validator->errors()
        ], 422);
    }

    // 2. البحث عن العميل
    $custom = Custom::find($id);

    if (!$custom) {
        return response()->json([
            'status' => false,
            'message' => 'User not found'
        ], 404);
    }

    // 3. حفظ الصورة الجديدة
    try {
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($custom->Image) {
                Storage::disk('public')->delete($custom->Image);
            }
            
            // حفظ الصورة الجديدة
            $imagePath = $request->file('image')->store('customers', 'public');
            $custom->Image = $imagePath;
            $custom->save();
        }

        return response()->json([
            'status' => true,
            'message' => 'Image updated successfully',
            'data' => [
                'image_url' => Storage::url($imagePath) // إرجاع رابط الصورة الكامل
            ]
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to update image',
            'error' => $e->getMessage()
        ], 500);
    }
}

   /**
 * الحصول على رابط صورة العميل حسب المعرف
 *
 * @param int $id
 * @return \Illuminate\Http\JsonResponse
 */
public function getCustomerImage($id)
{
    try {
        // البحث عن العميل
        $customer = Custom::find($id);

        if (!$customer) {
            return response()->json([
                'status' => false,
                'message' => 'Customer not found'
            ], 404);
        }

        // التحقق من وجود صورة للعميل
        if (empty($customer->Image)) {
            return response()->json([
                'status' => false,
                'message' => 'Customer does not have an image'
            ], 404);
        }

        // إرجاع رابط الصورة الكامل
        return response()->json([
            'status' => true,
            'message' => 'Customer image retrieved successfully',
            'data' => [
                'image_url' => Storage::url($customer->Image),
                // أو يمكنك استخدام:
                // 'image_url' => asset('storage/'.$customer->Image)
            ]
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to retrieve customer image',
            'error' => $e->getMessage()
        ], 500);
    }
} 

// في Controller
public function forgotPassword(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email|exists:customs,email',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'البريد الإلكتروني غير مسجل'
        ], 422);
    }

    $customer = Custom::where('email', $request->email)->first();
    $token = Str::random(60);

    $customer->update([
        'reset_token' => $token,
        'reset_token_expires_at' => now()->addHours(2)
    ]);

    // إرسال البريد الإلكتروني
    Mail::to($customer->email)->send(new ResetPasswordMail($token));

    return response()->json([
        'status' => true,
        'message' => 'تم إرسال رابط إعادة التعيين إلى بريدك الإلكتروني'
    ]);
}

public function resetPassword(Request $request)
{
    $validator = Validator::make($request->all(), [
        'token' => 'required',
        'password' => 'required|string|min:6|confirmed',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    $customer = Custom::where('reset_token', $request->token)->first();

    if (!$customer) {
        return response()->json([
            'status' => false,
            'message' => 'رابط إعادة التعيين غير صالح أو منتهي الصلاحية'
        ], 400);
    }

    $customer->UserPassword = bcrypt($request->password);
    $customer->reset_token = null;
    $customer->save();

    return response()->json([
        'status' => true,
        'message' => 'تم إعادة تعيين كلمة المرور بنجاح'
    ]);
}

}
