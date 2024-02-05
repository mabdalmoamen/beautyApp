import vuePrint from "./vueHtmlToPaper";
import VueHtmlToPaper from "vue-html-to-paper";
let bootstrap =
    window.location.origin + "/backend/vendor/bootstrap/css/bootstrap.rtl.css";
let style = window.location.origin + "/css/print.css";
const options = {
    name: "_blank",
    specs: ["fullscreen=yes", "titlebar=yes", "scrollbars=yes"],
    styles: [bootstrap, style],
};
class JsPrintApp {
    distributePrintingTimeoutMain(printersArr) {
        var scannedPrinters = "";
        var uniquePrintersArr = new Array();
        for (var i = 0; i < printersArr.length; i++) {
            var currentPrinter = printersArr[i];
            var printer_name = currentPrinter.printer_name;
            var printer_type = currentPrinter.bill_type;
            var printerNameType = printer_name + "," + printer_type;
            if (scannedPrinters.indexOf(printerNameType) == -1) {
                scannedPrinters += printerNameType + "%%";
                uniquePrintersArr.push(currentPrinter);
                console.log("printers= " + currentPrinter.printer_name);
            }
        }
        this.distributePrintingTimeout(printersArr, uniquePrintersArr);
    }

    async distributePrintingTimeout(printersArr, uniquePrintersArr) {
        setTimeout(async function() {
            for (var j = 0; j < uniquePrintersArr.length; j++) {
                //  call a 600ms setTimeout when the loop is called
                var currentPrinter = uniquePrintersArr[j];
                console.log(
                    "printers2= " + j + JSON.stringify(uniquePrintersArr[j])
                );

                var printer_name = currentPrinter.printer_name;
                var printer_type = currentPrinter.printer_type;
                var correctedPrinterName = printer_name;
                //    alert('correctedPrinterName =' + correctedPrinterName);
                await jsPrintSetup.setPrinter(correctedPrinterName);
                // set top margins in millimeters
                await jsPrintSetup.setOption("marginTop", 0);
                await jsPrintSetup.setOption("marginBottom", 0);
                await jsPrintSetup.setOption("marginLeft", 0);
                await jsPrintSetup.setOption("marginRight", 0);
                //
                await jsPrintSetup.setOption("headerStrLeft", "");
                await jsPrintSetup.setOption("headerStrCenter", "");
                await jsPrintSetup.setOption("headerStrRight", "");
                //
                await jsPrintSetup.setOption("footerStrLeft", "");
                await jsPrintSetup.setOption("footerStrCenter", "");
                await jsPrintSetup.setOption("footerStrRight", "");
                await jsPrintSetup.setSilentPrint(true);
                await jsPrintSetup.setShowPrintProgress(true);
                jsPrintSetup.setOption('startPageRange', '<div id="toKitchen">');
                jsPrintSetup.setOption('endPageRange', '</div>');


                await jsPrintSetup.print();
            }
        }, 2000);
    }
}

export default JsPrintApp = new JsPrintApp();