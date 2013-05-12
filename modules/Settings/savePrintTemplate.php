<?php
	require "config.php";
	$content=$_REQUEST['content'];
	$type=$_REQUEST['type'];
        if($type == "0")
        {
            echo "请选择模块进行编辑";
        }
        else
        {
            $type1 = $type.".html";
            $dic=$root_directory."modules/{$type1}";
//          echo $dic;
            $result=file_put_contents($dic,$content);
            if ($result>0)
            echo "保存成功";
            else
            {
            	echo "保存失败";
            }
        }
?>