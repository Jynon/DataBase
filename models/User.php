<?php 

require_once "../db.php";
require_once "../functions/getParamsFromUrl.php";

class User {
    private $id;
    private $email;
    private $username;
    private $password;
    private $dbConnection;

    public function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function getOne($userId)
    {
        $sql = "SELECT username, email, password FROM users WHERE id = ?";
        $stmt = $this->$dbConnection->stmt_init();
        $this->id = (int)$userId;
        
        if ($stmt->prepare($sql)) {
            $stmt->bind_param("i", $param_userId);
            $param_userId = $this->id;
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($db_username, $db_email, $db_password);
                    $stmt->fetch();

                    $this->username = $db_username;
                    $this->email = $db_email;
                    $this->password = $db_password;
                } else {
                    return FALSE;
                }
            }
        }
        $stmt->close();
    }

    public function isOwner($sessionUserId)
    {
        return ((int)$sessionUserId === $this->id);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }
}