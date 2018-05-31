<?php
include 'ChromePhp.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { //initial page
	ChromePhp::log('didn\'t get here through POST');
    if (empty($_SESSION["user"])&&empty($_GET["user"])) {
		ChromePhp::log('empty(SESSION["user"])... showing login screen');
        include "login_top.php";
        include "login_noerror.php";
        include "login_bottom.php";
        
    } else {
		if($_GET['loaddetails']){
			ChromePhp::log('loading project details...');
			include "home_top.php";
			include "projectdetails.php";
		} else {
			ChromePhp::log('no loaddetails received through GET');
			include "home_top.php";
			if (strtolower($_SESSION["user"]) == "giedre") {
				include "home_admcontent.php";
			} else {
				include "home_content.php";
			}	
		}
    }
    //echo $session_state_text; 
    //echo "<br />initial page";
} else {
	ChromePhp::log('got here through POST');
    $username = null;
    $password = null;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //echo "<BR/>_SERVER[REQUEST_METHOD] == POST<BR/>"; 
        if (empty($_SESSION["user"])) {
			//echo "<BR/>_SESSION[user] is empty<BR/>"; 
            require_once('database.php');
            if (empty($_POST["username"])) {
				include "empty_username.php";
            } elseif (empty($_POST["password"])) {
				include "empty_password.php"; 
            } else { //both a username and a password were supplied, checking them...
                $username = $_POST["username"];
                $password = $_POST["password"];
                require_once('database.php');
                // $sql="SELECT `username` FROM `users` WHERE `username` = '$username'" ; 
                //echo "Executing: " . $sql; 
                //$user=$ conn->query($sql); 
				try {
					$query = $connection->prepare("SELECT `username` FROM DIM_USERS WHERE `username` = ?");
					$query->bind_param("s", $username);
					$query->execute();
					$query->bind_result($user);
					$query->fetch();
					$query->close();
					if (!empty($user)) {
						$_SESSION["user"] = $user;
						//echo "< BR / > _SESSION[user]is[" . $_SESSION["user"] . "] < BR / > "; 
						$query            = $connection->prepare("SELECT`username`FROM DIM_USERS WHERE`username` = ? and `password` = ? ");
						$query->bind_param("ss", $username, $password);
						$query->execute();
						$query->bind_result($userpass);
						$query->fetch();
						$query->close();
						if (!empty($userpass)) {
							//authenticated successfully 
							//session_start();
							//$_SESSION['user']=$user
							ChromePhp::log('loading home_top.php...');
							include "home_top.php";
							if (strtolower($_SESSION["user"]) == "giedre") {
								ChromePhp::log('loading home_admcontent.php...');
								include "home_admcontent.php";
							} else {
								ChromePhp::log('loading home_content.php...');
								include "home_content.php";
							}
						}
						//echo $_SESSION[ "user"];
					} else { //invalid password
						include "login_top.php";
						include "login_pswderror.php";
						include "login_bottom.php";
					}
				} catch (Exception $e) {
					echo 'Caught exception: ',  $e->getMessage(), "\n";
				}
            }
        } else { //invalid username
            include "login_top.php";
            include "login_usrnerror.php";
            include "login_bottom.php";
        }
    } else {
        include "home_top.php";
        if (strtolower($_SESSION["user"]) == "giedre") {
            include "home_admcontent.php";
        } else {
			include "home_content.php";
		}
        echo "Already authenticated with: " . $_SESSION["user"];
    }
}
//echo "<BR/>Session state: " . display_session_state() . "<BR/>";
//echo "<BR/>_SERVER[\'REQUEST_METHOD\']: " . $_SERVER['REQUEST_METHOD'] . "<BR/>";
//echo "<BR/>_POST[\"username\"] = " . $_POST["username"] . " < BR / > ";
//echo " < BR / > print_r(_SESSION) = " . print_r($_SESSION);

?>
                           </body>

                            </html>
