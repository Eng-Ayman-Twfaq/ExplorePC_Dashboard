<!DOCTYPE html>
<html>
<head>
    <title>إعادة تعيين كلمة المرور</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3490dc;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>إعادة تعيين كلمة المرور</h2>
        <p>مرحباً،</p>
        <p>لقد تلقينا طلباً لإعادة تعيين كلمة المرور الخاصة بحسابك.</p>
        <p>الرجاء الضغط على الزر أدناه لإعادة تعيين كلمة المرور:</p>
        
        <a href="{{ $resetUrl }}" class="button">إعادة تعيين كلمة المرور</a>
        
        <p>إذا لم تطلب إعادة تعيين كلمة المرور، يمكنك تجاهل هذا البريد.</p>
        <p>شكراً لك،<br>فريق التطبيق</p>
    </div>
</body>
</html>