<?php
try  {
    require "../config.php";
    require "../common.php";

    $connection = new PDO($dsn, $username, $password, $options);
	

    $sql = "SELECT * 
            FROM chat
            ORDER BY chatid DESC
            LIMIT 3";

    $statement = $connection->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll();
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>
        
<h2>Latest chats</h2>

<?php if ($result && $statement->rowCount() > 0) { ?>
    <table>
        <thead>
            <tr>
                <th>Chat Id</th>
                <th>Sender Name</th>
                <th>Receiver Name</th>
                <th>Chat type</th>
                <th>Message Status</th>
                <th>LastSeen Sender</th>
                <th>LastSeen Receiver</th>
				<th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><?php echo escape($row["chatid"]); ?></td>
                <td><?php echo escape($row["senderName"]); ?></td>
                <td><?php echo escape($row["receiverName"]); ?></td>
                <td><?php echo escape($row["chattype"]); ?></td>
                <td><?php echo escape($row["MessageStatus"]); ?></td>
                <td><?php echo escape($row["LastSeenSender"]); ?></td>
                <td><?php echo escape($row["LastSeenReceiver"]); ?></td>
				<td><a href="viewChat.php?chatid=<?php echo escape($row["chatid"]); ?>">View Details</a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <blockquote>No chats found on table.</blockquote>
<?php } ?>

<br><a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
