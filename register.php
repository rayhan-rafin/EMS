<?php
session_start();
require 'auth_controllers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Check if user already exists
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT user_id FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        echo "<script>alert('User ID already taken. Please choose another.'); window.location.href='registration_form.php';</script>";
        exit();
    }
    $stmt->close();

    // Securely register user
    registerUser($id, $name, $password, $role);

    echo "<script>
            alert('Registration successful!');
            window.location.href = 'index.php';
         </script>";
}
?>
