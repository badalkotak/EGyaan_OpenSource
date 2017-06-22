<?php

require_once("../../../classes/Constants.php");

class Noticeboard
{
	private $connection;

    function __construct($connection){
        $this->connection = $connection;
    }

    public function getNoticeboard($var1,$type,$var2,$urgent,$var3,$id)
    {
    	$sql="SELECT * FROM egn_noticeboard where $var1='$type' and $var2='$urgent' and $var3='$id'";
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


   public function getNested2($table1,$table2,$var,$var1,$value1,$var2,$value2,$var3,$value3,$var4,$value4,$var5,$value5)
    {
        $sql="Select $var from $table1 where $var1=$value1 and $var2=$value2 and  $var3 in ( select $value3 from $table2 where $var4=$value4 and $var5='$value5')";
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

     public function getNested3($table1,$table2,$table3,$var,$var1,$value1,$var2,$value2,$var3,$value3,$var4,$value4,$var5,$value5,$var6,$value6,$var7,$value7,$var8,$value8)
    {
        $sql="Select $var from $table1 where $var1=$value1 and $var2=$value2 and  $var3 in ( select $value3 from $table2 where $var4=$value4 and $var5=$value5 and $var6 in (select $value6 from $table3 where $var7=$value7 and $var8=$value8 ))";
         var_dump($sql);

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


     public function getNested4($table1,$table2,$table3,$table4,$var1,$value1,$var2,$value2,$var3,$value3,$var4,$value4,$var5,$value5,$var6,$value6,$var7,$value7,$var8,$value8,$var9,$value9,$var10,$value10,$var11,$value11)
    {
        $sql="Select * from $table1 where $var1=$value1 and $var2=$value2 and  $var3 in ( select $value3 from $table 2 where $var4=$value4 and $var5=$value5 and $var6 in (select $value6 from $table3 where $var7=$value7 and $var8=$value8 and $var9 in (select $value9 from $table4 where $var10=$value10 and $var11=$value11)))";

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




// In case of multiple inserts, you need to check whether or not each insert query is being executed, if it is executed only then execute the next query, or else if a particular query is not executed, first delete all the previous RELATED INSERT queries and then return false.
    public function insertNoticeboard($title,$notice,$file,$urgent,$type,$user_id)
    {
            $insert_sql="INSERT INTO `egn_noticeboard`( `title`, `notice`, `file`, `urgent_notice`, `type`, `user_id`) VALUES ('$title','$notice','$file','$urgent','$type',$user_id)";
            $insert=$this->connection->query($insert_sql);
            if($insert === true)
            {
                return true;
            }
            else
            {
                return false;
            }
        
    }


    public function deleteNoticeboard($id)
    {
        $sql="DELETE FROM egn_noticeboard WHERE id='$id'";
        $delete=$this->connection->query($sql);

        if($delete===true)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
?>


