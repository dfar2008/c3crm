<?php /* Smarty version 2.6.18, created on 2013-05-10 11:30:05
         compiled from Maillists/ListViewEntries.tpl */ ?>
<?php if ($_REQUEST['ajax'] != ''): ?>
&#&#&#<?php echo $this->_tpl_vars['ERROR']; ?>
&#&#&#
<?php endif; ?>

<form name="uploadform" method="POST" ENCTYPE="multipart/form-data" action="uploadfileInfo.php" style="margin:0px">
		<input type="hidden" name="module" value="Maillists">
		<input type="hidden" name="action" value="uploadfileInfo">
		<input type="hidden" name="record" value="">
        <input id="viewname" name="viewname" type="hidden" value="">
				<!-- List View Master Holder starts -->
				<table border=0 cellspacing=0 cellpadding=0 width=100% class="lvtBg">
				  <tr>
				   <td>
              		   <table border=0 cellspacing=1 cellpadding=3 width=100% class="lvt small">
                          <tr>
                          	<td bgcolor="#EFEFEF" align="center"  width="20%" valign="top">
                              <table cellspacing="0" cellpadding="3" border="0">
								<tbody>
                                <tr height="25">
                                <td>
                                </td>
                                </tr>
                                <tr>
                                <td>
                                 <p>
				  <font color="red">注意：请先根据cron/readme.txt说明设置群发邮件任务计划，云商店会自动设置，每三分钟发一次，每次100封邮件.</font><br><br>
                                  1.选择分组，添加该分组所有客户至接收人Email。<br><br>
                           		  2.如果没有你需要的分组，可自行创建新分组。<br><br>
                                  3.群发前，请先到<b>控制面板</b>-><b>相关设置</b>中设置SMTP服务器。<br><br>
                                  4.群发前，请先到客户中创建一个自己的客户，再修改测试分组中会员名，测试发送给自己。<br><br>
                                  5.邮件为空的用户,不显示。<br><br>
				  6.邮件发送结束后，可点击<a href="index.php?action=Maillists&module=Relsettings">群发统计</a>查看发送情况。<br><br>
				  7.如果不能配置cron服务，可点击<a href="dosendmail.php">手工发送</a>。<br><br>
                                  </p>
                                </td>
                                </tr>
                                </tbody>
                                </table>
                            </td>
                            <td  valign="top" bgcolor="#EFEFEF" align="center" width="25%">
                              <table cellspacing="0" cellpadding="3" border="0">
								<tbody>
                                <tr>
                                <td>
                                <p align="center">
                                <b>
                                &nbsp;接收人Email
                                <br>
                                </b>
                                <font color="#808080">每行一个邮件</font>
                                </p>
                                </td>
                                </tr>
                                <tr>
                                <td valign="top">
                                <p align="center">
                                <textarea style="line-height: 150%;width: 300px; height: 510px;" cols="35" name="dst" rows="8" id="receiveaccountinfo" ><?php echo $this->_tpl_vars['receiveaccountinfo']; ?>
</textarea>
                                </p>
                                </td>
                                </tr>
                                </tbody>
                                </table>
                             </td>
                            <td valign="top" bgcolor="#EFEFEF" align="center" >
                                <table cellspacing="0" cellpadding="3" border="0" width="100%">
                                <tbody>
                                <tr>
                                <td>
                                <p align="center">
                                <b>
                                <font color="#000000">&nbsp;邮件信息</font> <br>
                                </b>
                                </p>
                                </td>
                                </tr>
                                <tr>
                                <td>
                                <b>发&nbsp;&nbsp;件&nbsp;&nbsp;人: &nbsp;
                               
                                <font color=red><?php if ($this->_tpl_vars['from_name'] != ''): ?>"<?php echo $this->_tpl_vars['from_name']; ?>
"<?php endif; ?> &nbsp;
                                <?php if ($this->_tpl_vars['from_email'] != ''): ?>(<?php echo $this->_tpl_vars['from_email']; ?>
)<?php endif; ?></font></b> 
                                
                                <input name="from_name" id="from_name" value="<?php echo $this->_tpl_vars['from_name']; ?>
" type="hidden">
                                <input name="from_email" id="from_email" value="<?php echo $this->_tpl_vars['from_email']; ?>
" type="hidden">
				<input name="interval" id="interval" value="<?php echo $this->_tpl_vars['interval']; ?>
" type="hidden">
                                </td>
                                </tr>
                                <tr>
                                <td>
                                <b>邮件主题:</b><input name="subject" id="subject" class="txtBox" value="">
                                </td>
                                </tr>
                                <tr>
                                <td valign="top" >
                                <p align="left">
                               <b> 邮件内容:</b><input title="选择Email模版" class="crmbutton small edit" onclick="window.open('index.php?module=Maillisttmps&action=MaillisttmpsAjax&file=lookupemailtemplates','emailtemplate','top=100,left=200,height=400,width=500,menubar=no,addressbar=no,status=yes')" type="button" name="button" value=" 选择Email模版  ">
                               <input class="crmButton create small" type="button" onclick="window.open('index.php?module=Maillists&action=MaillistsAjax&file=CreateTmps','CreateTmps','top=100,left=200,height=315,width=500,scrollbars=yes,menubar=yes,addressbar=no,status=yes')" name="profile" value="新增模版">
                               <br />
                                <textarea rows="15"  name="mailcontent" id="mailcontent" style="height:380px;"></textarea>
                                </p>
				<br>
				<input type="button" name="savebutton" id="savebutton" value="&nbsp;&nbsp;&nbsp;&nbsp;群发&nbsp;&nbsp;&nbsp;&nbsp; "   class="crmbutton small edit" onclick="SendMailToAll('Maillists','<?php echo $this->_tpl_vars['sjid']; ?>
','KE');return false;" />
                                </td>
                                </tr>
                                <tr>
                                <td>
								<!--
                                <input type="button" value=" 上传附件 " class="crmbutton small edit" onclick="window.open('index.php?module=Maillists&action=Popup_upload&sjid=<?php echo $this->_tpl_vars['sjid']; ?>
','uploadtemplate','top=100,left=200,height=200,width=500,menubar=no,addressbar=no,status=yes')">
                                -->
								<input type="hidden" value="<?php echo $this->_tpl_vars['sjid']; ?>
" name="sjid" id="sjid" />
                                </td>
                                </tr>
                                <tr>
                                <td>
                                <div id="maillistattinfo" ></div>
                                </td>
                                </tr>
                                <tr  valign="bottom">
                                <td  style="text-align:center; vertical-align:bottom;padding-top:50px;">
                                 
                                </td>
                                </tr>
                                </tbody>
                                </table>
                            </td>
                           
                            </tr>
               		   </table>
		           </td>
		   	      </tr>
	           </table>
</form>