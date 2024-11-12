<?php
session_start();
include '../functions.php';

// Ensure user is logged in
guard();

// Check if the `student_id` parameter is set in the URL
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    // Find the index of the student with the given `student_id`
    foreach ($_SESSION['student_data'] as $index => $student) {
        if ($student['student_id'] === $student_id) {
            // Remove the student from the session data
            unset($_SESSION['student_data'][$index]);
            // Re-index the array to avoid gaps
            $_SESSION['student_data'] = array_values($_SESSION['student_data']);
            break;
        }
    }
}

// Redirect back to the registration page
header("Location: register.php");
exit;
?>
