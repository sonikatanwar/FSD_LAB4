<?php
$host = "localhost";
$username = "myuser";
$password = "password";
$database = "FSD_LAB4";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function insertStudent($conn, $firstName, $lastName, $rollNo, $password, $contactNumber) {
    if (!empty($rollNo)) {
        $sql = "INSERT INTO students (first_name, last_name, roll_no, password, contact_number) VALUES ('$firstName', '$lastName', '$rollNo', '$password', '$contactNumber')";

        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false; // Roll No is empty
    }
}

function deleteStudent($conn, $rollNo) {
    if (!empty($rollNo)) {
        $sql = "DELETE FROM students WHERE roll_no = '$rollNo'";

        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false; // Roll No is empty
    }
}

function updateStudentContact($conn, $rollNo, $newContactNumber) {
    if (!empty($rollNo)) {
        $sql = "UPDATE students SET contact_number = '$newContactNumber' WHERE roll_no = '$rollNo'";

        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false; // Roll No is empty
    }
}

function displayStudents($conn) {
    $sql = "SELECT * FROM students";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr><th>First Name</th><th>Last Name</th><th>Roll No</th><th>Contact Number</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row["first_name"] . "</td><td>" . $row["last_name"] . "</td><td>" . $row["roll_no"] . "</td><td>" . $row["contact_number"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No records found";
    }
}

if (isset($_POST['register'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $rollNo = $_POST['rollNo'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $contactNumber = $_POST['contactNumber'];

    // Check if all required fields are set
    if (!empty($firstName) && !empty($lastName) && !empty($rollNo) && !empty($password) && !empty($confirmPassword) && !empty($contactNumber)) {
        if ($password == $confirmPassword) {
            if (insertStudent($conn, $firstName, $lastName, $rollNo, $password, $contactNumber)) {
                echo "<div class='success'>Registration Successful!</div>";
            } else {
                echo "<div class='error'>Error while registering student.</div>";
            }
        } else {
            echo "<div class='error'>Passwords do not match.</div>";
        }
    } else {
        echo "<div class='error'>All fields are required.</div>";
    }
} elseif (isset($_POST['delete'])) {
    $rollNoToDelete = $_POST['rollNoToDelete'];

    if (deleteStudent($conn, $rollNoToDelete)) {
        echo "<div class 'success'>Student record deleted successfully.</div>";
    } else {
        echo "<div class='error'>Error while deleting student record.</div>";
    }
} elseif (isset($_POST['update'])) {
    $rollNoToUpdate = $_POST['rollNoToUpdate'];
    $newContactNumber = $_POST['newContactNumber'];

    if (updateStudentContact($conn, $rollNoToUpdate, $newContactNumber)) {
        echo "<div class='success'>Student record updated successfully.</div>";
    } else {
        echo "<div class='error'>Error while updating student record.</div>";
    }
}

displayStudents($conn);

mysqli_close($conn);
?>
