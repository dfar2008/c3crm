<!doctype html> 
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>{$APP.$MODULE_NAME} - {$APP.LBL_BROWSER_TITLE}</title>
    <meta name="description" content="">
    <meta name="author" content="">
   
    <!-- Mobile viewport optimized: j.mp/bplateviewport -->
    <meta name="viewport" content="width=device-width,initial-scale=1">
    
    <!-- CSS -->
    <link href="themes/bootcss/css/bootstrap.css" rel="stylesheet">
    <link href="themes/bootcss/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="themes/bootcss/css/style.css" rel="stylesheet">
    <link href="themes/bootcss/css/cus-icons.css" rel="stylesheet">
    <link href="themes/bootcss/css/main.css" rel="stylesheet">
    <link href="themes/bootcss/css/datepicker.css" rel="stylesheet">

    <link href="themes/images/dtree.css" type="text/css" rel=stylesheet>
      
    <script src="themes/bootcss/js/jquery-latest.js"></script>
    <script src="themes/bootcss/js/bootstrap.min.js"></script>
    <script src="themes/bootcss/js/bootstrap-datepicker.js"></script>
   
    <script src="themes/bootcss/js/script.js"></script>
    <script src="include/js/general.js"></script>
    <script src="include/js/zh_cn.lang.js"></script>
    <script src="include/js/dtree.js"></script>

  </head>
  
  <body>
    <div class="container-fluid wraper">
      <div class="row-fluid">
              <div class="span2" style="padding-top:2px;padding-left:10px;">
                <img src="themes/bootcss/img/logonew.png">
              </div>
              <div class="span5">
                &nbsp;
              </div>
              <div class="span5" style="padding-top:10px;">
                  <div class="pull-right navbar topbar" style="margin-bottom:5px;">
                    <ul class="nav" style="height:15px;">
                          <li ><a href="index.php?module=Qunfas&action=index"><i class="cus-phone"></i>手机短信</a></li>
                          <li ><a href="index.php?module=Relsettings&action=index"><i class="cus-cog"></i>&nbsp;个人设置</a></li>
			  <li ><a href="index.php?module=Settings&action=index"><i class="cus-cog"></i>&nbsp;系统设置</a></li>
			  <li ><a href="index.php?module=Caches&action=index"><i class="cus-cog"></i>&nbsp;清除缓存</a></li>
                          <li ><a href="Logout.php"><i class="icon-off"></i>&nbsp;退出</a></li>
                        </ul>                            
                  </div>
              </div>
      </div>
    </div>
        <div class="navbar navbar-inverse " style="position:static;margin-bottom:5px;">
          <div class="navbar-inner">
            <div class="container">
              <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </a>
              <a class="brand" href="#" >&nbsp;&nbsp;&nbsp;</a>
              <div class="nav-collapse collapse navbar-inverse-collapse">
                <ul class="nav">
                {foreach key=maintabs item=detail from=$HEADERS} 
          				{if $detail ne $MODULE_NAME}
          					<li class="dropdown ">
          						<a href="index.php?module={$detail}&action=index" class="dropdown-toggle" >{$APP[$detail]}</a>
						</li>
          				{else}
          					<li class="dropdown active">
          						<a href="index.php?module={$detail}&action=index" class="dropdown-toggle" >{$APP[$detail]}</a>
						</li>
          				{/if}	
          			{/foreach}
                </ul>
                
                  <form class="navbar-search pull-right" action="">
                      <input type="text" class="search-query span2" placeholder="Search">
                  </form>
              </div><!-- /.nav-collapse -->
            </div>
          </div><!-- /navbar-inner -->
        </div><!-- /navbar -->
        <div class="bs-docs-example secondtitle" >
          
        </div>
<div id="status" style="position:absolute;display:none;left:930px;top:95px;height:27px;white-space:nowrap;"><img src="{$IMAGEPATH}status.gif"></div>
<div id="SelCustomer_popview" class="layerPopup" style="position: absolute; z-index: 60; "></div>
<div id="searchallacct" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:800px;margin-left:-400px;"></div>
 <div id="selectProductRows" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:800px;margin-left:-400px;"></div>
