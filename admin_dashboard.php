<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>

        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            color: #F0F1F1;
            background-color: crimson;
        }

        h1{
            margin: 0;
            text-align: center;
            width: 100%;
            height: 100px;
            background-color: crimson;
            color: #F0F1F1;
            font-size: 50px;
            font-weight: bold;
            padding-top: 20px;
        }

        a{
            text-decoration: none;
            color: crimson;
        }

        .searchbar{
            width: 500px;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .sbtn{
            background-color: crimson;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width:100px;
        }

    </style>
</head>
<body style="background-color: #F0F1F1;">

<h1>Wshare Admin Dashboard</h1>

<h2>User Profiles</h2>
<form method="post">
    <input class="searchbar" type="text" name="search_username" placeholder="Search by username">
    <button class="sbtn" type="submit" name="search_user">Search</button>
    <button class="sbtn" type="submit" name="refresh">Refresh</button>
    <label for="sort_users">Sort by:</label>
    <select id="sort_users" name="sort_users">
        <option value="username">Username</option>
        <option value="created_at">Created At</option>
    </select>
    <button class="sbtn" type="submit" name="sort_user">Sort</button>
</form>
<table>
    <tr>
        <th>User ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Posts Count</th>
        <th>Comments Count</th>
        <th>Action</th>
    </tr>
    <?php
    // Include the database connection file
    require_once 'db_connection.php';

    // Sorting functionality
    $sort_users = isset($_POST['sort_users']) ? $_POST['sort_users'] : 'username';
    $sort_order = ($sort_users === 'created_at') ? 'DESC' : 'ASC';

    // Search user functionality
    if (isset($_POST['search_user'])) {
        $search_username = $_POST['search_username'];
        $sql = "SELECT Users.UserID, Users.Username, Users.Email, 
                COUNT(Posts.PostID) AS PostsCount, COUNT(Comments.CommentID) AS CommentsCount
                FROM Users 
                LEFT JOIN Posts ON Users.UserID = Posts.UserID 
                LEFT JOIN Comments ON Users.UserID = Comments.UserID 
                WHERE Users.Username LIKE '%$search_username%'
                GROUP BY Users.UserID
                ORDER BY $sort_users $sort_order";
    } else {
        $sql = "SELECT Users.UserID, Users.Username, Users.Email, 
                COUNT(Posts.PostID) AS PostsCount, COUNT(Comments.CommentID) AS CommentsCount
                FROM Users 
                LEFT JOIN Posts ON Users.UserID = Posts.UserID 
                LEFT JOIN Comments ON Users.UserID = Comments.UserID 
                GROUP BY Users.UserID
                ORDER BY $sort_users $sort_order";
    }

    $result = $conn->query($sql);

    // Display user profiles in table rows
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['UserID'] . "</td>";
            echo "<td>" . $row['Username'] . "</td>";
            echo "<td>" . $row['Email'] . "</td>";
            echo "<td>" . $row['PostsCount'] . "</td>";
            echo "<td>" . $row['CommentsCount'] . "</td>";
            echo "<td><a href='#'>Disable</a> | <a href='#'>Enable</a></td>"; // Action links
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No user profiles found</td></tr>";
    }
    ?>
</table>

<h2>Forum Posts</h2>
<form method="post">
    <input class="searchbar" type="text" name="search_post" placeholder="Search by title">
    <button class="sbtn" type="submit" name="search_forum">Search</button>
</form>
<table>
    <tr>
        <th>Post ID</th>
        <th>User ID</th>
        <th>Username</th>
        <th>Title</th>
        <th>Content</th>
        <th>Created At</th>
    </tr>
    <?php
    // Search forum posts functionality based on the title
    if (isset($_POST['search_forum'])) {
        $search_post = $_POST['search_post'];
        $sql = "SELECT Posts.PostID, Posts.UserID, Users.Username, Posts.Title, Posts.Content, Posts.CreatedAt
                FROM Posts 
                LEFT JOIN Users ON Posts.UserID = Users.UserID 
                WHERE Posts.Title LIKE '%$search_post%'
                ORDER BY Posts.CreatedAt $sort_order";
    } else {
        $sql = "SELECT Posts.PostID, Posts.UserID, Users.Username, Posts.Title, Posts.Content, Posts.CreatedAt
                FROM Posts 
                LEFT JOIN Users ON Posts.UserID = Users.UserID
                ORDER BY Posts.CreatedAt $sort_order";
    }

    $result = $conn->query($sql);

    // Display forum posts in table rows
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['PostID'] . "</td>";
            echo "<td>" . $row['UserID'] . "</td>";
            echo "<td>" . $row['Username'] . "</td>";
            echo "<td>" . $row['Title'] . "</td>";
            echo "<td>" . $row['Content'] . "</td>";
            echo "<td>" . $row['CreatedAt'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No forum posts found</td></tr>";
    }
    ?>
</table>

<h2>Comments</h2>
<form method="post">
    <input class="searchbar" type="text" name="search_comment" placeholder="Search by content">
    <button class="sbtn" type="submit" name="search_comments">Search</button>
</form>
<table>
    <tr>
        <th>Comment ID</th>
        <th>Post ID</th>
        <th>User ID</th>
        <th>Username</th>
        <th>Content</th>
        <th>Created At</th>
    </tr>
    <?php
    // Search comments functionality based on the content
    if (isset($_POST['search_comments'])) {
        $search_comment = $_POST['search_comment'];
        $sql = "SELECT Comments.CommentID, Comments.PostID, Comments.UserID, Users.Username, Comments.Content, Comments.CreatedAt
                FROM Comments 
                LEFT JOIN Users ON Comments.UserID = Users.UserID 
                WHERE Comments.Content LIKE '%$search_comment%'
                ORDER BY Comments.CreatedAt $sort_order";
    } else {
        $sql = "SELECT Comments.CommentID, Comments.PostID, Comments.UserID, Users.Username, Comments.Content, Comments.CreatedAt
                FROM Comments 
                LEFT JOIN Users ON Comments.UserID = Users.UserID
                ORDER BY Comments.CreatedAt $sort_order";
    }

    $result = $conn->query($sql);

    // Display comments in table rows
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['CommentID'] . "</td>";
            echo "<td>" . $row['PostID'] . "</td>";
            echo "<td>" . $row['UserID'] . "</td>";
            echo "<td>" . $row['Username'] . "</td>";
            echo "<td>" . $row['Content'] . "</td>";
            echo "<td>" . $row['CreatedAt'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No comments found</td></tr>";
    }
    ?>
</table>

</body>
</html>
