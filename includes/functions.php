<?php

// User input sanitization
function sanitizeInput($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Profile image upload and returns file path
function handleProfileImageUpload($fileInputName) {
    if (!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    $fileType = mime_content_type($_FILES[$fileInputName]['tmp_name']);

    if (!in_array($fileType, $allowedTypes)) {
        return null;
    }

    $uploadsDir = __DIR__ . '/../uploads/';
    if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0755, true);
    }

    $fileExt = pathinfo($_FILES[$fileInputName]['name'], PATHINFO_EXTENSION);
    $newFileName = uniqid('profile_', true) . '.' . $fileExt;
    $destination = $uploadsDir . $newFileName;

    if (move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $destination)) {
        return 'uploads/' . $newFileName;
    }

    return null;
}

// Display a success/error message 
function flashMessage($message, $type = 'success') {
    return "<div class='alert alert-$type' role='alert'>$message</div>";
}
?>

// First I started the session to track login state
// Then I checked if the user is already logged in, in which case they shouldn't see the login page again
// I used a prepared statement to safely get the student from DB using the email
// I verified the hashed password using password_verify
// If login is valid, I stored the student ID in session and redirected to dashboard
// If not, I showed an error using Tailwind-styled alert box

