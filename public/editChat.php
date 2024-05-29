
<?php
require "../config.php";
require "../common.php";

if (isset($_GET['chatid'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $chatId = $_GET['chatid'];

  
        $sql = "SELECT * FROM chat WHERE chatid = :chatid";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':chatid', $chatId);
        $statement->execute();

        $chatDetails = $statement->fetch(PDO::FETCH_ASSOC);

        if ($chatDetails === false) {
            echo "Chat not found.";
            exit;
        }

        if (isset($_POST['submit'])) {
         
            $editedSenderName = $_POST['senderName'];
            $editedReceiverName = $_POST['receiverName'];
            $editedChatType = $_POST['chattype'];
            $editedMessageStatus = $_POST['MessageStatus'];
            $editedLastSeenSender = $_POST['LastSeenSender'];
            $editedLastSeenReceiver = $_POST['LastSeenReceiver'];

            
            $updateSql = "UPDATE chat
                        SET senderName = :senderName,
                            receiverName = :receiverName,
                            chattype = :chattype,
                            MessageStatus = :MessageStatus,
                            LastSeenSender = :LastSeenSender,
                            LastSeenReceiver = :LastSeenReceiver
                        WHERE chatid = :chatid";

            $updateStatement = $connection->prepare($updateSql);
            $updateStatement->bindValue(':senderName', $editedSenderName);
            $updateStatement->bindValue(':receiverName', $editedReceiverName);
            $updateStatement->bindValue(':chattype', $editedChatType);
            $updateStatement->bindValue(':MessageStatus', $editedMessageStatus);
            $updateStatement->bindValue(':LastSeenSender', $editedLastSeenSender);
            $updateStatement->bindValue(':LastSeenReceiver', $editedLastSeenReceiver);
            $updateStatement->bindValue(':chatid', $chatId);
            $updateStatement->execute();

           
            header("Location: viewChat.php?chatid=" . $chatId);
            exit();
        }
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php require "templates/header.php"; ?>
<form method="post">
    
    <label for="senderName"><strong>Sender Name</strong></label>
    <input type="text" name="senderName" id="senderName" value="<?php echo escape($chatDetails["senderName"]); ?>"><br><br>
    
    <label for="receiverName"><strong>Receiver Name</strong></label>
    <input type="text" name="receiverName" id="receiverName" value="<?php echo escape($chatDetails["receiverName"]); ?>"><br><br>
    
    <label for="chattype"><strong>Chat Type</strong></label>
    <input type="text" name="chattype" id="chattype" value="<?php echo escape($chatDetails["chattype"]); ?>"><br><br>
 
    <label for="MessageStatus"><strong>Message Status</strong></label>
    <select id="MessageStatus" name="MessageStatus">
        <option value="Read" <?php if ($chatDetails["MessageStatus"] === "Read") echo "selected"; ?>>Read</option>
        <option value="Delivered" <?php if ($chatDetails["MessageStatus"] === "Delivered") echo "selected"; ?>>Delivered</option>
        <option value="Not Delivered" <?php if ($chatDetails["MessageStatus"] === "Not Delivered") echo "selected"; ?>>Not Delivered</option>
    </select><br><br>
 
    <label for="LastSeenSender"><strong>LastSeen of Sender</strong></label>
    <input type="datetime-local" name="LastSeenSender" id="LastSeenSender" value="<?php echo escape($chatDetails["LastSeenSender"]); ?>"><br><br>

    <label for="LastSeenReceiver"><strong>LastSeen of Receiver</strong></label>
    <input type="datetime-local" name="LastSeenReceiver" id="LastSeenReceiver" value="<?php echo escape($chatDetails["LastSeenReceiver"]); ?>"><br><br>

    <input type="submit" name="submit" value="Save Details">
  
</form>



<br><a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>