配置易客CRM群发邮件
linux下配置步骤：
1）修改autosendmail.sh，http://localhost/换成正确的访问地址；
2）配置cronjob执行autosendmail.sh脚本。
windows下配置步骤：
1）修改autosendmail.bat，http://localhost/换成正确的访问地址；
2）执行autotasks.bat，然后执行：开始->附件->系统工具->任务计划，根据需求修改里面的CRMONE Send Email任务计划。
配置完毕，系统在后台将自动执行添加的群发邮件任务。