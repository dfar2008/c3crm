<div class="accordion-group">
              <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse"  href="#collapseOne">
                  <i class="cus-table"></i>&nbsp;<b>相关操作</b>
                </a>
              </div>
              <div id="collapseOne" class="accordion-body collapse in">
                <div class="accordion-inner">
                   <ul class="nav nav-list">
                      <li {if $type eq ''}class="active"{/if}>
                        <a href="index.php?module=Accounts&action=DetailView&record={$ID}&parenttab=Customer" >客户详细页</a>
                      </li>
                      <li {if $type eq 'Notes'}class="active"{/if}>
                        <a href="index.php?module=Accounts&action=RelateLists&record={$ID}&moduletype=Notes&parenttab=Customer" >联系记录</a>
                      </li>
                      <li {if $type eq 'Contacts'}class="active"{/if}>
                        <a href="index.php?module=Accounts&action=RelateLists&record={$ID}&moduletype=Contacts&parenttab=Customer" >其他联系人</a>
                      </li>
                      <li {if $type eq 'Maillists'}class="active"{/if}>
                        <a href="index.php?module=Accounts&action=RelateLists&record={$ID}&moduletype=Maillists&parenttab=Customer" >群发邮件记录</a>
                      </li>
                      <li {if $type eq 'Qunfas'}class="active"{/if}>
                        <a href="index.php?module=Accounts&action=RelateLists&record={$ID}&moduletype=Qunfas&parenttab=Customer" >群发短信记录</a>
                      </li>
                      <li {if $type eq 'Memdays'}class="active"{/if}>
                        <a href="index.php?module=Accounts&action=RelateLists&record={$ID}&moduletype=Memdays&parenttab=Customer" >纪念日</a>
                      </li>
                    
                      <li {if $type eq 'Products'}class="active"{/if}>
                        <a href="index.php?module=Accounts&action=RelateLists&record={$ID}&moduletype=Products&parenttab=Customer" >已购买产品</a>
                      </li>   
					    <li {if $type eq 'Sales Order'}class="active"{/if}>
                        <a href="index.php?module=Accounts&action=RelateLists&record={$ID}&moduletype=Sales Order&parenttab=Customer" >订单明细</a>
                      </li>
                    </ul>
                </div>
              </div>
            </div>
