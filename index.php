<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home | Student Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col justify-between">

    <!-- Header/Nav -->
    <header class="bg-gray-800 shadow p-1">
        <nav class="bg-gray-800 text-white shadow">
            <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
                <h1 class="text-xl font-bold">Web Application Programming | Student Portal</h1>
                <div class="space-x-4">
                <a href="index.php" class="hover:underline">Home</a>
                <a href="login.php" class="hover:underline">Login</a>
                <?php if (isset($_SESSION['student_id'])): ?>
                        <a href="dashboard.php" class="hover:underline">Dashboard</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center">
        <div class="text-center max-w-2xl p-8">
            <h2 class="text-3xl font-semibold mb-4">Welcome to the Student Portal.</h2>
            <p class="text-gray-700 text-lg mb-6">
                This portal allows students to manage their personal information, update profiles, and access academic details with ease.
            </p>

            <?php if (!isset($_SESSION['student_id'])): ?>
                <a href="login.php" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">Login Now</a>
            <?php else: ?>
                <a href="dashboard.php" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded">Go to Dashboard</a>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center text-sm text-gray-500 mt-10 mb-4">
    © <?= date('Y') ?> | 0362506 | Web Application Programming
  </footer>

</body>
</html>

