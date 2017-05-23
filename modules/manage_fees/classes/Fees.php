<?php

include("../../../classes/Constants.php");

class Fees
{
	private $connection;

    function __construct($connection){
        $this->connection = $connection;
    }

    public function getStudent()
    {
    	$sql="SELECT id,firstname,lastname,email,mobile,total_fees,fees_paid,date_of_admission,parent_mobile,fees_comment FROM egn_student";
    	$result = $this->connection->query($sql);

        if($result->num_rows > 0)
        {
            return $result;
        }
        else
        {
            return null;
        }
    }

    public function addFees($id,$fees_paid)
    {
        $sql = "UPDATE egn_student SET fees_paid = fees_paid + '$fees_paid' WHERE id='$id'";
        $update = $this->connection->query($sql);

        if ($update === true) {
            return true;
        } else {
            return false;
        }
    }

    public function checkPendingFees($id,$fees_paid)
    {
        $sql = "SELECT total_fees,fees_paid FROM egn_student WHERE id='$id'";
        $result = $this->connection->query($sql);
        $row = $result->fetch_assoc();
        if ($fees_paid <= ($row["total_fees"] - $row["fees_paid"])) {
            return true;
        } else {
            return false;
        }
    }
    public function refundFees($id)
    {
        $sql = "UPDATE egn_student SET fees_paid = 0 WHERE id='$id'";
        $update = $this->connection->query($sql);

        if ($update === true) {
            return true;
        } else {
            return false;
        }
    }
}
?>