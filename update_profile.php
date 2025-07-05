<?php
// update_profile.php

// Check if logged in
require_once 'includes/auth.php';
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Get student ID from session
$student_id = $_SESSION['student_id'];

// Fetch current student data
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$student_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

// If student not found, logout
if (!$student) {
    header('Location: logout.php');
    exit();
}

// Initialize success or error message
$message = '';
$courses = ['Computer Science', 'Information Technology', 'Electronics', 'Civil Engineering', 'Business Studies'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $full_name = sanitizeInput($_POST['full_name']);
    $phone = sanitizeInput($_POST['phone']);
    $course = sanitizeInput($_POST['course']);

    // Validate selected course
    if (!in_array($course, $courses)) {
        $message = "Invalid course selected.";
    }


    // Handle profile image if uploaded
    $profile_pic_path = $student['profile_pic']; // keep existing unless new uploaded
    $newImage = handleProfileImageUpload('profile_pic');
    if ($newImage) {
        $profile_pic_path = $newImage;
    }

    // Update query
    $stmt = $pdo->prepare("UPDATE students SET full_name = ?, phone = ?, course = ?, profile_pic = ? WHERE id = ?");
    $updated = $stmt->execute([$full_name, $phone, $course, $profile_pic_path, $student_id]);

    // On success, refresh data and redirect
    if ($updated) {
        $_SESSION['message'] = "Profile updated successfully!";
        header("Location: dashboard.php");
        exit();
    } else {
        $message = "Something went wrong while updating.";
    }
}
?>

<!-- HTML Part -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Profile | Student Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white shadow p-4 flex justify-between items-center">
        <div class="text-xl font-bold">Student Portal</div>
        <div>
            <a href="dashboard.php" class="text-blue-500 hover:underline mr-4">Back to Dashboard</a>
            <a href="logout.php" class="text-red-500 hover:underline">Logout</a>
        </div>
    </nav>

    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Update Your Profile</h2>

        <!-- Show error if needed -->
        <?php if ($message): ?>
            <div class="bg-red-100 text-red-700 px-4 py-2 mb-4 rounded">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <!-- Update Form -->
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block text-sm font-medium">Full Name</label>
                <input type="text" name="full_name" value="<?= htmlspecialchars($student['full_name']) ?>" required class="w-full mt-1 px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Phone</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($student['phone']) ?>" 
                    pattern="\d{10}" maxlength="10"
                    oninput="this.value=this.value.replace(/[^0-9]/g,'')" 
                    class="w-full mt-1 px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Course</label>
                <select name="course" required class="w-full mt-1 px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Select Course --</option>
                    <?php foreach ($courses as $c): ?>
                        <option value="<?= $c ?>" <?= ($student['course'] === $c) ? 'selected' : '' ?>>
                            <?= $c ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>


            <div class="mb-6">
                <label class="block text-sm font-medium">Profile Picture</label>
                <input type="file" name="profile_pic" accept="image/*" class="mt-2">
            </div>

            <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded">Update Profile</button>
        </form>
    </div>
</body>
</html>

<?php
// I first made sure only logged-in students can access the page (auth.php)
// Then I fetched the student data to pre-fill the form
// On form submission, I sanitized inputs and checked if a new image was uploaded
// Speaking of inputs I also checked if the selected course is one of the allowed options
// If not, set an error message
// If valid, proceed to update the database
// I kept the old profile picture unless a new one is provided
// Then I ran an UPDATE query to save the changes to the database
// If successful, I set a session message and redirected to dashboard
// I also added error messages if something fails
?>