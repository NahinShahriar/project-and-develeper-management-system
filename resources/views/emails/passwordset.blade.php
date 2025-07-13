<!DOCTYPE html>
<html>
<head>
    <title>Set Your Password</title>
</head>
<body>
    <h2>Welcome! {{ $name }}</h2>
    <h4>This is Your Temporary Passowrd:<strong>{{$password}}</strong></h4>
    <p> Please click the link below to set your password:</p>
    <p><a href="{{ $link }}">Set Password</a></p>
    <p>Thank you!</p>
</body>
</html>
