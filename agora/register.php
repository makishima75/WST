<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['full_name'];
  $password = $_POST['user_password'];

  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  $sql = "INSERT INTO tbluser (full_name, user_password) VALUES (?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $name, $hashedPassword);

  if ($stmt->execute()) {
    echo "<script>alert('Registration successful!'); window.location='login.html';</script>";
  } else {
    echo "<script>alert('Error during registration.'); window.location='register.html';</script>";
  }

  $stmt->close();
  $conn->close();
}
?>
