<?php     


/*
 * examples/mysql/loaddata.php
 * 
 * This file is part of EditableGrid.
 * http://editablegrid.net
 *
 * Copyright (c) 2011 Webismymind SPRL
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://editablegrid.net/license
 */
                              
/**
 * fetch_pairs is a simple method that transforms a mysqli_result object in an array.
 * It will be used to generate possible values for some columns.
*/
function fetch_pairs($mysqli,$query){
	if (!($res = $mysqli->query($query)))return FALSE;
	$rows = array();
	while ($row = $res->fetch_assoc()) {
		$first = true;
		$key = $value = null;
		foreach ($row as $val) {
			if ($first) { $key = $val; $first = false; }
			else { $value = $val; break; } 
		}
		$rows[$key] = $value;
	}
	return $rows;
}
/**
 * This script loads data from the database and returns it to the js
 *
 */
$user = (isset($_GET['user'])) ? stripslashes($_GET['user']) : 'Error';  
if (strtolower($user) == "giedre") {     
require_once('config.php');      
require_once('EditableGrid.php');            


// Database connection
$mysqli = mysqli_init();
$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);
$mysqli->real_connect($config['db_host'],$config['db_user'],$config['db_password'],$config['db_name']); 
                    
// create a new EditableGrid object
$grid = new EditableGrid();

/* 
*  Add columns. The first argument of addColumn is the name of the field in the databse. 
*  The second argument is the label that will be displayed in the header
*/
$grid->addColumn('start_date', 'Start date', 'date', NULL, true, null, true, false);
$grid->addColumn('proj_detl', 'Detl', 'string',fetch_pairs($mysqli,'SELECT detl, detl_name FROM prj_detl'),true); 
$grid->addColumn('type', 'Type', 'string',fetch_pairs($mysqli,'SELECT prj_type_id, prj_type_name FROM prj_types'),true); 
$grid->addColumn('id', 'ID', 'integer', NULL, false, null, false, true);
$grid->addColumn('address', 'Address', 'string');  
$grid->addColumn('assigned_to', 'Person<BR/>Responsible', 'string',fetch_pairs($mysqli,'SELECT usr_id, username FROM users'),true); 
$grid->addColumn('est_end_date', 'Estimated<br/>End date', 'date', NULL, true, null, true, false); 
$grid->addColumn('real_end_date', 'Actual<BR/>End date', 'date', NULL, true, null, true, false); 
$grid->addColumn('est_touchtime', 'Estimated<br/>touchtime<br/>(hours)', 'integer', NULL, false, null, true, false);
$grid->addColumn('real_touchtime', 'Actual<BR/>Touchtime<br/>(hours)', 'integer', NULL, false, null, true, false);
$grid->addColumn('est_duration', 'Estimated<br/>duration<br/>(days)', 'integer', NULL, false, null, true, false);
$grid->addColumn('real_duration', 'Actual<BR/>Duration<br/>(days)', 'integer', NULL, false, null, true, false);
$grid->addColumn('action', 'Project<br/>Details', 'html', NULL, false, 'id');
$mydb_tablename = (isset($_GET['db_tablename'])) ? stripslashes($_GET['db_tablename']) : 'projects';
                                                                    
$result = $mysqli->query("SELECT start_date, if(detl=1,'TDP','TP') as proj_detl, type, id, address, assigned_to, est_end_date, real_end_date, est_touchtime, real_touchtime, est_duration, real_duration FROM ".$mydb_tablename );
$mysqli->close();
// send data to the browser
$grid->renderJSON($result);

} else {
	
require_once('config.php');      
require_once('EditableGrid.php');            
// Database connection
$mysqli = mysqli_init();
$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);
$mysqli->real_connect($config['db_host'],$config['db_user'],$config['db_password'],$config['db_name']); 
                    
// create a new EditableGrid object
$grid = new EditableGrid();

/* 
*  Add columns. The first argument of addColumn is the name of the field in the databse. 
*  The second argument is the label that will be displayed in the header
*/
$grid->addColumn('start_date', 'Start date', 'date', NULL, true, null, true, false);
$grid->addColumn('proj_detl', 'Detl', 'string',fetch_pairs($mysqli,'SELECT detl, detl_name FROM prj_detl'),true); 
$grid->addColumn('type', 'Type', 'string',fetch_pairs($mysqli,'SELECT prj_type_id, prj_type_name FROM prj_types'),true); 
$grid->addColumn('id', 'ID', 'integer', NULL, false, null, false, true);
$grid->addColumn('address', 'Address', 'string');  
$grid->addColumn('assigned_to', 'Person<BR>Responsible', 'string',fetch_pairs($mysqli,'SELECT usr_id, username FROM users'),true); 
$grid->addColumn('est_end_date', 'Estimated<br/>end date', 'date', NULL, false, null, true, false); 
$grid->addColumn('real_end_date', 'Actual<br/>end date', 'date', NULL, true, null, true, false); 
$grid->addColumn('action', 'Project<BR/>Details', 'html', NULL, false, 'id');
$mydb_tablename = (isset($_GET['db_tablename'])) ? stripslashes($_GET['db_tablename']) : 'projects';

$result = $mysqli->query("SELECT a.start_date, if(a.detl=1,'TDP','TP') as proj_detl, a.type, a.id, a.address, a.assigned_to, a.est_end_date, a.real_end_date FROM ".$mydb_tablename." a, users b WHERE lower(a.assigned_to) = b.usr_id and LOWER(b.username)= '".strtolower($user)."'");
$mysqli->close();
// send data to the browser
$grid->renderJSON($result);	
}



