<?php

class Database {

    private $host;
    private $database;
    private $user;
    private $password;
    private $connection;

    public function __construct($config)
    {
        $this->host = $config['db']['host'];
        $this->database = $config['db']['database'];
        $this->user = $config['db']['user'];
        $this->password = $config['db']['password'];
        $this->connect();
    }

    private function connect() 
    {
        $dsn = "mysql:host={$this->host};dbname={$this->database}";

        try
        {
            $this->connection = new \PDO($dsn, $this->user, $this->password);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch(\PDOException $e) 
        {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function getUserByEmailandPassword($email, $password, $type) {
        $stmt = $this->connection->prepare("SELECT * FROM user WHERE email = :email AND password = :password AND type = :type");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':type', $type);
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addUserToDatabase($name, $surname, $email, $password, $type) {
        $sql = "INSERT INTO user (name, surname, email, password, type) VALUES (:name, :surname, :email, :password, :type)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':surname', $surname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':type', $type);
        $stmt->execute();
        
    }

    public function checkEmailExist($email) {
        $stmt =$this->connection->prepare("SELECT COUNT(*) AS count FROM user WHERE email =?");
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;

    }

    public function showUsers()
    {
        $sql = "SELECT * FROM user";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removeUserFromDatabase($userID) {
        $sql = "DELETE FROM user WHERE id= $userID";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        if ($stmt->execute()) {
            return true; 
        } else {
            return false;
        }
    }
    public function showEditUser($userID) {
        $sql = "SELECT * FROM user WHERE id=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $userID, PDO::PARAM_INT); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function editUserInDatabase($userID, $name, $surname, $email, $password, $type) {
        $sql ="UPDATE user SET name=?, surname=?, email=?, password=?, type=?  WHERE id=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $name, PDO::PARAM_STR); 
        $stmt->bindValue(2, $surname, PDO::PARAM_STR);
        $stmt->bindValue(3, $email, PDO::PARAM_STR);
        $stmt->bindValue(4, $password, PDO::PARAM_STR);
        $stmt->bindValue(5, $type, PDO::PARAM_STR);
        $stmt->bindValue(6, $userID, PDO::PARAM_INT); 
        $stmt->execute();
    }

    public function addPostToDatabase($title, $content, $sciezka, $photo_path) {
        $sql = "INSERT INTO post (title, content, sciezka, photo_path) VALUES (:title, :content, :sciezka, :photo_path)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':sciezka', $sciezka);
        $stmt->bindParam(':photo_path', $photo_path);
        $stmt->execute();
    }
    public function listingPost(){
        $sql = "SELECT * FROM post";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getPostByIdOrName($postIdOrName) {
        // Sprawdź, czy $postIdOrName zawiera ścieżkę do wpisu (np. "nazwa-wpisu-id")
        $urlParts = explode('-', $postIdOrName);
        $postId = end($urlParts); // Pobierz tylko id z końca URL
    
        // Zapytanie SQL w celu pobrania wpisu na podstawie id
        $sql = "SELECT * FROM post WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $postId, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function showPosts()
    {
        $sql = "SELECT * FROM post";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function removePostFromDatabase($postID) {
        $sql = "DELETE FROM post WHERE id= $postID";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        if ($stmt->execute()) {
            return true; 
        } else {
            return false;
        }
    }
    public function getPostPhotoPath($postID) {
        $sql = "SELECT photo_path FROM post WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $postID, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['photo_path'];
    }
    public function showEditPost($postID) {
        $sql = "SELECT * FROM post WHERE id=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $postID, PDO::PARAM_INT); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editPostInDatabase($postID, $title, $content, $sciezka, $photo_path) {
        $sql ="UPDATE post SET title=?, content=?, sciezka=?, photo_path=? WHERE id=?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(1, $title, PDO::PARAM_STR); 
        $stmt->bindValue(2, $content, PDO::PARAM_STR);
        $stmt->bindValue(3, $sciezka, PDO::PARAM_STR);
        $stmt->bindValue(4, $photo_path, PDO::PARAM_STR);
        $stmt->bindValue(5, $postID, PDO::PARAM_INT); 
        $stmt->execute();
    }


};

