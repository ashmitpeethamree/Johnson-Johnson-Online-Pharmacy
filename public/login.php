<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Login</title>
<link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
<h2>Login</h2>

<form action="../src/auth_login.php" method="post" id="loginForm" novalidate>

  <label>Email
    <input type="email" name="email" required maxlength="150">
  </label>

  <label>Password
    <input type="password" name="password" required minlength="8">
  </label>

  <button type="submit" class="button">Login</button>

</form>

</body>
</html>