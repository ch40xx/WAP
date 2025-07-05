<?php

// Start session
session_start();

// Include database config and functions
require_once 'includes/config.php';
require_once 'includes/functions.php';

// If user is already logged in then redirect to dashboard
if (isset($_SESSION['student_id'])) {
    header('Location: dashboard.php');
    exit();
}

// Initialize error message
$error = '';

// When login form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize email and password
    $email = sanitizeInput($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    }

    $password = $_POST['password']; // no need to sanitize password

    // Prepare and execute query to find user by email
    $stmt = $pdo->prepare("SELECT * FROM students WHERE email = ?");
    $stmt->execute([$email]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if user exists and password is correct
    if ($student && password_verify($password,$student['password'])) {
        // Store user ID in session
        $_SESSION['student_id'] = $student['id'];

        // Redirect to dashboard
        header('Location: dashboard.php');
        exit();
    } else {
        // Invalid credentials
        $error = "Invalid email or password. Try again.";
    }
}
?>

<!-- HTML PART BELOW -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Student Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative bg-gray-100 text-gray-800 min-h-screen flex items-center justify-center">
  <div class="absolute inset-0 -z-10">
    <svg class="w-full h-full opacity-10" xmlns="http://www.w3.org/2000/svg" fill="none">
      <defs>
        <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
          <path d="M 40 0 L 0 0 0 40" fill="none" stroke="gray" stroke-width="0.9"/>
        </pattern>
      </defs>
      <rect width="100%" height="100%" fill="url(#grid)" />
    </svg>
  </div>
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
        <h2 class="text-2xl font-semibold mb-6 text-center">Student Portal Login</h2>

        <!-- Show error if any -->
        <?php if ($error): ?>
            <div class="bg-red-100 text-red-700 px-4 py-2 mb-4 rounded">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <!-- Login form starts here -->
        <form method="POST" action="">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium">Email</label>
                <input type="email" name="email" id="email" required class="w-full mt-1 px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium">Password</label>
                <input type="password" name="password" id="password" required class="w-full mt-1 px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <button type="submit" class="w-full bg-gray-800 hover:bg-gray-700 text-white py-2 rounded">Login</button>
         <div>
          <a href="index.php" class="inline-block text-sm text-gray-600 hover:underline">← Back to Home</a>
        </div>
        </form>
    </div>
</body>
</html>
 
<?php
// I used filter_var() to validate the email format
// This helps make sure the user didn’t type something invalid like "abc@"
// If invalid, I stop the login/register/update and show an error message
?>
