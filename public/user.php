<?php
// Include your database configuration file
require "../config.php";

// Initialize variables
$result = null; // This will hold the user data if available

try {
    // Create a PDO connection
    $connection = new PDO($dsn, $username, $password, $options);

    // Define the SQL query to fetch users
    $sql = "SELECT userId, Name, Country, Mobileno FROM users";
    
    // Prepare and execute the query
    $statement = $connection->prepare($sql);
    $statement->execute();

    // Fetch the result (list of users)
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    // Handle database error
    $errorMessage = "Error: " . $error->getMessage();
}
?>

<?php include "templates/header.php"; ?>

<ul>
    <li><a href="createUsers.php"><strong>Create Users</strong></a> - create users</li>
    <li><a href="readuser.php"><strong>Read Users</strong></a> - Read users</li>
	<li><a href="MYSQLtransaction.php"><strong>Create Users using - MySQL transaction</strong></a> - create users</li>
</ul>

<h2>Latest Users</h2>

<?php if ($result && count($result) > 0) { ?>
    <table>
        <thead>
            <tr>
                <th>User Id</th>
                <th>Name</th>
                <th>Country</th>
                <th>Mobile No</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $row) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row["userId"]); ?></td>
                    <td><?php echo htmlspecialchars($row["Name"]); ?></td>
                    <td><?php echo htmlspecialchars($row["Country"]); ?></td>
                    <td><?php echo htmlspecialchars($row["Mobileno"]); ?></td>
                    <td><a href="viewUser.php?userId=<?php echo htmlspecialchars($row["userId"]); ?>">View Details</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <blockquote>No users found in the table.</blockquote>
<?php } ?>

<br><a href="index.php">Back to home</a>

<?php include "templates/footer.php"; ?>
