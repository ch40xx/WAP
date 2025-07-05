<?php
// dashboard.php

// Start session and protect page
require_once 'includes/auth.php'; // redirects to login if not logged in

// DB connection and functions
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Get logged-in student ID from session
$student_id = $_SESSION['student_id'];

// Get student details from DB
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$student_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

// If student not found somehow (corrupt session), logout
if (!$student) {
    header('Location: logout.php');
    exit();
}
?>

<!-- HTML PART -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Student Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white shadow p-4 flex justify-between items-center">
        <div class="text-xl font-bold">Student Portal</div>
        <div>
            <a href="update_profile.php" class="text-blue-500 hover:underline mr-4">Update Profile</a>
            <a href="logout.php" class="text-red-500 hover:underline">Logout</a>
        </div>
    </nav>

    <!-- Profile Section -->
    <div class="max-w-2xl mx-auto mt-10 bg-white shadow-md rounded p-6">
        <h2 class="text-2xl font-semibold mb-4">Welcome, <?= htmlspecialchars($student['full_name']) ?> 👋</h2>

        <!-- Profile Image -->
        <?php if (!empty($student['profile_pic'])): ?>
            <img src="<?= htmlspecialchars($student['profile_pic']) ?>" alt="Profile Photo" class="w-32 h-32 object-cover rounded-full mb-4">
        <?php else: ?>
            <div class="w-32 h-32 rounded-full bg-gray-300 mb-4 flex items-center justify-center text-gray-600">
                No Photo
            </div>
        <?php endif; ?>

        <!-- Student Info -->
        <ul class="space-y-2 text-lg">
            <li><strong>Full Name:</strong> <?= htmlspecialchars($student['full_name']) ?></li>
            <li><strong>Email:</strong> <?= htmlspecialchars($student['email']) ?></li>
            <li><strong>Phone:</strong> <?= htmlspecialchars($student['phone']) ?></li>
            <li><strong>Course:</strong> <?= htmlspecialchars($student['course']) ?></li>
        </ul>
    </div>
</body>
</html>

// First I checked if the session is active using includes/auth.php
// Then I fetched the student info from the database using the ID stored in the session
// If somehow the student is not found, I redirected to logout (maybe session is tampered)
// In the frontend, I used Tailwind to design a clean profile card
// The profile picture is shown if available, else a placeholder circle is shown
// Below that, I displayed all main student details: name, email, phone, course

