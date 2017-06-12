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
}
