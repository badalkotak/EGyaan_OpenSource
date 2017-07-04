<?php
class Fees
{
	private $connection;

    function __construct($connection){
        $this->connection = $connection;
    }

    public function getStudentList()
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
        $sql = "UPDATE egn_student SET fees_paid = fees_paid + '$fees_paid' WHERE id='$id' AND '$fees_paid' BETWEEN '1' AND total_fees-fees_paid";
        $this->connection->query($sql);
        $update = $this->connection->affected_rows;
        if($update == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getPaidFees($id)
    {
        $sql = "SELECT fees_paid FROM egn_student WHERE id='$id'";
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

    public function refundFees($id,$refund_fees)
    {
        $sql = "UPDATE egn_student SET fees_paid = fees_paid - '$refund_fees' WHERE id='$id' AND '$refund_fees' BETWEEN '1' AND fees_paid";
        $this->connection->query($sql);
        $update = $this->connection->affected_rows;
        if($update == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function parentPageRedirect($message){
        header("Location: manage_fees.php?message=" . $message);
    }
}
?>