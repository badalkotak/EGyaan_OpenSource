<html>
<body>
<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../classes/Fees.php");
$dbConnect = new DBConnect(Constants::SERVER_NAME,
    Constants::DB_USERNAME,
    Constants::DB_PASSWORD,
    Constants::DB_NAME);
$user_id = 1; //To Do: Change This
if(isset($_REQUEST["message"]) && !empty(trim($_REQUEST["message"]))){
    echo "<script> alert('" . $_REQUEST["message"] . "');</script>";
    echo "<noscript>" . $_REQUEST["message"] . "</noscript>";
}
$fees = new Fees($dbConnect->getInstance());
$result=$fees->getStudentList();
if($result!=null)
{
    ?>
    <table>
        <thead>
        <tr>
            <th>Sr No.</th>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Total Fees</th>
            <th>Fees paid</th>
            <th>Fees pending</th>
            <th>Date of admission</th>
            <th>Contact parent</th>
            <th>Add amount</th>
            <th>Refund</th>
        </tr>
        </thead>
        <tbody>
        <?
        $i=1;
        while($row=$result->fetch_assoc())
        {
            $pending_fees = $row["total_fees"] - $row["fees_paid"];
            $input_fees ='<input type="number" id="fees_add_input_' . $row["id"] . '" value="0" min=1 max=' . $pending_fees . '>
                          <button type="button" onclick="add_fees(' . $row["id"] . ',' . $pending_fees . ')">Add fees</button>';
            $refund_fees ='<input type="number" id="fees_refund_input_' . $row["id"] . '" value="0" min=1 max=' . $row["fees_paid"] . '>
                          <button type="button" onclick="refund_fees(' . $row["id"] . ',' . $row["fees_paid"] . ')">Refund fees</button>';
            echo '  <tr id =' . $row["id"] . '>
                    <td>' . $i . '</td>
                    <td>' . $row["firstname"] . ' ' . $row["lastname"] . '</td>
                    <td>' . $row["email"]  . '</td>
                    <td>' . $row["mobile"]  . '</td>
                    <td>' . $row["total_fees"]  . '</td>
                    <td>' . $row["fees_paid"]  . '</td>
                    <td>' . $pending_fees . '</td>
                    <td>' . $row["date_of_admission"] . '</td>
                    <td>' . $row["parent_mobile"] . '</td>
                    <td>' . (($pending_fees > 0)?$input_fees:'Fees paid') . '</td>
                    <td>' . (($row["fees_paid"] > 0)?$refund_fees:'NA') . '</td>
                  </tr>';
            $i++;
        }
        ?>
        </tbody>
    </table>
    <script>
        function add_fees(id,pending_fees) {
            var fees_input = parseInt(document.getElementById("fees_add_input_" + id).value);
            if(isNaN(fees_input)){
                fees_input = parseInt(0);
            }
            var temp_fees = pending_fees - fees_input;
            if(temp_fees >= 0 && fees_input>0){
                document.location = "add_fees.php?id="+id+"&fees_input="+fees_input;
            }else{
                alert("The amount of fees to be added should be less than/equal to the pending fees and greater than 0.");
            }
        }
        function refund_fees(id,paid_fees) {
            var fees_input = parseInt(document.getElementById("fees_refund_input_" + id).value);
            if(isNaN(fees_input)){
                fees_input = parseInt(0);
            }
            var temp_fees = paid_fees - fees_input;
            if(temp_fees >= 0 && fees_input>0){
                if (confirm("Do you want to proceed?") == true) {
                    document.location = "refund_fees.php?id="+id+"&fees_input="+fees_input;
                } else {}
            }else{
                alert("The amount of fees to be refunded should be less than/equal to the paid fees and greater than 0.");
            }
        }
    </script>
    <?
}
else
{
    echo "No student added yet!!";
}
?>

</body>
</html>