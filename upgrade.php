<?php
/*****
新浪云商店自动升级demo

自动升级程序依赖于sae的SVN版本控制


*/
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8"); 
define( 'DS' , DIRECTORY_SEPARATOR );
define( 'AROOT' , dirname( __FILE__ ) . DS  );
$rv_file = AROOT.'app.info';
$rv_info = parse_ini_file($rv_file);
$upgrade_api = 'http://qyapi.sae.sina.com.cn/qy_updater.php?appname=%s&rv=%s';
if(!$rv_info)
    echo 'info file error';

$query = sprintf($upgrade_api, substr($rv_info['appname'],5),$rv_info['revision']);

$ret = getJsonContentsAndDecode($query);


if($ret && $ret['code']==0)
{
    if($ret['data']['result']=='last'){
        echo 'last version';
    }else{
        $url = parse_url($ret['data']['result']);
        $path = $url['path'];
        $path_parts = pathinfo($path);
        $down_file = AROOT.$path_parts["basename"];
        $down = download_file($ret['data']['result'],$down_file);

        if (file_exists($down_file)) {

            include_once( 'dUnzip2.inc.php' );
            $zip = new dUnzip2( $down_file );
            @mkdir( AROOT . 'apps'.DS . $folder );
            $zip->debug = false;	
        
            $zip->unzipAll( AROOT  );
			$root_directory = dirname(__FILE__)."/";
			require($root_directory.'include/init.php');
			global $adb;
			$filepath = require($root_directory.'storage/upgrade.sql');
			sql_import($filepath);
            
				
			echo 'done';
        } else {
            echo 'failed';
        }        
    }
}else{
	echo 'api error';
}

function download_file($file_url, $save_to)
{
    $in=    fopen($file_url, "rb");
    $out=   fopen($save_to, "wb");
    while ($chunk = fread($in,8192))
    {
        $c = fwrite($out, $chunk, 8192);
    }
    fclose($in);
    fclose($out);
}


function getJsonContentsAndDecode($url)	//获取对应URL的JSON格式数据并解码
{
    if(empty($url))
        return false;
    $ch=curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,3);
    curl_setopt($ch,CURLOPT_TIMEOUT,12);
    curl_setopt($ch,CURLOPT_HTTPGET,true);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_FRESH_CONNECT,true);
    $content=curl_exec($ch);
    curl_close($ch);
    $ch=null;
	//var_dump($content);
    if(false !== $content)
    {
        $ret=json_decode($content,true);
        if(null === $ret)
        {
            return false;
        }
        else
        {
            return $ret;
        }
    }
    else
        return false;
}

?>