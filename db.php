<?php

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "EV_Charging";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("<script>alert('❌ Connection failed: " . $conn->connect_error . "');</script>");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $firstName = $_POST['FirstName'] ?? '';
    $lastName = $_POST['LastName'] ?? '';
    $phone = $_POST['PhoneName'] ?? '';
    $email = $_POST['EmailAddress'] ?? '';
    $password = $_POST['Password'] ?? '';
    $gender = $_POST['gender'] ?? '';

    if (empty($firstName) || empty($lastName) || empty($phone) || empty($email) || empty($password)) {
        echo "<script>alert('⚠️ Please fill all required fields.'); window.history.back();</script>";
        exit();
    }

   
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


    $sql = "INSERT INTO Userr (FirstName, LastName, PhoneNumber, EmailAddress, Password, Gender)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $firstName, $lastName, $phone, $email, $hashedPassword, $gender);

  
    if ($stmt->execute()) {
        echo "<script>alert('✅ Registration successful!'); window.location.href = 'index.html';</script>";
    } else {
        echo "<script>alert('❌ Failed to register: " . $stmt->error . "'); window.history.back();</script>";
    }


    $stmt->close();
    $conn->close();
}
?>
