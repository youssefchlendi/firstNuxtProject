<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify($user_id, Request $request)
    {
        if (!$request->hasValidSignature()) {
            return response()->json([
                "header" => "رمز تحقق غير صحيح",
                "msg" => "رمز التحقق غير صحيح, الرجاء طلب رابط جديد",
                "status" => "invalid"
            ], 400);
        }

        $user = User::findOrFail($user_id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            return response()->json(
                [
                    "header" => "تم التحقق من البريد الإلكتروني",
                    "msg" => ". الرجاء تسجيل الدخول. \n ,تم تأكيد البريد الإلكتروني بنجاح",
                    "status" => "success"],
                    200);
        } else {
            return response()->json([
                "header" => "البريد الإلكتروني مفعل",
                "msg" => "البريد الإلكتروني مؤكد. الرجاء تسجيل الدخول. \n سوف يتم تحويلك إلى صفحة الدخول",
                "status" => "already_verified"
            ], 400);
        }
    }

    public function resend($email)
    {
        $user = User::where('email', $email)->first();
        if ($user->hasVerifiedEmail()) {
            return response()->json(["msg" => "البريد الإلكتروني مؤكد, سوف يتم اعادة توجيهك الى صفحة تسجيل الدخول,"], 400);
        }

        $user->sendEmailVerificationNotification();

        return response()->json(["msg" => "تم إعادة إرسال رابط التحقق بنجاح"], 200);
    }
}
