 <script language="JavaScript" type="text/javascript" src="include/js/ListView.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/search.js"></script>
<script language="JavaScript" type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>

<link href="themes/bootcss/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script src="themes/bootcss/js/bootstrap-datetimepicker.min.js"></script>


 <div class="container-fluid" style="height:606px;"> 
      <div class="row-fluid">
        <div class="span12" style="margin-left:0px;">
           
            <div id="tablink">
              <ul class="nav nav-pills" style="margin-bottom:5px;">
                <li class="nav-header" style="padding-left:0px;padding-right:5px;">
                  <i class="icon-th-list"></i> 
                </li>

                 {foreach name="listviewforeach" key=id item=viewname from=$CUSTOMVIEW_OPTION}
                  {if $id eq $VIEWID} 
                    <li class="active"><a href="javascript:;" onclick="javascript:getTableViewForFenzu('{$MODULE}','viewname={$id}',this,{$id});" >{$viewname}</a></li>
                  {else}
                    <li ><a href="javascript:;" onclick="javascript:getTableViewForFenzu('{$MODULE}','viewname={$id}',this,{$id});">{$viewname}</a></li>
                  {/if}
                 {/foreach}
				 {if $ISADMIN === true}
                <li>
                  <a href="index.php?module={$MODULE}&action=Fenzu&parenttab={$CATEGORY}" style="padding:2px;">
                    <i class="cus-add"></i></a>
                </li> 
                <li>
                   <a href="javascript:editFenzu('{$MODULE}','{$CATEGORY}')" style="padding:2px;"><i class="cus-pencil"></i></a>
                </li>
                <li> 
                  <a href="javascript:deleteFenzu('{$MODULE}','{$CATEGORY}')" style="padding:2px;"><i class="cus-cancel"></i></a>
                </li>
				{/if}
              </ul>
          </div>

           <div id="ListViewContents" class="small" style="width:100%;position:relative;">
            {include file="$MODULE/ListViewEntries.tpl"}
          </div>

        </div>
      </div>

    </div>



<script language="javascript" type="text/javascript">
{literal}
function setSendContent(obj){ 
	$("#sendmessageinfo").val(obj.value);
}
function checkFieldNum(){
	var sendmessageinfo = $("#sendmessageinfo").val();
	var contentlen = fucCheckLength2(sendmessageinfo);
	var zishu = 65 - contentlen;
	var str = "你还能输入:<font color=red><b>"+zishu+"</b></font>个字...";
	$("#showzishu").html(str);
}
{/literal}
</script>

