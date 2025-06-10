<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;
use App\Models\Custom;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    //
    public function store(Request $request)
    {
        // 1. التحقق من صحة البيانات
        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric|digits_between:9,15'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'رقم الهاتف غير صحيح'
            ], 422);
        }

        // 2. محاولة حفظ البيانات مع معالجة الأخطاء
        try {
            DB::table('password_reset_requests')->insert([
                'phone' => $request->phone,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'تم استلام طلبك بنجاح'
            ]);

        } catch (\Exception $e) {
            Log::error('فشل حفظ طلب استعادة كلمة المرور: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء معالجة طلبك'
            ], 500);
        }
    }


    public function sendVerificationCode(Request $request) {
        $request->validate(['email' => 'required|email|exists:customs,email']);
    
        $code = Str::random(6); // أو استخدم rand(100000, 999999)
        
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $code, 'created_at' => now()]
        );
    
        Mail::to($request->email)->send(new VerificationCodeMail($code));
    
        return response()->json(['message' => 'تم إرسال الرمز']);
    }

    public function resetPassword(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|size:6',
            'new_password' => 'required|min:8',
        ]);
    
        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->code)
            ->first();
    
        if (!$record) {
            return response()->json(['error' => 'الرمز غير صحيح'], 400);
        }
    
        Custom::where('email', $request->email)
            ->update(['UserPassword' => $request->new_password]);
    
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
    
        return response()->json(['message' => 'تم تغيير كلمة السر']);
    }
}
