<?php 

require_once '../functions/convertToArray.php';

class Post {
    private $id;
    private $dbConnection;
    private $post_owner_id;
    private $image;

    public function __construct($dbConnection)
    {
        $this->$dbConnection = $dbConnection;
    }

    public function getOne($postId)
    {
        $this->id = (int)$postId;

        $sql = "SELECT user_id, image FROM posts WHERE id = ?";
        $stmt = $this->$dbConnection->stmt_init();


        if ($stmt->prepare($sql)) {
            $stmt->bind_param("i", $param_postId);
            $param_postId = $this->id;
            if($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($db_user_id, $db_image);
                    $stmt->fetch();

                    $this->post_owner_id = (int)$db_post_owner_id;
                    $this->image = $db_image;
                } else {
                    return FALSE;
                }

            }
        }
        $stmt->close();
    }

    public function UserOwnsThisPost($user_id)
    {
        if((int)$user_id === $this->post_owner_id) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->post_owner_id;
    }

    public function getImageName()
    {
        return $this->image;
    }
}
?>