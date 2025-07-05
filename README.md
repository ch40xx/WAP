# 🧑‍🎓 Student Portal Web Application (PHP + MySQL)

> **Author:** 0362506  
> **Course:** Web Application Programming  
> **Tech Stack:** PHP, MySQL, HTML5, Tailwind CSS  
> **Tested on:** XAMPP (Apache + MySQL)

---

## 📘 Description

This is a simple, responsive **Student Portal** web app that demonstrates:

- 🔐 Secure login system with hashed passwords
- 🖼️ Profile view and update with image upload
- 📄 User data stored in MySQL and accessed via PHP
- ⚙️ CRUD operations (Create, Read, Update)
- 🧼 Backend validation and input sanitization
- 🎨 Responsive UI using Tailwind CSS

---

## 📁 Project Structure

```
WAP/
├── index.php # Home page
├── login.php # Login form
├── dashboard.php # Protected profile view
├── update_profile.php # Profile update form
├── logout.php # Ends session and logs user out
│
├── includes/
│ ├── config.php # Database connection
│ ├── auth.php # Session protection
│ └── functions.php # Sanitization, upload helpers
│
├── uploads/ # Stores profile pictures
├── db/
│ └── init.sql # SQL to create 'students' table

```

---

## 🗃️ Database Schema

**Database:** `student_portal_0362506`
**Table:** `students`

| Field       | Type         | Description               |
| ----------- | ------------ | ------------------------- |
| id          | INT (PK, AI) | Primary key               |
| full_name   | VARCHAR(100) | Student's name            |
| email       | VARCHAR(100) | Unique login email        |
| password    | VARCHAR(255) | Hashed password           |
| phone       | VARCHAR(20)  | Optional phone number     |
| course      | VARCHAR(100) | Selected from dropdown    |
| profile_pic | VARCHAR(255) | Stores profile image path |

---

## ✅ Features

- [x] Home, Login, Dashboard pages
- [x] Session-based access control
- [x] Passwords hashed using `password_hash()`
- [x] Email format validated with `filter_var()`
- [x] Course dropdown selection with backend validation
- [x] Profile picture upload with file type checking
- [x] Responsive layout using Tailwind CSS

---

## 🧪 Test Credentials + Password Hash Tutorial

Use the following credentials to log in to the student portal:

```

Email: test@student.com
Password: Student@123

```

---

### 🔐 How the Password is Hashed (with testcreds.php)

To demonstrate password hashing using PHP, this project includes a helper file:
**`testcreds.php`** — located at the root of the project.

```php

<?php

$email = 'test@student.com';
$password = 'Student@123';
$hashed = password_hash($password, PASSWORD_DEFAULT);

echo "Email: " . $email . "<br>";
echo "Password: " . $password . "<br>";
echo "Hashed: " . $hashed . "<br>";

?>
```

---

### ✅ How to Use It:

1. Open your browser and go to:
   `http://localhost/WAP/testcreds.php`

2. Copy the **Hashed Password** shown on the screen

3. Insert a new row into the `students` table in **phpMyAdmin**:

```sql
USE student_portal_0362506;
INSERT INTO students (full_name, email, password, phone, course)
VALUES (
    'Test Student',
    'test@student.com',
    'PASTE_HASH_HERE',
    '9800000000',
    'Computer Science'
);
```

> 🧠 Replace `PASTE_HASH_HERE` with the actual hashed password from step 2.

## 🚀 How to Run (Using XAMPP)

1. **Start XAMPP** and run Apache + MySQL
2. Copy/Clone this repo to:

   ```
   C:\xampp\htdocs\WAP
   ```

3. Open phpMyAdmin and run `db/init.sql` to create the database and table
4. Insert a test student with a hashed password
5. Visit the app in your browser:

   ```
   http://localhost/WAP/
   ```

6. Login and explore features

---

## 🔐 Security

- Passwords are stored hashed using `password_hash()`
- Passwords are verified using `password_verify()`
- Email is validated using PHP’s `filter_var()`
- Course input is limited to a backend-checked dropdown
- Sessions are required for protected pages (`dashboard`, `update`)
- Uploaded images are checked for file type and stored securely

---

## 📦 Dependencies

- PHP 7.4+ (XAMPP)
- MySQL (via phpMyAdmin)
- Tailwind CSS (via CDN)

---

## 📝 Notes

- Profile update includes name, phone, course, and profile image
- No public registration page (insert users manually for now)
- Dashboard is accessible only after login
- Form inputs are sanitized and validated on the backend
