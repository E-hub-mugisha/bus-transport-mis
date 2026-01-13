<!DOCTYPE html>
<html>
<head>
    <title>Driver Account Credentials</title>
</head>
<body>
    <p>Hello {{ $name }},</p>
    <p>Your driver account has been created. Here are your login credentials:</p>
    <ul>
        <li>Email: {{ $email }}</li>
        <li>Password: {{ $password }}</li>
    </ul>
    <p>Please login and change your password as soon as possible.</p>
    <p>Thank you!</p>
</body>
</html>
