<?php

function checkForm($array, $keys) {
    foreach($keys as $key) 
        if(!isset($array["$key"]) || empty($array["$key"]))
            return false;
    return true;
}

function checkPass($pass) {
    //regular expression match (regex)
    $containsLetter = preg_match('/[a-zA-Z]/', $pass);
    $containsDigit = preg_match('/\d/', $pass);
    $containsSpecial = preg_match('/[^a-zA-Z\d]/', $pass);
    return ($containsLetter && $containsDigit && $containsSpecial);
}

function checkEmail($email) {
    return preg_match('/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/', $email);
}

function checkLength($value, $max_length, $min_length = 3) {
    return strlen($value) <= $max_length && strlen($value) >= $min_length;
}

function checkImg($image) {
    $allowed_types = ['jpg', 'png', 'jpeg', 'gif'];
    foreach($allowed_types as $val)
        if(str_contains($image, $val))
            return true;
    return false;
}

// testing function
function lastPostID($id) {
    global $conn;
    $query = "SELECT id FROM posts ORDER BY id DESC LIMIT 1";
    $result = $conn->query($query);
    if($result)
        if($id <= 0 || $id > $result->fetch_assoc()['id'])
            return false;
    return true;
}

?>