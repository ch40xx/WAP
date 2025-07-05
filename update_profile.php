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

// If student is not found then logout
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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Update Profile - Student Portal</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

  <!-- Navbar -->
  <nav class="bg-gray-800 text-white shadow">
    <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
      <h1 class="text-xl font-semibold">Web Application Programming | Student Portal</h1>
      <div class="space-x-6">
        <a href="dashboard.php" class="hover:underline">Dashboard</a>
        <a href="logout.php" class="hover:underline text-red-300">Logout</a>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-center">Update Your Profile</h2>

    <!-- Display error/success message -->
    <?php if (!empty($message)): ?>
      <div class="mb-4 p-4 rounded bg-red-100 text-red-700 border border-red-400">
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>

    <!-- Update Profile Form -->
    <form action="update_profile.php" method="POST" enctype="multipart/form-data" class="space-y-6">

      <div>
        <label class="block mb-1 font-semibold text-gray-700">Full Name</label>
        <input type="text" name="full_name" value="<?= htmlspecialchars($student['full_name']) ?>" required
               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"/>
      </div>

      <div>
        <label class="block mb-1 font-semibold text-gray-700">Phone Number</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($student['phone']) ?>"
               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"/>
      </div>

      <div>
        <label class="block mb-1 font-semibold text-gray-700">Course</label>
        <select name="course" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
          <?php foreach ($courses as $c): ?>
            <option value="<?= $c ?>" <?= $student['course'] === $c ? 'selected' : '' ?>>
              <?= $c ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div>
        <label class="block mb-1 font-semibold text-gray-700">Profile Picture</label>
        <input type="file" name="profile_pic" accept="image/*"
               class="w-full px-4 py-2 border rounded-lg bg-white file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-white file:bg-gray-800 hover:file:bg-gray-700"/>
        <?php if ($student['profile_pic']): ?>
          <img src="<?= htmlspecialchars($student['profile_pic']) ?>" alt="Current Profile"
               class="h-20 w-20 mt-3 rounded-full object-cover border"/>
        <?php endif; ?>
      </div>
      

      <div class="text-center">
        <button type="submit"
                class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-6 rounded-lg shadow">
          Save Changes
        </button>
      </div>
    </form>
  </main>

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