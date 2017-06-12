<?php

require_once("../../../classes/Constants.php");

class Suggestioncomplaint
{
    private $connection;

    function __construct($connection){
        $this->connection = $connection;
    }

    public function getSuggestioncomplaint($var1,$id,$var2,$type)
    {
        $sql="SELECT * FROM egn_suggestion_complaint where $var2='$type' and $var1=$id";
        //var_dump($sql);
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
    public function insertSuggestioncomplaint($title,$description,$type)
    {
        if(isset($title))
        {
            $insert_sql="INSERT INTO `egn_suggestion_complaint`(`title`,`description`,`type`) VALUES ('$title','$description','$type')";
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

        
    }


    public function deleteSuggestioncomplaint($id)
    {
        $sql="DELETE FROM egn_suggestion_complaint WHERE id='$id'";
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