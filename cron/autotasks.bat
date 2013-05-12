@echo off
schtasks /create /tn "CRMONE Send Email" /tr D:\xampp\htdocs\cron\autosendmail.bat /sc MINUTE /mo 3 /RU SYSTEM
