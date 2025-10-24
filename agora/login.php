<?php
include 'db_connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['full_name'];
    $password = $_POST['user_password'];

    
    if (empty($name) || empty($password)) {
        echo "<script>alert('Please fill in all fields!'); window.location='login.html';</script>";
        exit();
    }

    
    $sql = "SELECT * FROM tbluser WHERE full_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

   
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        
        if (password_verify($password, $user['user_password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['full_name'] = $user['full_name'];

            echo "<script>alert('Login successful!'); window.location='home.php';</script>";
        } else {
            echo "<script>alert('Wrong password!'); window.location='login.html';</script>";
        }
    } else {
        echo "<script>alert('User not found!'); window.location='login.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
