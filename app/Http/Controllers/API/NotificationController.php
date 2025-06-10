<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Custom;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function index(Request $request)
{
    // التحقق من أن الطلب POST
    if (!$request->isMethod('post')) {
        return response()->json([
            'success' => false,
            'message' => 'يجب استخدام طريقة POST'
        ], 405); // 405 Method Not Allowed
    }

    // التحقق من وجود user_id في الجسم (body)
    if (!$request->has('user_id')) {
        return response()->json([
            'success' => false,
            'message' => 'يجب إرسال user_id'
        ], 400); // 400 Bad Request
    }

    // التحقق من أن المستخدم موجود
    $userExists = Custom::where('UserId', $request->user_id)->exists();
    if (!$userExists) {
        return response()->json([
            'success' => false,
            'message' => 'المستخدم غير موجود'
        ], 404); // 404 Not Found
    }

    // جلب الإشعارات مع تحسين الأداء
    $notifications = Notification::with(['user' => function($query) {
            $query->select('UserId', 'UserName'); // جلب الحقول الضرورية فقط
        }])
        ->where('user_id', $request->user_id)
        ->orWhereNull('user_id')
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json([
        'success' => true,
        'data' => $notifications,
        'message' => 'تم جلب الإشعارات بنجاح'
    ]);
}
//     /**
//      * عرض الإشعارات للمستخدم
//      * 
//      * @param Request $request
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function index(Request $request)
// {
//     $user = $request->user();
    
//     // جلب الإشعارات الخاصة بالمستخدم أو العامة (user_id = null)
//     $notifications = Notification::where('user_id', $user->UserId) // تم التعديل هنا لاستخدام UserId بدلاً من id
//         ->orWhereNull('user_id')
//         ->orderBy('created_at', 'desc')
//         ->paginate(15);

//     return response()->json([
//         'success' => true,
//         'data' => $notifications,
//         'message' => 'تم جلب الإشعارات بنجاح'
//     ]);
// }

//     /**
//      * عرض تفاصيل إشعار معين
//      * 
//      * @param Notification $notification
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function show(Notification $notification)
//     {
//         return response()->json([
//             'success' => true,
//             'data' => $notification,
//             'message' => 'تم جلب الإشعار بنجاح'
//         ]);
//     }

//     /**
//      * تحديث حالة الإشعار كمقروء
//      * 
//      * @param Notification $notification
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function markAsRead(Notification $notification)
//     {
//         $notification->update(['is_read' => true]);

//         return response()->json([
//             'success' => true,
//             'message' => 'تم تحديث حالة الإشعار كمقروء'
//         ]);
//     }
}