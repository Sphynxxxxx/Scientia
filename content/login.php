<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            echo "<script>
                    alert('Login successful!');
                    window.location.href = '../index.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Invalid password!');
                    window.location.href = 'form.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('User not found!');
                window.location.href = 'form.php';
              </script>";
    }

    $stmt->close();
}
$conn->close();
?>
