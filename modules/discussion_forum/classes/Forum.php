<?php
require_once "StringLengthTooLongException.php";
/**
 * @class
 * @developer: adityajthakker
 * @date: 15/12/16
 */
class Forum{
    /**
     * @var
     * @description Used to connect to the database to perform CRUD operations related to Forum and retrieve Forum Content
     */
    private $connection;
    /**
     * @method
     * @description It initializes the $this->connection variable to the passed $connection param
     * @param $connection
     */
    public function __construct($connection){
        $this->connection = $connection;
    }

    /**
     * @method
     * @description Used to create a new thread
     * @param $thread_title
     * @param $thread_description
     * @param null $student_id
     * @param null $teacher_id
     * @param null $course_id
     * @return bool
     * @throws StringLengthTooLongException
     */
    public function createThread($thread_title, $thread_description, $student_id = null, $teacher_id = null, $course_id = null){
        if ("ad".$thread_description > 4294967297) {
            throw new StringLengthTooLongException("Max Length of Description is 4294967295 characters");
        }

        if ("ad".$thread_title > 255) {
            throw new StringLengthTooLongException("Max Length of Title is 255 characters");
        }

        $sql_insert = "INSERT INTO egn_forum_threads (title, description, student_id, teacher_id, course_id) 
                       VALUES('" . $thread_title . "', '" . $thread_description . "', " . $student_id . ", " . $teacher_id . ", " . $course_id . ")";
//        echo $sql_insert;
        $result_insert = $this->connection->query($sql_insert);
        if ($result_insert === true) {
            return $this->connection->insert_id;
        } else {
            return -1;
        }
    }

