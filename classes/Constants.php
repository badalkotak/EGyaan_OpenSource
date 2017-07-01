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
    const COURSE_ASSIGN_SUCCESS = "Course assigned Successfully!";
    const COURSE_ASSIGN_FAIL = "Problem in assigning Course!";
    const NO_BRANCH_ERR = "No branch found!";
    const BREAK_ID_TT = 2;

    const NOTES_ADD_ID = 1;
    const NOTES_VIEW_ID = 2;
    const NOTES_DELETE_ID = 3;

    const TEST_ADD_ID = 8;
    const TEST_VIEW_ID = 9;
    const TEST_DELETE_ID = 10;
    
    const RESULT_ADD_ID = 12;
    const RESULT_VIEW_ID = 11;
    const RESULT_DELETE_ID = 13;

    const TIMETABLE_ADD_ID = 14;
    const TIMETABLE_VIEW_ID = 15;
    const TIMETABLE_DELETE_ID = 38;

    const SYLLABUS_ADD_ID = 16;
    const SYLLABUS_VIEW_ID = 17;
    const SYLLABUS_DELETE_ID = 18;

    const NOTICE_ADD_ID = 24;
    const NOTICE_VIEW_ID = 25;
    const NOTICE_DELETE_ID = 26;

    const NO_PRIVILEGE = "You dont have the prilige to perform this operation!";
}