<?php
try {
    require "../config.php";
    require "../common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    // Get the chat ID from the URL parameter
    $userId = $_GET['userId'];

    $sql = "SELECT * 
            FROM users
            WHERE userId = :userId";

    $statement = $connection->prepare($sql);
    $statement->bindParam(':userId', $userId, PDO::PARAM_STR);
    $statement->execute();

    $result = $statement->fetchAll();
} catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>

<?php
if ($result && $statement->rowCount() > 0) {
    foreach ($result as $row) {
        // Display chat details using the retrieved data
        ?>
        <h2>User Details</h2>
        <ul class="list-item">
            <li><strong>User Id:</strong> <?php echo escape($row["userId"]); ?></li><br>
            <li><strong>User Name:</strong> <?php echo escape($row["Name"]); ?></li><br>
            <li><strong>Country:</strong> <?php echo escape($row["Country"]); ?></li><br>
            <li><strong>Mobile No:</strong> <?php echo escape($row["Mobileno"]); ?></li><br>
            
        </ul>
        <?php
    }
} else {
    ?>
    <blockquote>No chat details found for the provided chat ID.</blockquote>
    <?php
}
?>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
