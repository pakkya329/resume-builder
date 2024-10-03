<?php
$server = "localhost";
$username = "root";
$password = "root";
$dbname = "personal_info";

// Create a connection
$con = mysqli_connect($server, $username, $password, $dbname);

// Check the connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize a variable for the success message
$message = "";

// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstname = $_POST['firstname'];
    $surname = $_POST['surname'];
    $profession = $_POST['profession'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zipcode = $_POST['zipcode'];

    // Prepare the SQL statement with placeholders
    $sql = "INSERT INTO personal_info (firstname, surname, profession, address, city, state, zipcode)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $con->prepare($sql);

    if ($stmt === false) {
        die("Prepare failed: " . htmlspecialchars($con->error));
    }

    // Bind parameters
    $stmt->bind_param("sssssss", $firstname, $surname, $profession, $address, $city, $state, $zipcode);

    // Execute the statement
    if ($stmt->execute()) {
        $message = "Data submitted successfully"; // Set success message
    } else {
        $message = "Error submitting data: " . htmlspecialchars($stmt->error); // Error message
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$con->close();
?>