<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Custom;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.notifications.index', compact('notifications'));
    }

    public function create()
    {
        $users = Custom::all();
        return view('admin.notifications.create', compact('users'));
    }

    public function createAll()
    {
        return view('admin.notifications.create-all');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'user_id' => 'nullable|exists:customs,UserId'
        ]);

        Notification::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'message' => $request->message,
        ]);

        return redirect()->route('admin.notifications.index')
            ->with('success', 'تم إرسال الإشعار بنجاح');
    }

    public function storeAll(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        Notification::create([
            'title' => $request->title,
            'message' => $request->message,
        ]);

        return redirect()->route('admin.notifications.index')
            ->with('success', 'تم إرسال الإشعار لجميع المستخدمين بنجاح');
    }

    public function edit(Notification $notification)
    {
        $users = Custom::all();
        return view('admin.notifications.edit', compact('notification', 'users'));
    }

    public function update(Request $request, Notification $notification)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'user_id' => 'nullable|exists:customs,UserId'
        ]);

        $notification->update([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'message' => $request->message,
        ]);

        return redirect()->route('admin.notifications.index')
            ->with('success', 'تم تحديث الإشعار بنجاح');
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        
        return redirect()->route('admin.notifications.index')
            ->with('success', 'تم حذف الإشعار بنجاح');
    }
}
