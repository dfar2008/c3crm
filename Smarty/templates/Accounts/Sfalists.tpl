<script type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>
<style>
{literal}
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
  padding:0px;
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
  padding:0px;
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
  padding:0px;
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
}
{/literal}
</style>
 <!-- center start -->
 <div class="container-fluid" style="height:606px;">
    <div class="row-fluid">
      <div class="span2">
           <div class="accordion" id="accordion2" style="margin-top:0px;margin-bottom:0px;overflow:auto;height:550px;">
            
            {include file="$MODULE/DetailLeft.tpl"}

         </div>
      </div>
       <div class="span10" style="margin-left:10px;height:600px;overflow:auto;">
          <table class="table table-bordered table-condensedfordv dvtable">
                <tr>
                <th  align="left" style="background:#DFEBEF;height:25px;"><i class="cus-hourglass"></i>&nbsp;<b>SFA 销售自动化</b></th>  
                </tr>
                <tr  style="border-bottom:1px solid #999999;">
                  <td style="background: none repeat scroll 0 0 #E8E8E8;">启动 SFA序列: 
                        <select id="sfasettingsid" name="sfasettingsid">
                          <option value="0">无</option>
                              {$sfasettingshtml}
                        </select>
                        
                        <input type="button" name="qidong" value=" 开始 " class="btn btn-small btn-primary" onclick="CreateSfaList();"  />
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="accordion" id="accordion3" style="height:500px;overflow:auto;">
                       <div class="accordion-group" >
                            <div class="accordion-heading">
                              <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#sfaone">
                                <i class="cus-color_swatch"></i>&nbsp;
                                <b>正在执行的序列：</b>图示【<img border="0" src="{$IMAGE_PATH}s31.png">成功<img border="0" src="{$IMAGE_PATH}s32.png">跳过<img border="0" src="{$IMAGE_PATH}s33.png">执行失败<img border="0" src="{$IMAGE_PATH}me.png">未执行/再次执行】  背景【<img border="0" src="{$IMAGE_PATH}sfa_blue_1.gif">正常的<img border="0" src="{$IMAGE_PATH}sfa_yellow_1.gif">正在执行期内<img border="0" src="{$IMAGE_PATH}sfa_gray_1.gif">过期未执行的】
                              </a>
                            </div>
                            <div id="sfaone" class="accordion-body collapse in" >
                              <div class="accordion-inner">
                                  {foreach item=now key=key from=$Sfalists_now}
                                    <div style="height:25px;">&nbsp;&nbsp;&nbsp;&nbsp;{$now}</div>
                                        <div style="padding-left:35px;">
                                         {foreach item=data from=$sfalist_now_events_list.$key}
                                          &nbsp;&nbsp;&nbsp;&nbsp;{$data}
                                         {/foreach}
                                        </div>
                                        <br>
                                  {/foreach}
                              </div>
                            </div>
                      </div>

                      <div class="accordion-group" >
                          <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#sfatwo">
                              <i class="cus-color_swatch"></i>&nbsp;<b>停止执行的序列</b>
                            </a>
                          </div>
                          <div id="sfatwo" class="accordion-body collapse" >
                            <div class="accordion-inner">
                              {foreach item=over from=$Sfalists_over}
                               <div style="height:20px;">
                                 &nbsp;&nbsp; &nbsp;&nbsp;{$over}</div> 
                              {/foreach}
                           </div>
                         </div>
                       </div>

                       <div class="accordion-group" >
                          <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#sfathree">
                              <i class="cus-color_swatch"></i>&nbsp;<b>最近执行的事件</b>
                            </a>
                          </div>
                          <div id="sfathree" class="accordion-body collapse" >
                            <div class="accordion-inner">
                                 {foreach item=log from=$Sfalogs}
                                    <div style="height:20px;">&nbsp;&nbsp;&nbsp;&nbsp;{$log}</div> 
                                  {/foreach}
                           </div>
                         </div>
                       </div>

                     </div>

                  </td>
                </tr>
            </table>   

       </div>
      </div>
    </div>
 </div>
<div id="createsfalist" class="modal hide fade" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:800px;margin-left:-400px;z-index:1050;"></div>

<div id="openeditdiv" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:800px;margin-left:-400px;"></div>

<div id="opendeldiv" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:800px;margin-left:-400px;"></div>

<div id="openzhongzhidiv" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:800px;margin-left:-400px;"></div>

<div id="openruneventdiv" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:800px;margin-left:-400px;"></div>

<script language="javascript">
  var accountid = '{$ID}';
{literal}
function CreateSfaList(){
  var sfasettingsid = document.getElementById("sfasettingsid").value;
  if(sfasettingsid == 0){
    alert("请先选择方案！");
    return false;
  }
  var urlstring = 'index.php?module=Sfalists&action=SfalistsAjax&file=EditViewForAct&accountid='+accountid+'&sfasettingsid='+sfasettingsid;
  $("#status").prop("display","inline");
  $.ajax({  
       type: "GET",  
       //dataType:"Text",   
       url:urlstring,
       success: function(msg){   
         $("#status").prop("display","none");
         $("#createsfalist").html(msg); 
       }  
  }); 
  $('#createsfalist').modal('show');
}
function openEdit(sfalistsid){
  var url = 'index.php?module=Sfalists&action=SfalistsAjax&file=EditView&from=Accounts&record='+sfalistsid;
  $("#status").prop("display","inline");
  $.ajax({  
       type: "GET",  
       //dataType:"Text",   
       url:url,
       success: function(msg){   
         $("#status").prop("display","none");
         $("#openeditdiv").html(msg); 
       }  
  }); 
  $('#openeditdiv').modal('show');
}

function openDel(sfalistsid){
  var url = 'index.php?module=Sfalists&action=SfalistsAjax&file=Shanchu&from=Accounts&record='+sfalistsid;
  $("#status").prop("display","inline");
  $.ajax({  
       type: "GET",  
       //dataType:"Text",   
       url:url,
       success: function(msg){   
         $("#status").prop("display","none");
         $("#opendeldiv").html(msg); 
       }  
  }); 
  $('#opendeldiv').modal('show');
}
function openZhongzhi(sfalistsid){
  var url = 'index.php?module=Sfalists&action=SfalistsAjax&file=Zhongzhi&from=Accounts&record='+sfalistsid;
  $("#status").prop("display","inline");
  $.ajax({  
       type: "GET",  
       //dataType:"Text",   
       url:url,
       success: function(msg){   
         $("#status").prop("display","none");
         $("#openzhongzhidiv").html(msg); 
       }  
  }); 
  $('#openzhongzhidiv').modal('show');
}

function openRunEvent(sfalisteventsid){
  var url = 'index.php?module=Sfalists&action=SfalistsAjax&file=RunEvent&from=Accounts&record='+sfalisteventsid;
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
  $('#openruneventdiv').modal('show');
}
 
{/literal}
</script>