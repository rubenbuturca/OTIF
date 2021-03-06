<?php    
include '../ChromePhp.php'; 
ChromePhp::log('loadprojects.php: AJAX call received. Processing...'); 
                    
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
$user = (isset($_GET['user'])) ? stripslashes($_GET['user']) : 'giedre';  
$level = (isset($_GET['level'])) ? stripslashes($_GET['level']) : 'projects'; 
$db_tablename = (isset($_GET['db_tablename'])) ? stripslashes($_GET['db_tablename']) : 'fct_projects';
ChromePhp::log('user: '.$user); 
ChromePhp::log('level: '.$level); 
ChromePhp::log('db_tablename: '.$db_tablename); 
if ($level == "projects")
{
	ChromePhp::log('loadprojects.php: projects list to be processed');
	if (strtolower($user) == "giedre") {   
		ChromePhp::log('loadprojects.php: level == "projects" user == "giedre"'); 
		require_once('config.php');      
		require_once("../php/EditableGrid.php");          
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
		$grid->addColumn('start_date', 'Start date', 'date', NULL, true, null, null, null, null, true, false);
		$grid->addColumn('detl_name', 'Detl', 'string',fetch_pairs($mysqli,'SELECT detl_id, detl_name FROM dim_prj_detl'), true, null, null, null, null, true, false); 
		$grid->addColumn('prj_type_name', 'Type', 'string',fetch_pairs($mysqli,'SELECT prj_type_id, prj_type_name FROM dim_prj_types'),true, null, null, null, null, true, false); 
		$grid->addColumn('id', 'ID', 'integer', NULL, false, null, null, null, null, false, true);
		$grid->addColumn('address', 'Address', 'string', NULL, true, null, null, null, null, true, false);  
		$grid->addColumn('assigned_to', 'Person<BR/>Responsible', 'string',fetch_pairs($mysqli,'SELECT usr_id, username FROM dim_users'),true, null, null, null, null, true, false); 
		$grid->addColumn('est_end_date', 'Term', 'date', NULL, true, null, null, null, null, true, false); 
		$grid->addColumn('real_end_date', 'Actual<BR/>End date', 'date', NULL, true, null, null, null, null, true, false); 
		$grid->addColumn('est_touchtime', 'Estimated<br/>touchtime<br/>(hours)', 'integer', NULL, false, null, null, null, null, true, false);
		$grid->addColumn('real_touchtime', 'Actual<BR/>Touchtime<br/>(hours)', 'integer', NULL, false, null, null, null, null, true, false);
		$grid->addColumn('est_duration', 'Estimated<br/>duration<br/>(days)', 'integer', NULL, false, null, null, null, null, true, false);
		$grid->addColumn('real_duration', 'Actual<BR/>Duration<br/>(days)', 'integer', NULL, false, null, null, null, null, true, false);
		$grid->addColumn('action', 'Project<br/>Details', 'html', NULL, false, 'id', 'taskgrp', 'task', 'level', true, false);
		// $rown=1;
		// while ($row = $grid->getColumnLabels()) {  
			// foreach($row as $key => $value)
			// {
			  // ChromePhp::log('loadprojects: row['.$rown.']= '.$key." has the value ". ($value?$value:"null"));
			// }
			// $rown++;
		// }
		$mydb_tablename = (isset($_GET['db_tablename'])) ? stripslashes($_GET['db_tablename']) : 'FCT_PROJECTS';
		$querystring = "SELECT '".$level."' as level, start_date, detl_name, prj_type_name, id, task_grp_id, task_id, address, assigned_to, est_end_date, real_end_date, est_touchtime, real_touchtime, est_duration, real_duration FROM ".$mydb_tablename;
		ChromePhp::log("querystring = ".$querystring);
		$result = $mysqli->query($querystring);
		$mysqli->close();
		// send data to the browser
		ChromePhp::log('loadprojects: checking the mysqli result...'); 
		$num=$result->num_rows;
		ChromePhp::log('loadprojects: result has '.$num.' rows'); 
		$rowno=1;
		while ($row = $result->fetch_assoc()) {  
			foreach($row as $key => $value)
			{
			  ChromePhp::log('loadprojects: row['.$rowno.']= '.$key." has the value ". ($value?$value:"null"));
			}
			$rowno++;
		}
		mysqli_data_seek($result, 0);
		ChromePhp::log('loadprojects: finished checking the mysqli result... now sending the result as JSON'); 
		$grid->renderJSON($result);
	} else {
		ChromePhp::log('loadprojects.php: level == "projects" user == "'.strtolower($user).'"');
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
		$grid->addColumn('start_date', 'Start date', 'date', NULL, true, null, null, null, null, true, false);
		$grid->addColumn('detl_name', 'Detl', 'string',fetch_pairs($mysqli,'SELECT detl_id, detl_name FROM dim_prj_detl'), true, null, null, null, null, true, false); 
		$grid->addColumn('prj_type_name', 'Type', 'string',fetch_pairs($mysqli,'SELECT prj_type_id, prj_type_name FROM dim_prj_types'),true, null, null, null, null, true, false); 
		$grid->addColumn('id', 'ID', 'integer', NULL, false, null, null, null, null, false, true);
		$grid->addColumn('address', 'Address', 'string', NULL, true, null, null, null, null, true, false);  
		$grid->addColumn('assigned_to', 'Person<BR/>Responsible', 'string',fetch_pairs($mysqli,'SELECT usr_id, username FROM dim_users'),true, null, null, null, null, true, false); 
		$grid->addColumn('est_end_date', 'Term', 'date', NULL, true, null, null, null, null, true, false); 
		$grid->addColumn('real_end_date', 'Actual<BR/>End date', 'date', NULL, true, null, null, null, null, true, false); 
		$grid->addColumn('est_touchtime', 'Estimated<br/>touchtime<br/>(hours)', 'integer', NULL, false, null, null, null, null, true, false);
		$grid->addColumn('real_touchtime', 'Actual<BR/>Touchtime<br/>(hours)', 'integer', NULL, false, null, null, null, null, true, false);
		$grid->addColumn('est_duration', 'Estimated<br/>duration<br/>(days)', 'integer', NULL, false, null, null, null, null, true, false);
		$grid->addColumn('real_duration', 'Actual<BR/>Duration<br/>(days)', 'integer', NULL, false, null, null, null, null, true, false);
		$grid->addColumn('action', 'Project<br/>Details', 'html', NULL, false, 'id', 'taskgrp', 'task', 'level', true, false);
		// $qqq=$grid->getColumnLabels();
		// ChromePhp::log('loadprojects: qqq= '.$qqq);
		$mydb_tablename = (isset($_GET['db_tablename'])) ? stripslashes($_GET['db_tablename']) : 'fct_projects';
		$querystring = "SELECT '".$level."' as level, start_date, detl_name, prj_type_name, id, task_grp_id, task_id, address, assigned_to, est_end_date, real_end_date, est_touchtime, real_touchtime, est_duration, real_duration FROM ".$mydb_tablename." WHERE assigned_to in (SELECT usr_id FROM dim_users WHERE username='".strtolower($user)."') AND (taskgrp is null OR taskgrp = '') AND (task is NULL OR task = '')";
		ChromePhp::log("querystring = ".$querystring);
		$result = $mysqli->query($querystring);
		$mysqli->close();
		// send data to the browser
		ChromePhp::log('loadprojects: checking the mysqli result...'); 
		$num=$result->num_rows;
		ChromePhp::log('loadprojects: result has '.$num.' rows'); 
		$rowno=1;
		while ($row = $result->fetch_assoc()) {  
			foreach($row as $key => $value)
			{
			  ChromePhp::log('loadprojects: row['.$rowno.']= '.$key." has the value ". ($value?$value:"null"));
			}
			$rowno++;
		}
		mysqli_data_seek($result, 0);
		ChromePhp::log('loadprojects: finished checking the mysqli result... now sending the result as JSON'); 
		$grid->renderJSON($result);
	}
} elseif ($level == "grouptasks"){
	ChromePhp::log('loadprojects.php: grouptasks list to be processed');
	
} elseif ($level == "tasks"){
	ChromePhp::log('loadprojects.php: tasks  list to be processed');	
} elseif ($level == "Error"){
	ChromePhp::log('missing level');	
}
?> 

