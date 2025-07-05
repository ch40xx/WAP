<?php
// register.php

require_once 'includes/config.php';
require_once 'includes/functions.php';

// Initialize message
$message = "";
$courses = ['Computer Science', 'Information Technology', 'Electronics', 'Civil Engineering', 'Business Studies'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim(sanitizeInput($_POST['full_name']));
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone = sanitizeInput($_POST['phone']);
    $course = sanitizeInput($_POST['course']);

    if (empty($full_name)) {
        $message = "Full name is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    } elseif (!in_array($course, $courses)) {
        $message = "Invalid course selection.";
    } elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters long.";
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $message = "Phone number must be exactly 10 digits.";
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM students WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $message = "Email already registered.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO students (full_name, email, password, phone, course) VALUES (?, ?, ?, ?, ?)");
            $success = $stmt->execute([$full_name, $email, $hashed_password, $phone, $course]);

            if ($success) {
                header("Location: login.php?registered=1");
                exit();
            } else {
                $message = "Failed to register. Try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register - Student Portal</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
  <main class="max-w-lg mx-auto mt-10 bg-white p-8 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-700">Create Student Account</h2>

    <?php if (!empty($message)): ?>
      <div class="mb-4 p-4 bg-red-100 text-red-700 border border-red-300 rounded">
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="space-y-5" novalidate>
      <div>
        <label class="block text-sm font-medium text-gray-700">Full Name</label>
        <input type="text" name="full_name" required pattern="^[a-zA-Z\s]+$" title="Only letters and spaces allowed" class="w-full px-4 py-2 border rounded-lg"/>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" required title="Enter a valid email" class="w-full px-4 py-2 border rounded-lg"/>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" name="password" required minlength="6" class="w-full px-4 py-2 border rounded-lg"/>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
        <input type="password" name="confirm_password" required minlength="6" class="w-full px-4 py-2 border rounded-lg"/>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Phone Number</label>
        <input type="text" name="phone" required pattern="^\d{10}$" maxlength="10" title="Phone number must be exactly 10 digits" class="w-full px-4 py-2 border rounded-lg"/>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Course</label>
        <select name="course" required class="w-full px-4 py-2 border rounded-lg">
          <option value="" disabled selected>Select a course</option>
          <?php foreach ($courses as $c): ?>
            <option value="<?= $c ?>"><?= $c ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="text-center space-y-3">
        <button type="submit" class="bg-gray-800 text-white px-6 py-2 rounded hover:bg-gray-700">Register</button>
        <div>
          <a href="index.php" class="inline-block text-sm text-gray-600 hover:underline">← Back to Home</a>
        </div>
      </div>
    </form>
  </main>
</body>
</html>
