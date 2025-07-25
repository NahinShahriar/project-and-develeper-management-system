<!DOCTYPE html>
<html>
<head>
    <title>Set Your Password</title>
</head>
<body>
    <h2>Hello {{ $user->name }},</h2>
    <p>You requested to reset your password. Click the link below to continue:</p>

    <a href="{{ url('reset-password/'.$token) }}?email={{ urlencode($user->email) }}">Reset Password</a>

    <p>If you didn't request this, please ignore the email.</p>
    <p>Thank you!</p>
</body>
</html>
