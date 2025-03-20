<?php session_start(); include '../layouts/header.php'; ?>
<h2>Register</h2>
<form action="../../controllers/AuthController.php" method="post">
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select class="form-control" id="role" name="role" required>
            <option value="institution">Institution</option>
            <option value="donor">Donor</option>
            <option value="supplier">Supplier</option>
            <option value="admin">Admin</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <textarea class="form-control" id="address" name="address" required></textarea>
    </div>
    <div class="mb-3">
        <label for="contact_info" class="form-label">Contact Info</label>
        <input type="text" class="form-control" id="contact_info" name="contact_info" required>
    </div>
    <button type="submit" name="register" class="btn btn-primary">Register</button>
</form>
<?php include '../layouts/footer.php'; ?>