<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <form action="register" method="post">
        <input type="text" name="username" placeholder="Username" required>
        <?php if (!empty($errors['username'])): ?>
            <span><?php echo $errors['username']; ?></span>
        <?php endif; ?>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit">Register</button>
    </form>
</body>
</html>