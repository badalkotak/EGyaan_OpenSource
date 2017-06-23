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
// here var1,2,3 are used for columns user can pass any column. If user have only one condn then the user will pass value and column of that condition. rest other will be passed as 1 for both column and value. as 1=1 is always true this query works perfectly.
        /*SELECT * FROM egn_noticeboard where type='10' and 1='1' and 1='1'
        Here only type column and its value was required. Therefore all other column and value are passed 1=1
        */
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
        //Similarly here $table1,2 are for tables in nested query. $var is used for selecting * or particular column. $var1,2,3 are columns and $value1,2,3 are used for value. SIMILARLY all the columns required are passed with correct value and column . Those which are not required are passed as 1 as 1=1 is always true
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


