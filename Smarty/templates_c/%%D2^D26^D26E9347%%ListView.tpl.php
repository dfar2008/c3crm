<?php /* Smarty version 2.6.18, created on 2013-07-01 16:20:33
         compiled from SfaDesktops/ListView.tpl */ ?>
 <style>
<?php echo '
.trbt{
    background-color:#DFEBEF;
    height:25px;
    padding-left:0px;
    border-bottom:1px solid #999;
    border-left:1px solid #999;
    border-top:1px solid #999;
    border-right:1px solid #999;
}

.tdw{
    border-bottom:1px solid #999;
    border-left:1px solid #999;
    border-top:1px solid #999;
    border-right:1px solid #999;
}
.clear{
    clear:left;     
}
.zhengchang {
    float:left; 
}
.zhengchang li{
    height:21px;
    float:left;
    background: url("themes/softed/images/sfa_blue.png") no-repeat scroll 0 0 transparent;
    list-style: none outside none;
    padding-top:1px;
}
.zhengchang li a{
    height:21px;
    background: url("themes/softed/images/sfa_blue.png") repeat-x scroll 0 -21px transparent;
    display: inline-block;
    line-height: 21px;
    padding: 0 0 0 5px;
}
.zhengchang li a span{
    height:21px;
    display: inline-block;
    line-height: 21px;
    padding-right: 21px;
    background: url("themes/softed/images/sfa_blue.png") no-repeat scroll right -42px transparent;
}
.guoqi {
    float:left; 
}
.guoqi li{
    height:21px;
    float:left;
    background: url("themes/softed/images/sfa_gray.png") no-repeat scroll 0 0 transparent;
    list-style: none outside none;
    padding-top:1px;
}
.guoqi li a{
    height:21px;
    background: url("themes/softed/images/sfa_gray.png") repeat-x scroll 0 -21px transparent;
    display: inline-block;
    line-height: 21px;
    padding: 0 0 0 5px;
}
.guoqi li a span{
    height:21px;
    display: inline-block;
    line-height: 21px;
    padding-right: 21px;
    background: url("themes/softed/images/sfa_gray.png") no-repeat scroll right -42px transparent;
}
.jinxing {
    float:left; 
}
.jinxing li{
    height:21px;
    float:left;
    background: url("themes/softed/images/sfa_yello.png") no-repeat scroll 0 0 transparent;
    list-style: none outside none;
    padding-top:1px;
}
.jinxing li a{
    height:21px;
    background: url("themes/softed/images/sfa_yello.png") repeat-x scroll 0 -21px transparent;
    display: inline-block;
    line-height: 21px;
    padding: 0 0 0 5px;
}
.jinxing li a span{
    height:21px;
    display: inline-block;
    line-height: 21px;
    padding-right: 21px;
    background: url("themes/softed/images/sfa_yello.png") no-repeat scroll right -42px transparent;
}

li.sfasn {
    color: #000000;
    display: inline;
    float: left;
    font-family: 宋体;
    margin-bottom: 3px;
    white-space: nowrap;
}
li {
    line-height:150%;   
    text-align:left;
}
'; ?>

</style>
 <div class="container-fluid" style="height:602px;overflow:auto;">
           <!--Dashboad-->
        <div id="columns" class="row-fluid">
            <ul id="widget1" class="column ui-sortable unstyled">
                <li id="Widget1" class="widget">
                    <div class="widget-head">
                        <span><b>7天内待联系客户(下次联系日期)</b></span></div>
                    <div class="widget-content" style="overflow: auto;height:260px;">
                            <ul style="line-height:10px;margin-top:-5px;list-style:none;">
                                <?php $_from = $this->_tpl_vars['NEXTCONTACTACCOUNT']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['nextcontactacc']):
?>
                                    &nbsp;&nbsp;<li><?php echo $this->_tpl_vars['nextcontactacc']; ?>
</li>
                                <?php endforeach; else: ?>
                                 &nbsp;&nbsp;<li>暂无</li>
                                <?php endif; unset($_from); ?>
                            </ul>
                    </div>
                </li>
               <li id="Widget3" class="widget">
                    <div class="widget-head">
                        <span><b>执行失败的SFA</b></span></div>
                    <div class="widget-content" style="overflow: auto;height:260px;">
                            <ul style="line-height:10px; margin-top:-5px;list-style:none;">
                                <?php $_from = $this->_tpl_vars['SFALISTEVENTS_FAILED']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['failed']):
?>
                                    &nbsp;&nbsp;<li ><?php echo $this->_tpl_vars['failed']; ?>
