<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */


if (isset($_POST['submit'])) {
    require "../config.php";
    require "../common.php";

    try  {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $new_user = array(
            "receiverName" => $_POST['receiverName'],
            "senderName"  => $_POST['senderName'],
            "chattype"     => $_POST['chattype'],
			"MessageStatus"     => $_POST['MessageStatus'],
			"LastSeenSender"     => $_POST['LastSeenSender'],
			"LastSeenReceiver"     => $_POST['LastSeenReceiver']
            );

        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "chat",
                implode(", ", array_keys($new_user)),
                ":" . implode(", :", array_keys($new_user))
        );
        
        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) { ?>
    <blockquote> Receiver Name: <?php echo $_POST['receiverName']; ?>, Sender Name: <?php echo $_POST['senderName']; ?>,
    chattype: <?php echo $_POST['chattype']; ?>,  Fields are successfully added.</blockquote>
<?php } ?>

<h2>Add a chat</h2>

<form method="post">
    <label for="senderName">Sender Name</label>
    <input type="text" name="senderName" id="senderName">
    <label for="receiverName">Receiver Name</label>
    <input type="text" name="receiverName" id="receiverName">
    <label for="chattype">ChatType</label>
    <input type="text" name="chattype" id="chattype">
	
	<label for="MessageStatus">Message Status</label>
	<select id="MessageStatus" name="MessageStatus">
        <option value="Read">Read</option>
        <option value="Delivered">Delivered</option>
        <option value="Not Delivered">Not Delivered</option>
    </select>
    <label for="LastSeenSender">LastSeen of Sender</label>
    <input type="datetime-local" name="LastSeenSender" id="LastSeenSender">
    <label for="LastSeen Receiver">LastSeen of Receiver</label>
    <input type="datetime-local" name="LastSeenReceiver" id="LastSeenReceiver"><br><br>
   
    <input type="submit" name="submit" value="Submit">
</form>

<br><a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
