<?php
// dashboard.php

require_once 'includes/config.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';

// Get student info from database using session ID
$student_id = $_SESSION['student_id'];
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$student_id]);
$student = $stmt->fetch();

// Redirect if not found
if (!$student) {
    header("Location: logout.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard - Student Portal</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

  <!-- Navbar -->
  <nav class="bg-gray-800 text-white shadow">
    <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
      <h1 class="text-xl font-semibold">Web Application Programming | Student Portal</h1>
      <div class="space-x-6">
        <a href="index.php" class="hover:underline">Home</a>
        <a href="update_profile.php" class="hover:underline">Update Profile</a>
        <a href="logout.php" class="hover:underline text-red-300">Logout</a>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="max-w-3xl mx-auto mt-10 p-6 bg-white rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-center">👋 Welcome, <?= htmlspecialchars($student['full_name']) ?></h2>

    <!-- Profile Card -->
    <div class="flex flex-col md:flex-row items-center gap-6">
      <img
        src="<?= $student['profile_pic'] ? htmlspecialchars($student['profile_pic']) : 'uploads/default.png' ?>"
        alt="Profile Picture"
        class="w-32 h-32 rounded-full object-cover border-4 border-blue-300 shadow"
      />

      <div class="flex-1 space-y-3">
        <p><strong>Email:</strong> <span class="text-gray-700"><?= htmlspecialchars($student['email']) ?></span></p>
        <p><strong>Phone:</strong> <span class="text-gray-700"><?= htmlspecialchars($student['phone']) ?></span></p>
        <p><strong>Course:</strong> <span class="text-gray-700"><?= htmlspecialchars($student['course']) ?></span></p>
      </div>
    </div>

    <!-- Update Profile Button -->
    <div class="mt-8 text-center">
      <a href="update_profile.php" class="inline-block bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-6 rounded-lg shadow">
        Update Profile
      </a>
    </div>
  </main>

  <!-- Footer -->
  

</body>
</html>
