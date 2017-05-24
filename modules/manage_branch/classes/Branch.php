<?php

include("../../../classes/Constants.php");

class Branch
{
    private $connection;

    function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getBranch()
    {
        $sql = "SELECT * FROM egn_branch";
        $result = $this->connection->query($sql);

        if ($result->num_rows > 0) {
            return $result;
        } else {
            return null;
        }
    }

// In case of multiple inserts, you need to check whether or not each insert query is being executed, if it is executed only then execute the next query, or else if a particular query is not executed, first delete all the previous RELATED INSERT queries and then return false.
    public function insertBranch($name)
    {
        $sql = "SELECT * FROM `egn_branch` WHERE name='$name'";
        $result = $this->connection->query($sql);

        if ($result->num_rows == 0) {
            $insert_sql = "INSERT INTO `egn_branch`(`name`) VALUES ('$name')";
            $insert = $this->connection->query($insert_sql);
            if ($insert === true) {
                return true;
            } else {
                return false;
            }
        } else {
            $message = Constants::STATUS_EXISTS;
            return $message;
        }
    }

    public function updateBranch($id, $name)
    {
        $sql = "UPDATE `egn_branch` SET `name`='$name' WHERE id='$id'";
        $update = $this->connection->query($sql);

        if ($update === true) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteBranch($id)
    {
        $sql = "DELETE FROM egn_branch WHERE id='$id'";
        $delete = $this->connection->query($sql);

        if ($delete === true) {
            return true;
        } else {
            return false;
        }
    }
}

?>