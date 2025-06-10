<?php

namespace App\Http\Controllers;

use App\Models\PasswordResetRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    public function index()
    {
        $requests = PasswordResetRequest::orderBy('created_at', 'desc')->get();
        return view('password-reset-requests.index', compact('requests'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:completed'
        ]);

        $resetRequest = PasswordResetRequest::findOrFail($id);
        $resetRequest->update($validated);

        return redirect()
            ->route('password-reset-requests.index')
            ->with('success', 'تم تحديث حالة الطلب بنجاح');
    }
}