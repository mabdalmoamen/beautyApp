class Notification {
    success() {
        new Noty({
            type: "success",
            layout: "topRight",
            text: "تم بنجاح !",
            timeout: 1000,
        }).show();
    }
    successMsg(success) {
        new Noty({
            type: "success",
            layout: "topRight",
            text: success,
            timeout: 1000,
        }).show();
    }
    navigationAlert() {
        new Noty({
            type: "warning",
            layout: "topRight",
            text: "ليس لديك الصلاحية للدخول لهذه الصفحة",
            timeout: 1500,
        }).show();
    }
    alert() {
        new Noty({
            type: "alert",
            layout: "topRight",
            text: "هل أنت متأكد؟!",
            timeout: 1000,
        }).show();
    }

    customMsg(type, dir, msg, time) {
        new Noty({
            type: type ? type : "alert",
            layout: dir,
            text: msg,
            timeout: time ? time : 1000,
        }).show();
    }

    error() {
        new Noty({
            type: "alert",
            layout: "topRight",
            text: "حدث خطأ ما يرجى أعادة المحاولة أو التاكد من العملية غير مرتبطة بأخرى",
            timeout: 1000,
        }).show();
    }
    errorMsg(error) {
        new Noty({
            type: "error",
            layout: "topRight",
            text: error,
            timeout: 1000,
        }).show();
    }
    warning() {
        new Noty({
            type: "warning",
            layout: "topRight",
            text: "خطأ!",
            timeout: 1000,
        }).show();
    }

    image_validation() {
        new Noty({
            type: "error",
            layout: "topRight",
            text: "Upload Image less then 1MB ",
            timeout: 1000,
        }).show();
    }

    cart_success() {
        new Noty({
            type: "success",
            layout: "topRight",
            text: "تم الاضافة بنجاح",
            timeout: 1000,
        }).show();
    }

    cart_delete() {
        new Noty({
            type: "success",
            layout: "topRight",
            text: "تم الحذف بنجاح",
            timeout: 1000,
        }).show();
    }
    item_delete() {
        new Noty({
            type: "success",
            layout: "topRight",
            text: "تم الحذف بنجاح",
            timeout: 1000,
        }).show();
    }
    item_delete_error() {
        new Noty({
            type: "error",
            layout: "topRight",
            text: "لايمكن الحذف",
            timeout: 1000,
        }).show();
    }
    chash_error() {
        new Noty({
            type: "error",
            layout: "topRight",
            text: "النقدية لا تسمح",
            timeout: 1000,
        }).show();
    }
}

export default Notification = new Notification();