<?php
try {
    require "../config.php";
    require "../common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    // Get the chat ID from the URL parameter
    $chatId = $_GET['chatid'];

    $sql = "SELECT * 
            FROM chat
            WHERE chatid = :chatid";

    $statement = $connection->prepare($sql);
    $statement->bindParam(':chatid', $chatId, PDO::PARAM_STR);
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
        <h2>Chat Details</h2>
        <ul class="list-item">
            <li><strong>Chat Id:</strong> <?php echo escape($row["chatid"]); ?></li><br>
            <li><strong>Sender Name:</strong> <?php echo escape($row["senderName"]); ?></li><br>
            <li><strong>Receiver Name:</strong> <?php echo escape($row["receiverName"]); ?></li><br>
            <li><strong>Chat Type:</strong> <?php echo escape($row["chattype"]); ?></li><br>
            <li><strong>Message Status:</strong> <?php echo escape($row["MessageStatus"]); ?></li><br>
            <li><strong>LastSeen of Sender:</strong> <?php echo escape($row["LastSeenSender"]); ?></li><br>
            <li><strong>LastSeen of Receiver:</strong> <?php echo escape($row["LastSeenReceiver"]); ?></li>
        </ul>
        <?php
    }
} else {
    ?>
    <blockquote>No chat details found for the provided chat ID.</blockquote>
    <?php
}
?>

<a href="editChat.php?chatid=<?php echo escape($row["chatid"]); ?>">Edit</a><br><br>
<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
