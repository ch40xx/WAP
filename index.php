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
    <header class="bg-white shadow p-4">
        <div class="max-w-5xl mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold text-blue-600">Student Portal</h1>
            <nav>
                <a href="index.php" class="text-gray-700 hover:text-blue-500 mr-4">Home</a>
                <a href="login.php" class="text-gray-700 hover:text-blue-500 mr-4">Login</a>
                <?php if (isset($_SESSION['student_id'])): ?>
                    <a href="dashboard.php" class="text-gray-700 hover:text-blue-500">Dashboard</a>
                <?php endif; ?>
            </nav>
        </div>
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
    <footer class="bg-white shadow p-4 text-center text-sm text-gray-600">
        &copy; <?= date("Y") ?> | 0362506 | Web Application Programming
    </footer>

</body>
</html>

