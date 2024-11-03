<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "student_db";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            echo "<p class='success'>Login successful!</p>";
        } else {
            echo "<p class='error'>Invalid username or password.</p>";
        }
    } else {
        echo "<p class='error'>Invalid username or password.</p>";
    }

    $stmt->close();
}
$conn->close();
?>