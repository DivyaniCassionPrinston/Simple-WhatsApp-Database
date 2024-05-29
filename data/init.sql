CREATE DATABASE test;

use test;
/*
Here we didn't create any primary table for user,
so without user table ReciverId colum is not a appropriate here(because ReciverId based on  userId ) 
so that i am using receiverName as an attribute
*/

CREATE TABLE chat (
	chatid INT(15) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	receiverName VARCHAR(30) NOT NULL,
	senderName VARCHAR(30) NOT NULL,
	chattype VARCHAR(50) NOT NULL, 
	date TIMESTAMP
);

ALTER TABLE chat
ADD COLUMN MessageStatus VARCHAR(30),
ADD COLUMN LastSeenSender TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN LastSeenReceiver TIMESTAMP DEFAULT CURRENT_TIMESTAMP;
        
        
CREATE TABLE users (
 userId VARCHAR(10) PRIMARY KEY, 
Name VARCHAR(30), Country VARCHAR(50),
 Mobileno INT(10)
);

/*
Here i ment sender Id as user id, so fully depent on the sender details
*/
CREATE TABLE user_chats (
 UserChatsId INT PRIMARY KEY AUTO_INCREMENT,
 userId VARCHAR(10),
 FOREIGN KEY (userId) REFERENCES users(userId),
 chatid INT(15) UNSIGNED,
 FOREIGN KEY (chatid) REFERENCES chat(chatid)
);

-- Create index in main table
CREATE INDEX idx_receiverName ON chat(receiverName);

CREATE INDEX idx_senderName ON chat(senderName);


ALTER TABLE user_chats
ADD COLUMN UserName VARCHAR(30);


