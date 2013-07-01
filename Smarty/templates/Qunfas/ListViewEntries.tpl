{if $smarty.request.ajax neq ''}
&#&#&#{$ERROR}&#&#&#
{/if}

     <input id="viewname" name="viewname" type="hidden" value="">

				<!-- List View Master Holder starts -->
				<table class="table table-bordered table-hover table-condensed table-striped">
				  <tr>
				   <td>
              		   <table class="table table-bordered">
                          <tr>
                          	<td bgcolor="#EFEFEF" align="center"  width="15%" valign="top">
                              <table class="table table-bordered">
								              <tbody>
                                <tr>
                                <td>
                                 <p>
                                  <br>
                                  1.选择分组，添加该分组所有客户至接收人手机。<br><br>
                           		    2.如果没有你需要的分组，可自行创建新分组。<br><br>
                                  3.群发前，可输入自己的手机号和姓名，测试发送。
                                  例如: <font color=red><b>13166337788(张三)</b></font><br><br>
                                  4.手机号码为空的客户，分组导入自动忽略<br><br>
                                  5.<font color=red>同一手机号间隔发送时间不得少于20秒</font><br><br>
                                  6.<font color=red>一次发送最好不多于30个客户</font><br><br>
                                  7.<font color=red>每行一个客户</font><br><br><br><br>
                                  </p>
                                </td>
                                </tr>
                                </tbody>
                                </table>
                            </td>
                            <td  valign="top" bgcolor="#EFEFEF" align="center" width="20%">
                              <table class="table table-bordered">
						            	   	<tbody>
                                <tr>
                                <td>
                                <p align="center">
                                <b>
                                &nbsp;接收人手机
                                <br>
                                </b>
                                <font color="#808080">每行一个号码</font>
                                </p>
                                </td>
                                </tr>
                                <tr>
                                <td valign="top">
                                <p align="center">
                                <textarea style="line-height: 150%;width: 240px; height: 380px;" cols="35" name="dst" rows="8" id="receiveaccountinfo" >{$receiveaccountinfo}</textarea>
                                </p>
                                </td>
                                </tr>
                                </tbody>
                                </table>
                             </td>
                            <td valign="top" bgcolor="#EFEFEF" align="center" width="20%">
                                <table class="table table-bordered">
                                <tbody>
                                <tr>
                                <td>
                                <p align="center">
                                <b>
                                <font color="#000000">&nbsp;短信内容</font> <br>
                                </b>
                                <select name="dxmb" onchange="setSendContent(this);">
                                <option value="">---不使用---</option>
                                {foreach item=tpl from=$QUNFATMPS}
                               	 <option value="{$tpl[2]}">{$tpl[1]}</option>
                                {/foreach}
                                </select>
                                
                                <input class="btn btn-small btn-primary" type="button" onclick="window.open('index.php?module=Qunfas&action=QunfasAjax&file=CreateTmps','CreateTmps','top=100,left=200,height=315,width=500,scrollbars=yes,menubar=yes,addressbar=no,status=yes')" name="profile" value="新增模版"></p>
                                </td>
                                </tr>
                                
                                <tr>
                                <td valign="top">
                                <p align="center">
                                <textarea style="line-height: 150%; width: 337px; height: 299px;" cols="35" name="msg" rows="8" id="sendmessageinfo" onkeyup="checkFieldNum();"></textarea>
                                </p>
                                <div>选择开始发送时间: &nbsp;

                                    <span id="jscal_field_sendtime" class="input-append date">
                                      <input data-format="yyyy-MM-dd hh:mm" type="text" name="sendtime"></input>
                                      <span class="add-on">
                                        <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                        </i>
                                      </span>
                                    </span>
                                  <script type="text/javascript">
                                  {literal}
                                    $(function() {
                                      $('#jscal_field_sendtime').datetimepicker({
                                        language: 'pt-BR'
                                      });
                                    });
                                    {/literal}
                                  </script>


								                 <div style="letter-spacing:3px;">>><font color=red>发送时间为空</font>则即时发送。</div>
                                </div>
                                </td>
                                </tr>
                                </tbody>
                                </table>
                            </td>
                            <td valign="top" bgcolor="#EFEFEF" align="left">
                                <table class="table table-bordered">
                                <tbody>
                                <tr>
                                <td>
                                 <p>
                                  <font color="#FF0000">注意：</font>（您使用本系统发送短信，就表明您同意并接受以下内容）<br><br>

                                    1.不得发送包含以下内容、文字的短信息内容：非法的、骚扰性的、中伤他人的、辱骂性的、恐吓性的、伤害性的、庸俗的、淫秽的信息；教唆他人构成犯罪行为的信息；危害国家安全的信息；及任何不符合国家法律、国际惯例、地方法律规定的信息。<br><br>
                                    2.不能违反运营商规定，不得发送竞争对手产品的广告，不能按手机号段形式进行广告业务的宣传等，不能发送与本行业无关和移动运营商限制和禁止发送的短信内容，特别是广告类信息，群发短信等，对违反此声明产生的一切后果由发送者及其单位承担。<br><br>
                                    3.最好不要在晚22:00至早7:00时段发送短信，以免引起客户反感。<br><br />
                                    4.<font color=red>短信内容不能多于48个字（其中空格，数字，字母，汉字均为一个字）</font><br><br>
                                  </p>
                                  <br />
                                  <br />
                                   <br />
                                  <div id="showzishu">你还能输入:<font color=red><b>65</b></font>个字...</div>
                                </td>
                                </tr>
                                <tr  valign="bottom">
                                <td valign="bottom" style="text-align:center; vertical-align:bottom;padding-top:50px;">
                                <!--<input type="button" name="button" value="测试发送给自己"  onclick="SendMessToSelf('Qunfas');return false;" ><-->
                                 <input type="button" name="savebutton" id="savebutton" value="&nbsp;&nbsp;&nbsp;&nbsp;群发&nbsp;&nbsp;&nbsp;&nbsp; "  class="btn btn-primary" onclick="SendMessToAll('Qunfas');return false;"  />
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
