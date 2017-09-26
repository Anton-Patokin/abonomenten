<!DOCTYPE html>
<html>
<header>

</header>
<body>
<div>
    <?php echo isset($error) ? $error : "" ?>
</div>
<form method="post">
    <label>UserName</label>
    <input type="text" name="username">
    <label>Password</label>
    <input type="text" name="password">
    <button type="submit" value="login">Login</button>
</form>

</body>
</html>