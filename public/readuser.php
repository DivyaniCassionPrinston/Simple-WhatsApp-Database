<?php


if (isset($_POST['submit'])) {
    try  {
        
        require "../config.php";
        require "../common.php";

        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT * 
                        FROM users
                        WHERE Country = :Country";

        $Country = $_POST['Country'];

        $statement = $connection->prepare($sql);
        $statement->bindParam(':Country', $Country, PDO::PARAM_STR);
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
        <h2>Users of country:<?php echo escape($_POST['Country']); ?></h2>

        <table>
            <thead>
                <tr>
                    <th>User Id</th>
					 <th>Name</th>
                    
                    <th>Mobile no</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><?php echo escape($row["userId"]); ?></td>
                <td><?php echo escape($row["Name"]); ?></td>
                <td><?php echo escape($row["Mobileno"]); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        <blockquote>No users found for Country: <?php echo escape($_POST['Country']); ?>.</blockquote>
    <?php } 
} ?> 

<h2>Find users based on Country</h2>

<form method="post">
    <label for="Country">Country</label>
    <input type="text" id="Country" name="Country">
    <input type="submit" name="submit" value="View Results">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
