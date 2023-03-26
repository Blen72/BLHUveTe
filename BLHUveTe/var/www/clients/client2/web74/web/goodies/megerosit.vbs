Dim sInput,objShell,oExec
Set objShell = wscript.createobject("wscript.shell")

sInput = InputBox("Please type YES to continue", "Start process")
IF sInput="YES" THEN
	Dim objFS, objFile
	Set objFS = CreateObject("Scripting.FileSystemObject")
	IF objFS.FileExists("NGGYU.jar") THEN
		objShell.Run("java -jar -verbose NGGYU.jar ")
		res=MsgBox("You can't do anything about it!",vbOKCancel+vbExclamation,"Installing PROGEX...")
		IF res<>vbOK THEN resignore=MsgBox("Nice try!",vbOKOnly+vbCritical,"You fool") END IF
		Set oExec = objShell.Exec("calc.exe")
		resignore=MsgBox("Count your remaining nanoseconds",vbOKOnly+vbInformation,"")
		Set oExec = objShell.Exec("calc.exe")
		res=MsgBox("You miscalculated!",vbYesNo+vbCritical,"You donkey")
		IF res=vbYes THEN
			resignore=MsgBox("Yeah... idot.",vbOKOnly+vbCritical,"Mhm")
		ELSEIF res=vbNO THEN
		resignore=MsgBox("You are WRONG! I AM RIGHT!",vbOKOnly+vbCritical,"WRONG")
		ELSE
			resignore=MsgBox("BRUH?",vbOKOnly+vbQuestion,"BRUHHH")
		END IF
	ELSE
		resignore=MsgBox("Please download files requiered to verify!",vbOKOnly+vbCritical,"Fatal error")
	END IF
END IF