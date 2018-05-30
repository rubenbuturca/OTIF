<?php 
echo "<html>\n";
echo "	<head>\n";
echo "		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n";
echo "		<title>OTIF</title>\n";
echo "		<link rel=\"stylesheet\" href=\"css/style.css\" type=\"text/css\" media=\"screen\">\n";
echo "		<link rel=\"stylesheet\" href=\"css/responsive.css\" type=\"text/css\" media=\"screen\">\n";
echo "\n";
echo "        <link rel=\"stylesheet\" href=\"//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css\" />\n";
echo "		<link rel=\"stylesheet\" href=\"css/font-awesome-4.1.0/css/font-awesome.min.css\" type=\"text/css\" media=\"screen\">\n";
echo "        	</head>\n";
echo "	<body>\n";
echo "		<section class=\"banner\">\n";
//echo "			<img src=\"img/banner.gif\" alt=\"OTIF\">\n";
echo "		</section>\n";
echo "		<div id=\"greeting_user\">\n";
echo "		";
ChromePhp::log('home_top.php: Checking user...'); 
if (empty($_SESSION["user"])&&empty($_GET["user"])) { 
	echo "			No user session active!";
} elseif (strtolower($_SESSION["user"]) == "giedre"||strtolower($_GET["user"]) == "giedre") {
	if (empty($_SESSION["user"])){
		echo "		Labas ".$_GET["user"]."! You have <a href='admin.php'>administrator</a> rights!";
	} else {
		echo "		Labas ".$_SESSION["user"]."! You have <a href='admin.php'>administrator</a> rights!";					
	}
} else {	
	echo "		Labas ".$_SESSION["user"]."!";
}
ChromePhp::log('home_top.php: Displaying user greeting...'); 
if (empty($_SESSION["user"])){
	echo "<input type=\"hidden\" id=\"user\" name=\"user\" value=\"".$_GET["user"]."\">";
} else {
	echo "<input type=\"hidden\" id=\"user\" name=\"user\" value=\"".$_SESSION["user"]."\">";
}
ChromePhp::log('home_top.php: Checking level...'); 
if(isset($_GET['level']) && !empty($_GET['level'])){
	ChromePhp::log('home_top.php: level='.$_GET["level"]); 
	echo "<input type=\"hidden\" id=\"level\" name=\"level\" value=\"".$_GET["level"]."\">";
} else {
	ChromePhp::log('home_top.php: level=projects'); 
	echo "<input type=\"hidden\" id=\"level\" name=\"level\" value=\"projects\">";
}
echo "		</div>";
?>	