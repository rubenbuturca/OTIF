<?php

echo "<!DOCTYPE html>\n";
echo "<head>\n";
echo "	<meta charset=\"utf-8\">\n";
echo "	<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\">\n";
echo "	<title>OTIF</title>\n";
echo "	<link rel=\"stylesheet\" href=\"css/style.css\">\n";
echo "	<style type=\"text/css\">\n";
echo "		img {\n";
echo "		max-width: 100%;\n";
echo "		height: auto;\n";
echo "		}\n";
echo "	</style>\n";
echo "</head>\n";
echo "<body>\n";
echo "	<section class=\"banner\"> <img src=\"img/banner.gif\" alt=\"OTIF\"> </section>\n";
echo "	<section class=\"container\">\n";
echo "	<div class=\"login\">\n";
echo "	<h1>Login to OTIF</h1>\n";
echo "	<form method=\"post\" action=\"index.php\">\n";
echo "	<p>\n";
echo "		<input type=\"text\" name=\"username\" value=\"\" placeholder=\"Username\">\n";
echo "	</p>\n";
echo "	<p>\n";
echo "		<input type=\"password\" name=\"password\" value=\"\" placeholder=\"Password\">\n";
echo "	</p>";

?>
