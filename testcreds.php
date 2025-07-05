<?php

$email = 'test@student.com';
$password = 'Student@123';
$hashed = password_hash($password, PASSWORD_DEFAULT);

echo "Email: " . $email . "<br>";
echo "Password: " . $password . "<br>";
echo "Hashed: " . $hashed . "<br>";

?>