</li>
                                <?php endforeach; else: ?>
                                 &nbsp;&nbsp;<li>暂无</li>
                                <?php endif; unset($_from); ?>
                            </ul>
                    </div>
                </li>
            </ul>
            <ul id="widget2" class="column ui-sortable unstyled">
                
                <li id="Widget5" class="widget">
                    <div class="widget-head">
                        <span><b>一月内到期纪念日(<font color=red>客户名称/公历纪念日</font>)</b></span></div>
                    <div class="widget-content" style="overflow: auto;height:260px;">
                       <ul style="line-height:10px;margin-top:-5px;list-style:none;">
                            <?php $_from = $this->_tpl_vars['ONEMONTHMEMDAY']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['onemonthmemday']):
?>
                                &nbsp;&nbsp;<li ><?php echo $this->_tpl_vars['onemonthmemday']; ?>
</li>
                            <?php endforeach; else: ?>
                             &nbsp;&nbsp;<li>暂无</li>
                            <?php endif; unset($_from); ?>
                        </ul>
                    </div>
                </li>
                <li id="Widget2" class="widget">
                    <div class="widget-head">
                        <span><b>最近自动执行成功的SFA日志</b></span></div>
                    <div class="widget-content" style="overflow: auto;height:260px;">
                        <ul style="line-height:10px;margin-top:-5px;list-style:none;">
                            <?php $_from = $this->_tpl_vars['SFALISTEVENTS_SUCCESSLOG']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['successlog']):
?>
                                &nbsp;&nbsp;<li ><?php echo $this->_tpl_vars['successlog']; ?>
</li>
                            <?php endforeach; else: ?>
                             &nbsp;&nbsp;<li>暂无</li>
                            <?php endif; unset($_from); ?>
                        </ul>
                    </div>
                </li>
            </ul>
            <ul id="widget3" class="column ui-sortable unstyled">
                 <li id="Widget4" class="widget">
                    <div class="widget-head">
                        <span><b>需要我执行的SFA</b> <font color=red> (开始日期 ≤ 今天 ≤ 结束日期 和 不限定日期)</font></span></div>
                    <div class="widget-content" style="overflow: auto;height:260px;">
                        <ul style="line-height:10px;margin-top:-5px;list-style:none;">
                            <?php $_from = $this->_tpl_vars['SFALISTEVENTS_DO']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['do']):
?>
                               &nbsp;&nbsp;<li ><?php echo $this->_tpl_vars['do']; ?>
</li>
                            <?php endforeach; else: ?>
                             &nbsp;&nbsp;<li>暂无</li>
                            <?php endif; unset($_from); ?>
                        </ul>
                    </div>
                </li>
                
                <li id="Widget6" class="widget">
                    <div class="widget-head">
                        <span><b>最近自动执行失败的SFA日志</b></span></div>
                    <div class="widget-content" style="overflow: auto;height:260px;">
                         <ul style="line-height:10px; margin-top:-5px;list-style:none;">
                            <?php $_from = $this->_tpl_vars['SFALISTEVENTS_FAILLOG']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['faillog']):
?>
                                &nbsp;&nbsp;<li ><?php echo $this->_tpl_vars['faillog']; ?>
</li>
                            <?php endforeach; else: ?>
                             &nbsp;&nbsp;<li>暂无</li>
                            <?php endif; unset($_from); ?>
                        </ul>
                    </div>
                </li>
            </ul>
            
        </div>
         <div id="columns" class="row-fluid" >
            <ul id="widget8" class="ui-sortable unstyled" style="width:99.5%">
                <li id="Widget8" class="widget" style="margin-top:10px;">
                    <div class="widget-head">
                        <span><b>SFA方案对应客户(未结束)</b></span></div>
                    <div class="widget-content" style="overflow: auto;height:260px;">
                            <ul style="line-height:10px;margin-top:-5px;list-style:none;">
                                <?php $_from = $this->_tpl_vars['SFASETTINGACCOUNT']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['acc']):
?>
                                    &nbsp;&nbsp;<li ><?php echo $this->_tpl_vars['acc']; ?>
</li>
                                <?php endforeach; else: ?>
                                 &nbsp;&nbsp;<li>暂无</li>
                                <?php endif; unset($_from); ?>
                            </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>

<div id="openruneventdiv" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:800px;margin-left:-400px;"></div>


<script type="text/javascript">
 <?php echo '

function openRunEvent(sfalisteventsid){
  var url = \'index.php?module=Sfalists&action=SfalistsAjax&file=RunEvent&from=Accounts&record=\'+sfalisteventsid;
  $("#status").prop("display","inline");
  $.ajax({  
       type: "GET",  
       //dataType:"Text",   
       url:url,
       success: function(msg){  
         $("#status").prop("display","none");
         $("#openruneventdiv").html(msg); 
       }  
  }); 
  $(\'#openruneventdiv\').modal(\'show\');
}
 '; ?>

</script>