    public function deleteReply($id){
        $sql = "delete from egn_forum_thread_replies where id = ". $id;
        $result = $this->connection->query($sql);
        if($result){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @method
     * @description Used to update a thread's information like title, description, or course_id
     * @param $thread_id
     * @param $thread_title
     * @param $thread_description
     * @param null $course_id
     * @return bool
     * @throws StringLengthTooLongException
     */
    public function updateThread($thread_id, $thread_title, $thread_description, $course_id = null){
        if ($thread_description > 4294967295) {
            throw new StringLengthTooLongException("Max Length of Description is 4294967295 characters");
        }

        if ($thread_title > 255) {
            throw new StringLengthTooLongException("Max Length of Title is 255 characters");
        }

        $sql_update = "update egn_forum_threads 
                        set title=".$thread_title.", desciption=".$thread_description.", course_id=".$course_id." where id=".$thread_id;
        $result_update = $this->connection->query($sql_update);
        if ($result_update === true) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @method
     * @description Used to get a list of all the threads in the database. It will return id, title, description (of length 250), author info(if any), and course_id(if any)
     * @return array|null
     */
    public function getThreadsList(){
        $sql = "select * from egn_forum_threads";
        $result = $this->connection->query($sql);
        $list = array();
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $each_thread = array();
                $each_thread["id"] = $row["id"];
                $each_thread["title"] = $row["title"];
                $each_thread["description"] = substr($row["description"], 0, 250)."...";
                if($row["student_id"] != null || $row["teacher_id"] != null){
                    $author = array();
                    if($row["student_id"] != null){
                        $author["type"] = "student";
                        $author["id"] = $row["student_id"];
                    }else{
                        $author["type"] = "teacher";
                        $author["id"] = $row["teacher_id"];
                    }
                    $each_thread["author"] = $author;
                }else{
                    $author["type"] = "anonymous";
                    $each_reply["author"] = $author;
                }
                if($row["course_id"] != null){
                    $each_thread["course_id"] = $row["course_id"];
                }

                $list[] = $each_thread;
            }
            return $list;
        }else{
            return null;
        }
    }

    /**
     * @method
     * @description Used to delete an existing thread
     * @param $thread_id
     * @return bool
     */
    public function deleteThread($thread_id){
        $sql_delete = "delete from egn_forum_threads where id=".$thread_id;
        $result_delete = $this->connection->query($sql_delete);
        if ($result_delete === true) {
            return true;
        } else {
            return false;
        }
    }


    public function addReply($thread_id, $student_id, $teacher_id, $parent_reply_id, $reply){
        $sql = "insert into egn_forum_thread_replies (thread_id, parent_reply_id, description, student_id, teacher_id) values(".$thread_id.", ".$parent_reply_id.", '".$reply."', ".$student_id.", ".$teacher_id.")";
        $result = $this->connection->query($sql);
        if($result == true){
            return $this->connection->insert_id;
        }else{
            return -1;
        }
    }


    /**
     * @method
     * @description Used to get content for a specific Thread.
     * @param $thread_id
     * @return array|null
     */
    public function getThreadContent($thread_id){
        $sql = "select f1.id as reply_id, f2.description as parent_reply, f1.description as reply from egn_forum_thread_replies as f1, egn_forum_thread_replies as f2 where f1.parent_reply_id = f2.id and f1.thread_id = ". $thread_id;
        $result = $this->connection->query($sql);
        if($result->num_rows > 0){
            $array = array();
            while($row = $result->fetch_assoc()){
                $array[] = $row;
            }
            return $array;
        }else{
            return null;
        }

    }
    /*public function getThreadsContent($thread_id){
        $sql_select_top = "select * from egn_forum_thread_replies where thread_id=".$thread_id." and parent_reply_id is null order by timestamp desc";
//        echo $sql_select_top;
        $result_select_top = $this->connection->query($sql_select_top);
        if($result_select_top->num_rows > 0){
            $replies = array();
            while($row_top = $result_select_top->fetch_assoc()){
                $each_reply = array();
                $each_reply["reply_id"] = $row_top["id"];
                if($row_top["student_id"] != null || $row_top["teacher_id"] != null){
                    $author = array();
                    if($row_top["student_id"] != null){
                        $author["type"] = "student";
                        $author["id"] = $row_top["student_id"];
                    }else{
                        $author["type"] = "teacher";
                        $author["id"] = $row_top["teacher_id"];
                    }
                    $each_reply["author"] = $author;
                }else{
                    $author["type"] = "anonymous";
                    $each_reply["author"] = $author;
                }
                $each_reply["timestamp"] = $row_top["timestamp"];
                $each_reply["description"] = $row_top["description"];
                $temp_replies = $this->getReplies($row_top["id"]);
                if(count($temp_replies) > 0){
                    $each_reply["replies"] = $temp_replies;
                }
                $replies[] = $each_reply;
            }
            return $replies;
        }else{
            return null;
        }
    }

    private function getReplies($reply_id){
        $sql_select = "select * from egn_forum_thread_replies where parent_reply_id=".$reply_id." order by timestamp desc";
        $result_select = $this->connection->query($sql_select);
        if($result_select->num_rows > 0){
            $replies = array();
            while($row_top = $result_select->fetch_assoc()){
                $each_reply = array();
                $each_reply["reply_id"] = $row_top["id"];
                if($row_top["student_id"] != null || $row_top["teacher_id"] != null){
                    $author = array();
                    if($row_top["student_id"] != null){
                        $author["type"] = "student";
                        $author["id"] = $row_top["student_id"];
                    }else{
                        $author["type"] = "teacher";
                        $author["id"] = $row_top["teacher_id"];
                    }
                    $each_reply["author"] = $author;
                }else{
                    $author["type"] = "anonymous";
                    $each_reply["author"] = $author;
                }
                $each_reply["timestamp"] = $row_top["timestamp"];
                $each_reply["description"] = $row_top["description"];
                $temp_replies = $this->getReplies($row_top["id"]);
                if(count($temp_replies) > 0){
                    $each_reply["replies"] = $temp_replies;
                }
                $replies[] = $each_reply;
            }
            return $replies;
        }else{
            return null;
        }
    }*/
}