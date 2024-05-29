<?php

/**
 * Function to query information based on 
 * a parameter: in this case, senderName.
 *
 */

if (isset($_POST['submit'])) {
    try  {
        
        require "../config.php";
        require "../common.php";

        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT * 
                        FROM chat
                        WHERE senderName = :senderName";

        $senderName = $_POST['senderName'];

        $statement = $connection->prepare($sql);
        $statement->bindParam(':senderName', $senderName, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>
<?php require "templates/header.php"; ?>
        
<?php  
if (isset($_POST['submit'])) {
    if ($result && $statement->rowCount() > 0) { ?>
        <h2>Results</h2>

        <table>
            <thead>
                <tr>
                    <th>Chat Id</th>
					 <th>sender Name</th>
                    <th>receiver Name</th>
					<th>Chat type</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><?php echo escape($row["chatid"]); ?></td>
                <td><?php echo escape($row["senderName"]); ?></td>
                <td><?php echo escape($row["receiverName"]); ?></td>
                <td><?php echo escape($row["chattype"]); ?></td>
                <td><?php echo escape($row["date"]); ?> </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        <blockquote>No chats found for sender Name: <?php echo escape($_POST['senderName']); ?>.</blockquote>
    <?php } 
} ?> 

<h2>Find chat based on sender Name</h2>

<form method="post">
    <label for="senderName">sender Name</label>
    <input type="text" id="senderName" name="senderName">
    <input type="submit" name="submit" value="View Results">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
