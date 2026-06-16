<!DOCTYPE html>
<html>
<head>
    <title>Register Admin</title>
</head>
<body>
    <h1>Register Admin</h1>
    <form action="<?= site_url('auth/create_register_staff'); ?>" method="post">
	<label>Username:</label>
		<input type="text" name="username" required><br>
		<label>Password:</label>
		<input type="password" name="password" required><br>
		<label>Email:</label>
		<input type="email" name="email" required><br>
		<label>Nama Lengkap:</label>
		<input type="text" name="namalengkap" required><br>
		<label>Alamat:</label>
		<input type="text" name="alamat" required><br>
		<button type="submit">Register</button>
	</form>
</body>
</html>
