@echo off
setlocal

rem Set the paths and filenames
set "ScriptPath=D:\Codies\laragon\www\Beauty\serve Invisible.vbs"
set "ShortcutName=Beauty"
set "StartupFolder=%APPDATA%\Microsoft\Windows\Start Menu\Programs\Startup"

rem Create a .lnk shortcut to the .vbs file in the startup folder
copy /b "%SystemRoot%\System32\cmd.exe" "%StartupFolder%\%ShortcutName%.lnk" > nul

rem Modify the shortcut's properties to point to the .vbs file
set "ShortcutFile=%StartupFolder%\%ShortcutName%.lnk"
set "TargetPath=%ScriptPath%"

echo Set oWS = WScript.CreateObject("WScript.Shell") > %Temp%\CreateShortcut.vbs
echo sLinkFile = "%ShortcutFile%" >> %Temp%\CreateShortcut.vbs
echo Set oLink = oWS.CreateShortcut(sLinkFile) >> %Temp%\CreateShortcut.vbs
echo oLink.TargetPath = "%TargetPath%" >> %Temp%\CreateShortcut.vbs
echo oLink.Save >> %Temp%\CreateShortcut.vbs

cscript //nologo %Temp%\CreateShortcut.vbs
del %Temp%\CreateShortcut.vbs

endlocal
