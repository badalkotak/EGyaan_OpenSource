<?php

class Constants
{
    const SERVER_NAME = "localhost";
    const DB_NAME = "egn_final";
    const DB_USERNAME = "root";
    const DB_PASSWORD = "root";
    const STATUS_SUCCESS = "success";
    const STATUS_FAILED = "failed";
    const STATUS_EXISTS = "already_exists";
    const EMPTY_PARAMETERS = "empty_parameters";
    const DELETE_SUCCESS_MSG = "successfully deleted!"; // To use this you have to append the name of your module with this error message, EG: For manage branch: echo "Branch ".Constants::DELETE_SUCCESS_MSG; Output: Branch successfully deleted!	
    const DELETE_FAIL_MSG = "Unable to delete "; //EG: echo Constants::DELETE_FAIL_MSG."Branch"; Output: Unable to delete Branch
    const UPDATE_SUCCESS_MSG = "successfully updated!";
    const UPDATE_FAIL_MSG = "Unable to update ";
    const INSERT_SUCCESS_MSG = "successfully inserted!";
    const INSERT_FAIL_MSG = "Unable to insert ";
    const DELETE_CONFIRMATION = "Are you sure you want to delete it ?";
    const ROLE_STUDENT_ID = 1;
    const ROLE_TEACHER_ID = 2;
    const ROLE_PARENT_ID = 3;
    const ROLE_ADMIN_ID = 9;
    const NO_USER_ERR = "No user found!";
    const INSERT_ALREADY_EXIST_MSG = "with this name already exists!";
    const PRIVILEGE_ASSIGN_SUCCESS = "Privilege assigned successfully";
    const PRIVILEGE_ASSIGN_FAIL = "Unable to assign privilege";
    const NO_PRIVILEGE_MSG = "You have not been assigned any privilege as yet. Contact the Admin for futher help!";
    const NO_BATCH_ERR = "No batches Found";
}