<?php
require_once("../../../classes/Constants.php");

class Batch
{
    private $connection;

    function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getBatch($multiQuery, $branchId, $batchId, $distinct, $teacherId)
    {
        if ($multiQuery == 'yes' && $branchId == 0 && $batchId == 0 && $distinct == 'no' && $teacherId==0) {
            $sql = "SELECT eBatch.id AS batchId,eBatch.name AS batchName,eBatch.branch_id AS batchBranchId,eBranch.id AS branchId,eBranch.name AS branchName
FROM `egn_batch` AS eBatch,`egn_branch` AS eBranch WHERE eBatch.branch_id = eBranch.id";
        } elseif ($multiQuery == 'no' && $branchId == 0 && $batchId > 0 && $distinct == 'no' && $teacherId==0) {
            $sql = "SELECT eBatch.id AS batchId,eBatch.name AS batchName,eBatch.branch_id AS batchBranchId,eBranch.id AS branchId,eBranch.name AS branchName
FROM `egn_batch` AS eBatch,`egn_branch` AS eBranch WHERE eBatch.branch_id = eBranch.id AND eBatch.id = '$batchId'";
        } elseif ($multiQuery == 'yes' && $branchId > 0 && $batchId == 0 && $distinct == 'no' && $teacherId > 0) {
            $sql = "SELECT DISTINCT batch.id,batch.name 
                    FROM egn_batch as batch ,egn_course as c ,egn_users as u ,egn_role as r, egn_teacher_course as tr 
                    WHERE batch.branch_id = " . $branchId . " AND c.batch_id = batch.id AND tr.course_id=c.id AND tr.user_id=u.id AND u.id=" . $teacherId . " AND u.role_id = r.id AND r.is_teacher=1
                    ORDER BY batch.name";
        } elseif ($multiQuery == 'yes' && $branchId > 0 && $batchId == 0 && $distinct == 'no' && $teacherId==0) {
             $sql = "SELECT eBatch.id AS batchId,eBatch.name AS batchName,eBatch.branch_id AS batchBranchId,eBranch.id AS branchId,eBranch.name AS branchName
FROM `egn_batch` AS eBatch,`egn_branch` AS eBranch WHERE eBatch.branch_id = eBranch.id AND eBatch.branch_id='" . $branchId . "'";
        } elseif ($multiQuery == 'no' && $branchId == 0 && $batchId == 0 && $distinct == 'yes' && $teacherId==0) {
            $sql = "SELECT DISTINCT name FROM `egn_batch`";
        } else {
//            return false;
            $sql = "SELECT * FROM `egn_batch`";
        }
        $result = $this->connection->query($sql);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            return null;
        }
    }

// In case of multiple inserts, you need to check whether or not each insert query is being executed, if it is executed only then execute the next query, or else if a particular query is not executed, first delete all the previous RELATED INSERT queries and then return false.
    public function insertBatch($name, $branch_id)
    {
        $name = $this->connection->real_escape_string($name);
        $branch_id = $this->connection->real_escape_string($branch_id);

        $sql = "SELECT * FROM `egn_batch` WHERE name='$name' AND branch_id='$branch_id'";
        $result = $this->connection->query($sql);

        if ($result->num_rows == 0) {
            $insert_sql = "INSERT INTO `egn_batch`(`name`,`branch_id`) VALUES ('$name','$branch_id')";
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

    public function updateBatch($id, $name, $branchId)
    {
        $name = $this->connection->real_escape_string($name);

        $sql = "UPDATE `egn_batch` SET `name`='$name' WHERE id='$id' AND branch_id='" . $branchId . "'";
        $update = $this->connection->query($sql);

        if ($update === true) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteBatch($id)
    {
        $sql = "DELETE FROM egn_batch WHERE id='$id'";
        $delete = $this->connection->query($sql);

        if ($delete === true) {
            return true;
        } else {
            return false;
        }
    }
}

?>