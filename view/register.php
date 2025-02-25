<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form action="/nihon/register" method="POST" class="needs-validation" novalidate>
    <div class="mb-3">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div class="mb-3">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div class="mb-3">
        <label for="password" >Password</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div class="mb-3">
        <label for="password_verify" >Password Verify</label>
        <input type="password" id="password_verify" name="password_verify" required>
    </div>
    <button type="submit">Register</button>
</form>


</body>
</html>