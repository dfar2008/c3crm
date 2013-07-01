<?php /* Smarty version 2.6.18, created on 2013-07-01 16:22:11
         compiled from Header.tpl */ ?>
<!doctype html> 
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['MODULE_NAME']]; ?>
 - <?php echo $this->_tpl_vars['APP']['LBL_BROWSER_TITLE']; ?>
</title>
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
                    <ul class="nav" style="height:20px;">
                          <li ><a href="index.php?module=Qunfas&action=index"><i class="cus-phone"></i>短信</a></li>
                          <li ><a href="index.php?module=Relsettings&action=index"><i class="cus-cog"></i>&nbsp;设置</a></li>
                          <li ><a href="Logout.php"><i class="icon-off"></i>&nbsp;退出</a></li>
                        </ul>                            
                  </div>
              </div>
      </div>
    </div>
        <div class="navbar navbar-blue " style="position:static;margin-bottom:5px;">
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
                <?php $_from = $this->_tpl_vars['HEADERS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['maintabs'] => $this->_tpl_vars['detail']):
?> 
          				<?php if ($this->_tpl_vars['detail'] != $this->_tpl_vars['MODULE_NAME']): ?>
          					<li class="dropdown ">
          						<a href="index.php?module=<?php echo $this->_tpl_vars['detail']; ?>
&action=index" class="dropdown-toggle" ><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['detail']]; ?>
</a>
						</li>
          				<?php else: ?>
          					<li class="dropdown active">
          						<a href="index.php?module=<?php echo $this->_tpl_vars['detail']; ?>
&action=index" class="dropdown-toggle" ><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['detail']]; ?>
</a>
						</li>
          				<?php endif; ?>	
          			<?php endforeach; endif; unset($_from); ?>
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
<div id="status" style="position:absolute;display:none;left:930px;top:95px;height:27px;white-space:nowrap;"><img src="<?php echo $this->_tpl_vars['IMAGEPATH']; ?>
status.gif"></div>
<div id="SelCustomer_popview" class="layerPopup" style="position: absolute; z-index: 60; "></div>
<div id="searchallacct" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:800px;margin-left:-400px;"></div>
 <div id="selectProductRows" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:800px;margin-left:-400px;"></div>