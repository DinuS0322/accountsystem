$("#mainloader").show();
//Initialation
$(document).ready(function () {

    $("#mainloader").hide();
});
//Initialation


//UPDATE - START
$("body").on("click", "#btnUpdateAdminProfile", function () {
    var formData = new FormData();

    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection

    var txtFirstName = $("#txtAdminFirstName").val();
    formData.append("txtFirstName", txtFirstName);

    var txtLastName = $("#txtAdminLastName").val();
    formData.append("txtLastName", txtLastName);


    var txtAdminPhone = $("#txtAdminPhone").val();
    formData.append("txtAdminPhone", txtAdminPhone);

    var txtAdminAddress = $("#txtAdminAddress").val();
    formData.append("txtAdminAddress", txtAdminAddress);



    //VALIDATION
    if (txtFirstName == "") {
        $("#txtAdminFirstName").focus();
        Toastify({
            text: "Please enter your first name.",
            duration: 5000,
            newWindow: false,
            close: true,
            gravity: "top",
            position: "center",
            stopOnFocus: false,
            style: {
                background: "#fbeb61",
                color: "#2c2c2c",
            },
        }).showToast();
        return false;
    }

    if (txtLastName == "") {
        $("#txtAdminLastName").focus();
        Toastify({
            text: "Please enter your last name.",
            duration: 5000,
            newWindow: false,
            close: true,
            gravity: "top",
            position: "center",
            stopOnFocus: false,
            style: {
                background: "#fbeb61",
                color: "#2c2c2c",
            },
        }).showToast();
        return false;
    }


    //VALIDATION

    $.ajax({
        url: "ajax/admin-update-controller.php",
        type: "POST",
        cache: false,
        processData: false,
        contentType: false,
        data: formData,
        beforeSend: function () {
            $("#mainloader").show();
        },
        success: function (data) {
            const responceData = JSON.parse(data);
            console.log(responceData);

            if (responceData["code"] == 200) {
                $.alert({
                    title: "Success!",
                    content: "Your profile has been successfully updated.",
                    icon: "fa fa-check-circle",
                    type: "green",
                    theme: "modern",
                    buttons: {
                        Okay: function () {
                            location.reload();
                        },
                    },
                });
            } else {
                $.alert({
                    title: "Alert!",
                    content: responceData["message"],
                    icon: "fa fa-exclamation-triangle",
                    type: "red",
                    theme: "modern",
                    buttons: {
                        okay: {
                            text: "Okay",
                            btnClass: "btn-red",
                        },
                    },
                });
            }

            $("#mainloader").hide();
        },
        error: function (data) {
            console.log(data);
            $("#mainloader").hide();

            ajaxError(data);
        },
    });
});
//UPDATE - END

//CHANGE PASSWORD- START
$("body").on("click", "#btnUpdatePassword", function () {
    var formData = new FormData();
  
    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection
  
    var txtCurrentPassword = $("#txtCurrentPassword").val();
    formData.append("txtCurrentPassword", txtCurrentPassword);
  
    var txtNewPassword = $("#txtNewPassword").val();
    formData.append("txtNewPassword", txtNewPassword);
  
    var txtRetypePassword = $("#txtRetypePassword").val();
    formData.append("txtRetypePassword", txtRetypePassword);
  
    //VALIDATION
    if (txtCurrentPassword.length < 4) {
      $("#txtCurrentPassword").focus();
      Toastify({
        text: "Please enter a valid password.",
        duration: 5000,
        newWindow: false,
        close: true,
        gravity: "top",
        position: "center",
        stopOnFocus: false,
        style: {
          background: "#fbeb61",
          color: "#2c2c2c",
        },
      }).showToast();
      return false;
    }
  
    if (txtNewPassword.length < 4) {
      $("#txtNewPassword").focus();
      Toastify({
        text: "Please enter a valid password. The password length must be a minimum of 4 characters.",
        duration: 5000,
        newWindow: false,
        close: true,
        gravity: "top",
        position: "center",
        stopOnFocus: false,
        style: {
          background: "#fbeb61",
          color: "#2c2c2c",
        },
      }).showToast();
      return false;
    }
  
    if (txtNewPassword != txtRetypePassword) {
      $("#txtRetypePassword").focus();
      Toastify({
        text: "Please make sure that you enter the same password in both fields. Please try again and make sure that both passwords match.",
        duration: 5000,
        newWindow: false,
        close: true,
        gravity: "top",
        position: "center",
        stopOnFocus: false,
        style: {
          background: "#fbeb61",
          color: "#2c2c2c",
        },
      }).showToast();
      return false;
    }
    //VALIDATION
  
    $.ajax({
      url: "ajax/admin-password-update-controller.php",
      type: "POST",
      cache: false,
      processData: false,
      contentType: false,
      data: formData,
      beforeSend: function () {
        $("#mainloader").show();
      },
      success: function (data) {
        const responceData = JSON.parse(data);
        console.log(responceData);
  
        if (responceData["code"] == 200) {
          $.alert({
            title: "Success!",
            content: "Your password has been successfully updated.",
            icon: "fa fa-check-circle",
            type: "green",
            theme: "modern",
            buttons: {
              okay: {
                text: "Okay",
                btnClass: "btn-green",
              },
            },
          });
        } else if (responceData["code"] == 401) {
          $.alert({
            title: "Alert!",
            content:
              "Sorry, the password you entered is incorrect. Please make sure that you have entered your current password correctly and try again. If you continue to have trouble, please reset your password.",
            icon: "fa fa-exclamation-triangle",
            type: "red",
            theme: "modern",
            buttons: {
              okay: {
                text: "Okay",
                btnClass: "btn-red",
              },
            },
          });
        } else {
          $.alert({
            title: "Alert!",
            content: responceData["message"],
            icon: "fa fa-exclamation-triangle",
            type: "red",
            theme: "modern",
            buttons: {
              okay: {
                text: "Okay",
                btnClass: "btn-red",
              },
            },
          });
        }
  
        $("#mainloader").hide();
      },
      error: function (data) {
        console.log(data);
        $("#mainloader").hide();
  
        ajaxError(data);
      },
    });
  });
  //CHANGE PASSWORD - START
