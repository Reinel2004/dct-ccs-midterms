<?php

function getUsers() {
    return [
        ["email" => "user1@email.com", "password" => "password"],
        ["email" => "user2@email.com", "password" => "password"],
        ["email" => "user3@email.com", "password" => "password"],
        ["email" => "user4@email.com", "password" => "password"],
        ["email" => "user5@email.com", "password" => "password"]
    ];
}

function validateLoginCredentials($email, $password) {
    $errors = [];

    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid Email.";
    } else {
       
        $users = getUsers();
        $emailExists = false;
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                $emailExists = true;
                break;
            }
        }

        if (!$emailExists) {
            $errors[] = "Invalid email or password.";
        }
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    return $errors;

}


function checkLoginCredentials($email, $password, $users) {
    foreach ($users as $user) {
        if ($user['email'] === $email && $user['password'] === $password) {
            return true;
        }
    }
    return false;
}

function checkUserSessionIsActive() {
    if (isset($_SESSION['email']) && basename($_SERVER['PHP_SELF']) == 'index.php') {
        header("Location: dashboard.php");
        exit;
    }
}

function guard() {
    if (empty($_SESSION['email']) && basename($_SERVER['PHP_SELF']) != 'index.php') {
        header("Location: index.php"); 
        exit;
    }
}


function displayErrors($errors) {
    $output = "<ul>";
    foreach ($errors as $error) {
        $output .= "<li>" . htmlspecialchars($error) . "</li>";
    }
    $output .= "</ul>";
    return $output;
}


function renderErrorsToView($error) {
   
    if (empty($error)) {
        return null;
    }
    return "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                $error
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";

}


function validateStudentData($student_data) {
   
    $errors = [];
    if (empty($student_data['student_id'])) {
        $errors[] = "Student ID is required.";
    }
    if (empty($student_data['first_name'])) {
        $errors[] = "First Name is required.";
    }

    if (empty($student_data['last_name'])) {
        $errors[] = "Last Name is required.";
    }

    return $errors;

}

function checkDuplicateStudentData($student_data) {
    if (!empty($_SESSION['student_data'])) {
        foreach ($_SESSION['student_data'] as $existing_student) {
            if ($existing_student['student_id'] === $student_data['student_id']) {
                return $existing_student; 
            }
        }
    }
    return null; 

}

function getSelectedStudentIndex($student_id) {
    if (!empty($_SESSION['student_data'])) {
        foreach ($_SESSION['student_data'] as $index => $student) {
            if ($student['student_id'] === $student_id) {
                return $index; 
            }
        }
    }
    return null;

}


function getSelectedStudentData($index) {
    if (isset($_SESSION['student_data'][$index])) {
        return $_SESSION['student_data'][$index];
    }
    return false;

}


function getBaseURL() {
    return 'http://' . $_SERVER['HTTP_HOST'] . '/midterms';
}   


// Validates subject data to ensure fields are not empty
function validateSubjectData($subject_data) {
    $errors = [];
    if (empty($subject_data['subject_code'])) {
        $errors[] = "Subject Code is required.";
    }
    if (empty($subject_data['subject_name'])) {
        $errors[] = "Subject Name is required.";
    }
    return $errors;
}


function checkDuplicateSubjectData($subject_data) {
    if (!empty($_SESSION['subject_data'])) {
        foreach ($_SESSION['subject_data'] as $existing_subject) {
            if ($existing_subject['subject_code'] === $subject_data['subject_code']) {
                return $existing_subject;
            }
        }
    }
    return null;
}


function getSelectedSubjectIndex($subject_code) {
    if (!empty($_SESSION['subject_data'])) {
        foreach ($_SESSION['subject_data'] as $index => $subject) {
            if ($subject['subject_code'] === $subject_code) {
                return $index;
            }
        }
    }
    return null;
}


function getSelectedSubjectData($index) {
    if (isset($_SESSION['subject_data'][$index])) {
        return $_SESSION['subject_data'][$index];
    }
    return false;
}

function validateAttachedSubject($subject_data) {
    $errors = [];
    if (empty($subject_data['subject_code'])) {
        $errors[] = "Subject Code is required for attachment.";
    }
    return $errors;
}

?>