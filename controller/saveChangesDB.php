<?php
session_start(); 
/* 
 * 
 */

/**
 * Include models: Exercise and Page
 */
include_once'../model/Exercise.php'; 
include_once'../model/Page.php'; 

/**
 * Conection to the database
 */
include_once '../config/theasisDB.php';
$db = new theasisDB();

print 'In file (saveChangesDB.php) to save changed content of uploaded PDF ';

/**
 * Current page object taken from screen
 */
$pages_obj = unserialize($_SESSION['obj_pages_upload']);

foreach ($pages_obj as $page){
    //TODO
    foreach ($exsList as $exe){
        //TODO
        
    }
}