<?php
	require "config.php";
	$type=$_REQUEST['type'];
        if($type == "0")
        {
            $result = " ";
            echo $result;
        }
        else
        {
            $type1 = $type.".html";
            $dic=$root_directory."modules/{$type1}";
            $result=file_get_contents($dic);
            echo $result;
        }
?>