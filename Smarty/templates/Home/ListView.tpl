 <div class="container-fluid" style="height:602px;overflow:auto;">
           <!--Dashboad-->
        <div id="columns" class="row-fluid">
            <ul id="widget1" class="column ui-sortable unstyled">
                <li id="Widget1" class="widget">
                    <div class="widget-head">
                        <span><b>7天内待联系客户(下次联系日期)</b></span></div>
                    <div class="widget-content" style="overflow: auto;height:200px;">
                            <ul style="line-height:10px;margin-top:-5px;list-style:none;">
                                {foreach item=nextcontactacc from=$NEXTCONTACTACCOUNT}
                                    &nbsp;&nbsp;<li>{$nextcontactacc}</li>
                                {foreachelse}
                                 &nbsp;&nbsp;<li>暂无</li>
                                {/foreach}
                            </ul>
                    </div>
                </li>
                <li id="Widget5" class="widget">
                    <div class="widget-head">
                        <span><b>一月内到期纪念日1(<font color=red>客户名称/公历纪念日</font>)</b></span></div>
                    <div class="widget-content" style="overflow: auto;height:200px;">
                       <ul style="line-height:10px;margin-top:-5px;list-style:none;">
                            {foreach item=onemonthmemday from=$ONEMONTHMEMDAY}
                                &nbsp;&nbsp;<li >{$onemonthmemday}</li>
                            {foreachelse}
                             &nbsp;&nbsp;<li>暂无</li>
                            {/foreach}
                        </ul>
                    </div>
                </li>
            </ul>
            <ul id="widget2" class="column ui-sortable unstyled">
                
                <li id="Widget5" class="widget">
                    <div class="widget-head">
                        <span><b>一月内到期纪念日2(<font color=red>客户名称/公历纪念日</font>)</b></span></div>
                    <div class="widget-content" style="overflow: auto;height:200px;">
                       <ul style="line-height:10px;margin-top:-5px;list-style:none;">
                            {foreach item=onemonthmemday from=$ONEMONTHMEMDAY}
                                &nbsp;&nbsp;<li >{$onemonthmemday}</li>
                            {foreachelse}
                             &nbsp;&nbsp;<li>暂无</li>
                            {/foreach}
                        </ul>
                    </div>
                </li>
		<li id="Widget5" class="widget">
                    <div class="widget-head">
                        <span><b>一月内到期纪念日3(<font color=red>客户名称/公历纪念日</font>)</b></span></div>
                    <div class="widget-content" style="overflow: auto;height:200px;">
                       <ul style="line-height:10px;margin-top:-5px;list-style:none;">
                            {foreach item=onemonthmemday from=$ONEMONTHMEMDAY}
                                &nbsp;&nbsp;<li >{$onemonthmemday}</li>
                            {foreachelse}
                             &nbsp;&nbsp;<li>暂无</li>
                            {/foreach}
                        </ul>
                    </div>
                </li>
                
            </ul>
            
            
        </div>
  
    </div>
