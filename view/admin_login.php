<form method="POST" action="/dashboard-access">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? '' ?>">
    <label for="username">Username:</label>
    <input type="text" name="credential" required>

    <label for="password">Password:</label>
    <input type="password" name="password" required>

    <button type="submit">Login</button>
</form>