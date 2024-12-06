-- Create the user_accounts table to store user information
CREATE TABLE user_accounts (
    user_id INT AUTO_INCREMENT PRIMARY KEY, -- Primary key for each user
    username VARCHAR(255) NOT NULL UNIQUE, -- Unique username for each user
    first_name VARCHAR(255), -- User's first name
    last_name VARCHAR(255), -- User's last name
    password TEXT, -- User's password (hashed (m5))
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Timestamp of when the user was added
);

-- Create the albums table to store album information
CREATE TABLE albums (
    album_id INT AUTO_INCREMENT PRIMARY KEY, -- Primary key for each album
    album_name VARCHAR(255) NOT NULL, -- Name of the album
    username VARCHAR(255) NOT NULL, -- Username of the album owner
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp of when the album was created
    INDEX (username), -- Index for the username column
    FOREIGN KEY (username) REFERENCES user_accounts(username) ON DELETE CASCADE -- Foreign key linking to user_accounts
);

-- Create the photos table to store photo information
CREATE TABLE photos (
    photo_id INT AUTO_INCREMENT PRIMARY KEY, -- Primary key for each photo
    photo_name TEXT NOT NULL, -- Name of the photo file
    album_id INT NOT NULL, -- ID of the album the photo belongs to
    username VARCHAR(255) NOT NULL, -- Username of the photo uploader
    description VARCHAR(255), -- Description of the photo
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp of when the photo was added
    INDEX (album_id), -- Index for the album_id column
    INDEX (username), -- Index for the username column
    FOREIGN KEY (album_id) REFERENCES albums(album_id) ON DELETE CASCADE, -- Foreign key linking to albums
    FOREIGN KEY (username) REFERENCES user_accounts(username) ON DELETE CASCADE -- Foreign key linking to user_accounts
);
