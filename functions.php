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
            $errors[] = "Invalid Email.";
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
        $output . = "<li>" . htmlspecialchars($error) . "</li>";
    }
    $output . = "</ul>";
    return $output;
}


function renderErrorsToView($error) {
   
}


function validateStudentData($student_data) {
   
}

function checkDuplicateStudentData($student_data) {
   
}

function getSelectedStudentIndex($student_id) {
   
}


function getSelectedStudentData($index) {
   
}


function getBaseURL() {
   
}


function validateSubjectData($subject_data){
  

}

function checkDuplicateSubjectData($subject_data){
    
}

function getSelectedSubjectIndex($subject_code){

}

function getSelectedSubjectData($index){

}

function validateAttachedSubject($subject_data){

}


?>