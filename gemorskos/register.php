<?php
// Establish connection to your database (replace with your credentials)
$servername = "localhost";
$dbname = "gemorskos";
$dbusername = "gemorskos";
$dbpassword = "qwerty";

// Retrieve form data
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

        
    try {
        // Create a PDO connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $password);
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        // Validate if passwords match
        if ($password !== $confirm_password) {
            echo "Passwords do not match. Please try again.";
        } else {
            // Encrypt password using BCRYPT algorithm
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Prepare SQL statement to insert data into the database
            $stmt = $conn->prepare("INSERT INTO administration (username, email, password) VALUES (:username, :email, :password)");
            
            // Bind parameters and execute SQL statement
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            
            if ($stmt->execute()) {
                echo "Registration successful!";
                echo "<a href='index.html'>Click here to homepage.</a>";
            } else {
                echo "Error: Unable to register. Please try again.";
            }
        }

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Close the database connection
$conn = null;
?>
