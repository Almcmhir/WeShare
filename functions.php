<?php
require_once 'db_connection.php';

// Function to get all users
function getAllUsers() {
    global $conn;
    $sql = "SELECT * FROM Users";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to enable a user
function enableUser($userId) {
    global $conn;
    $sql = "UPDATE Users SET Status = 'active' WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
}

// Function to disable a user
function disableUser($userId) {
    global $conn;
    $sql = "UPDATE Users SET Status = 'disabled' WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
}

// Function to get all posts and their authors
function getAllPosts() {
    global $conn;
    $sql = "SELECT Posts.*, Users.Username FROM Posts JOIN Users ON Posts.UserID = Users.UserID";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to get comments by post ID
function getCommentsByPostId($postId) {
    global $conn;
    $sql = "SELECT Comments.*, Users.Username FROM Comments JOIN Users ON Comments.UserID = Users.UserID WHERE PostID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>

