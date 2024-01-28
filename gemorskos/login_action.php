<?php
session_start();

$servername = "localhost";
$dbname = "gemorskos";
$dbusername = "gemorskos";
$dbpassword = "qwerty";


if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    
try {

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute SQL query
    $stmt = $conn->prepare("SELECT * FROM administration WHERE email=:email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $hashed_password_from_db = $row['password'];

    if (password_verify($password, $hashed_password_from_db)) {
        $_SESSION['loggedin'] = true;
        // $_SESSION['admin_email'] = $row['email'];
        // $_SESSION['admin_password'] = $row['password'];
        echo "<p>You have logged in.</p>";
        echo "<a href='index.html'>Click here to homepage.</a>";

    } else {
        // throw new Exception("Incorrect email or password.");
        echo"Incorrect email or password.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

}


?>
