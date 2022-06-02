<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kalendas - Verify email</title>
</head>
<body>
    <h2>Kalendas - Verify email</h2>
    <p>You successfully registered in Kalendas! There's only one step left, you need to verify your email address</p>
    <a href="{{$url}}">Click here to validate your account</a>

    <img src="{{ $message->embed(asset('/img/logo.png')) }}">
</body>
</html>