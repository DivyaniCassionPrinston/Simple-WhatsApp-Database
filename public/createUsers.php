<?php
// Initialize variables to empty values
$userId = $Name = $Country = $Mobileno = "";
$selectedChats = [];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database configuration file
    require "../config.php";

    try {
        // Create a PDO connection
        $connection = new PDO($dsn, $username, $password, $options);

        // Set the values from the form
        $userId = $_POST['userId'];
        $Name = $_POST['Name'];
        $Country = $_POST['Country'];
        $Mobileno = $_POST['Mobileno'];
        $selectedChats = isset($_POST['selectedChats']) ? $_POST['selectedChats'] : [];

        // Start a database transaction
        $connection->beginTransaction();

        // Define the SQL query to insert a new user
        $sql = "INSERT INTO users (userId, Name, Country, Mobileno) VALUES (:userId, :Name, :Country, :Mobileno)";
        $statement = $connection->prepare($sql);
        $statement->bindParam(':userId', $userId);
        $statement->bindParam(':Name', $Name);
        $statement->bindParam(':Country', $Country);
        $statement->bindParam(':Mobileno', $Mobileno);
        $statement->execute();

        // Get the last inserted user ID
        $lastUserId = $userId;

        // Insert user-chats mapping into the user_chats table
        foreach ($selectedChats as $chatId) {
            // Use a JOIN to fetch the correct Name from the users table
            $sql = "INSERT INTO user_chats (userId, chatid, Name) 
                    SELECT :userId, :chatId, Name FROM users WHERE userId = :userId";
            $statement = $connection->prepare($sql);
            $statement->bindParam(':userId', $lastUserId);
            $statement->bindParam(':chatId', $chatId);
			$statement->bindParam(':UserName', $Name);
            $statement->execute();
        }

        // Commit the transaction
        $connection->commit();

        // Handle successful insertion
        $successMessage = "User added successfully!";
    } catch (PDOException $error) {
        // Handle database error
        $errorMessage = "Error: " . $error->getMessage();
    }
}

// Fetch chat data from the database
require "../config.php";
try {
    $connection = new PDO($dsn, $username, $password, $options);
    $chatSelectQuery = "SELECT chatid FROM chat";
    $result = $connection->query($chatSelectQuery);
    $chatOptions = $result->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    $errorMessage = "Error: " . $error->getMessage();
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($successMessage)) { ?>
    <blockquote><?php echo $successMessage; ?></blockquote>
<?php } ?>

<?php if (isset($errorMessage)) { ?>
    <blockquote><?php echo $errorMessage; ?></blockquote>
<?php } ?>

<h2>Add a user</h2>

<form method="post">
    <label for="userId">User ID</label>
    <input type="text" name="userId" id="userId" required>
    
    <label for="Name">Name</label>
    <input type="text" name="Name" id="Name" required>
    
    <label for="Country">Country</label>
    <input type="text" name="Country" id="Country" required>
    
    <label for="Mobileno">Mobile Number</label>
    <input type="text" name="Mobileno" id="Mobileno" required>

    <label for="selectedChats">Select Chats which belong to this user (Hold Ctrl/Cmd for multiple selection)</label>
    <select multiple name="selectedChats[]" id="selectedChats">
        <?php foreach ($chatOptions as $chat) { ?>
            <option value="<?php echo $chat['chatid']; ?>"><?php echo $chat['chatid']; ?></option>
        <?php } ?>
    </select>

    <br><br>
    
    <input type="submit" name="submit" value="Submit">
</form>

<br><a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
