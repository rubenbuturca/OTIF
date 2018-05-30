<?php
global $connection;

if ( isset( $connection ) )
    return;

$connection = new mysqli("sql308.rf.gd", "rfgd_19010923", "Camogli2015", "rfgd_19010923_OTIF");

if (mysqli_connect_errno()) {        
    die(sprintf("Connect failed: %s\n", mysqli_connect_error()));
}
?>