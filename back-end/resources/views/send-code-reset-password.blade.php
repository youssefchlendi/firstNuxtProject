@component('mail::message')
<h1>لقد تلقينا طلبك لإعادة تعيين كلمة مرور حسابك </h1>
<p>يمكنك استخدام التعليمة الرمز التالي لاسترداد حسابك: </p>

@component('mail::panel')
{{ $code }}
@endcomponent
<p><a href="{{ env('FRONTEND_URL') }}/reset-password">الرابط</a> </p>
<p> المدة المسموح بها للرمز هي ساعة واحدة من وقت إرسال الرسالة </p>
@endcomponent
