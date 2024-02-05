hotkeys(
    "ctrl+s,ctrl+a,ctrl+r,f,insert,ctrl+i,ctrl+shift+s,ctrl+h,ctrl+f1,c",
    function(event, handler) {
        event.preventDefault();
        switch (handler.key) {
            case "ctrl+s":
                $("#save").click();
                break;
            case "ctrl+a":
                $("#full")[0].click();
                break;
            case "ctrl+r":
                $("#reset")[0].click();
                break;
            case "insert":
                $("#barcode").focus();
                break;
            case "ctrl+i":
                $("#types")[0].click();
                break;
            case "ctrl+shift+s":
                $("#pend").click();
                break;
            case "ctrl+h":
                $("#showPend").click();
                break;
            case "ctrl+f1":
                $("#searchtype").click();
                break;
            case "c":
                $("#payMethod").val(1);
                $("#payMethod").trigger("change"); // call "change" event
                break;
            default:
                break;
        }
    }
);