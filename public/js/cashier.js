/* global jsPrintSetup */

var promises = [];
var DELAY_BETWEEN_EVERY_COPY = 1000;
var DELAY_BETWEEN_EVERY_PRINTER = 1000;

function printLoop(printer_name, printerType, count, i) {
    setTimeout(
        function() {
            sendToPrinter(printer_name, printerType);
            i++;
            if (i < count) {
                printLoop(printer_name, printerType, count, i);
            }
        },
        i === 0 ? 0 : DELAY_BETWEEN_EVERY_COPY
    );
}

function sendToPrinter(printer_name, printerType) {
    jsPrintSetup.setPrinter(printer_name);
    // set top margins in millimeters
    jsPrintSetup.setOption("marginTop", 0);
    jsPrintSetup.setOption("marginBottom", 0);
    jsPrintSetup.setOption("marginLeft", 0);
    jsPrintSetup.setOption("marginRight", 0);

    //                // set page header
    jsPrintSetup.setOption("headerStrLeft", "");
    jsPrintSetup.setOption("headerStrCenter", "");
    jsPrintSetup.setOption("headerStrRight", "");

    //                // set empty page footer
    jsPrintSetup.setOption("footerStrLeft", "");
    jsPrintSetup.setOption("footerStrCenter", "");
    jsPrintSetup.setOption("footerStrRight", "");
    jsPrintSetup.setSilentPrint(true);
    jsPrintSetup.setShowPrintProgress(false);
    jsPrintSetup.printWindow(window.frames);
}

function printToCashier(printersArr) {
    for (var i = 0; i < printersArr.length; i++) {
        var currentPrinter = printersArr[i];
        if (currentPrinter.bill_type === 1) {
            var cashierPrinterName = currentPrinter.printer_name;
            var noOfCopies = currentPrinter.number_of_copies;
            printLoop(cashierPrinterName, 0, noOfCopies);
        }
    }
}

function codiesDistributing(printersArr) {
    var scannedPrinters = "";
    var uniquePrintersArr = new Array();
    for (var i = 0; i < printersArr.length; i++) {
        var currentPrinter = printersArr[i];
        var printer_name = currentPrinter.printer_name;
        var printerType = currentPrinter.bill_type;
        var printerNameType = printer_name + "," + printerType;

        if (scannedPrinters.indexOf(printerNameType) === -1) {
            scannedPrinters += printerNameType + "%%";
            uniquePrintersArr.push(currentPrinter);
        }
    }
    var i = 0;
    codiesDistributingFunc2(printersArr, uniquePrintersArr, i);
}

function codiesDistributingFunc2(printersArr, uniquePrintersArr, i) {
    setTimeout(function() {
        //  call a 600ms setTimeout when the loop is called
        distributing(printersArr, uniquePrintersArr, i); //  your code here
        i++; //  increment the counter
        if (i < uniquePrintersArr.length) {
            //  if the counter < uniquePrintersArr.length, call the loop function
            codiesDistributingFunc2(printersArr, uniquePrintersArr, i); //  ..  again which will trigger another
        } //  ..  setTimeout()
    }, DELAY_BETWEEN_EVERY_PRINTER);
}

function distributing(printersArr, uniquePrintersArr, i) {
    var currentPrinter = uniquePrintersArr[i];
    var printer_name = currentPrinter.printer_name;
    var printerType = currentPrinter.bill_type;
    var noOfCopies = currentPrinter.number_of_copies;

    // in case of not included printer before
    var printerNameType = printer_name + "," + printerType;
    var printerMainIdStr = getCodiesPrinters(printerNameType, printersArr);
    //            var printerMainIdsStr = printerMainId.split(",")[printerMainId.split(",").length - 1];

    if (printerMainIdStr !== "" && printerMainIdStr !== null) {
        var allowToPrint = checkIfDistributedBefore(printerMainIdStr, printerType);
        if (allowToPrint) {
            printLoop(printer_name, printerType, noOfCopies, 0);
        }
    }
}

function getCodiesPrinters(printerNameType, printersArr) {
    var mainTypeIds = "";
    for (var i = 0; i < printersArr.length; i++) {
        var currentPrinter = printersArr[i];
        var printer_name = currentPrinter.printer_name;
        var printerType = currentPrinter.bill_type + "";
        if (
            printer_name === printerNameType.split(",")[0] &&
            printerType === printerNameType.split(",")[1]
        ) {
            mainTypeIds += currentPrinter.main_type_id + "%%";
        }
    }
    return mainTypeIds;
}

function checkIfDistributedBefore(printerMainIdsStr, printerType) {
    var assignedTable;
    var mainTypeIdIndex;
    // 1 = cashier printer / 2 = kitchen printer

    assignedTable = document.getElementById("kitchenTable");

    // parent.frames["display-frame"].document.getElementById("kitchenTable").firstChild.firstChild;
    mainTypeIdIndex = 0;
    var noOfHiddenRows = 0;
    var tableLength = assignedTable.rows.length;
    for (var i = 1; assignedTable.rows[i]; i++) {
        var row = assignedTable.rows[i];
        var currentMainId = parseInt(row.cells[mainTypeIdIndex].textContent);
        var isExistMainId = false;
        for (var j = 0; j < printerMainIdsStr.split("%%").length; j++) {
            var id = printerMainIdsStr.split("%%")[j];

            if (parseInt(id) === parseInt(currentMainId)) {
                isExistMainId = true;
                break;
            }
        }
        if (isExistMainId) {
            row.style.display = "";
        } else {
            row.style.display = "none";
            noOfHiddenRows++;
        }
    }
    if (noOfHiddenRows >= tableLength - 1) {
        return false;
    } else {
        return true;
    }
}