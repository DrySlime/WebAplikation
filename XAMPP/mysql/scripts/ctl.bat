@echo off
rem START or STOP Services
rem ----------------------------------
rem Check if argument is STOP or START

if not ""%1"" == ""START"" goto stop


"C:\Users\Nils\Desktop\XAMPP\mysql\bin\mysqld" --defaults-file="C:\Users\Nils\Desktop\XAMPP\mysql\bin\my.ini" --standalone
if errorlevel 1 goto error
goto finish

:stop
cmd.exe /C start "" /MIN call "C:\Users\Nils\Desktop\XAMPP\killprocess.bat" "mysqld.exe"

if not exist "C:\Users\Nils\Desktop\XAMPP\mysql\data\%computername%.pid" goto finish
echo Delete %computername%.pid ...
del "C:\Users\Nils\Desktop\XAMPP\mysql\data\%computername%.pid"
goto finish


:error
echo MySQL could not be started

:finish
exit
