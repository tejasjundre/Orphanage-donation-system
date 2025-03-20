<?php session_start(); include '../layouts/header.php'; ?>
<h2>Login</h2>
<form action="../../controllers/AuthController.php" method="post">
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <button type="submit" name="login" class="btn btn-primary">Login</button>
</form>
<?php include '../layouts/footer.php'; ?>