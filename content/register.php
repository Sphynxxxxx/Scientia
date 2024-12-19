<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['full_name'];
    $location = $_POST['location'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $checkEmail = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        echo "<script>
                alert('Email already exists!');
                window.location.href = 'form.php';
              </script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (full_name, location, contact, email, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $fullName, $location, $contact, $email, $password);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Registration successful!');
                    window.location.href = 'form.php';
                  </script>";
            exit();
        } else {
            echo "<script>
                    alert('Error: " . $conn->error . "');
                    window.location.href = 'form.php';
                  </script>";
        }
    }

    $checkEmail->close();
    $stmt->close();
}
$conn->close();
?>
