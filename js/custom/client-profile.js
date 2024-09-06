$("#mainloader").show();
//Initialation
$(document).ready(function () {

    $("#mainloader").hide();
});
//Initialation

//Click Img to trigger input file
$("body").on("click", "#btnUploadDocProPicture", function () {
    $("#fileDocPictureUpload").trigger("click");
});
//Click Img to trigger input file

//Change img to Crop and Upload
var cropper;
var image = document.getElementById("imgCropable");
var $modal = $("#cropImageModal");

$("#fileDocPictureUpload").change(function (event) {
    var files = event.target.files;

    var reader = new FileReader();
    reader.onload = function (event) {
        image.src = reader.result;
        $modal.modal("show");
    };
    reader.readAsDataURL(files[0]);
});

$modal
    .on("shown.bs.modal", function () {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 3,
        });
    })
    .on("hidden.bs.modal", function () {
        cropper.destroy();
        cropper = null;
    });

$("#btnImageCrop").click(function () {
    canvas = cropper.getCroppedCanvas({
        width: 400,
        height: 400,
    });

    canvas.toBlob(function (blob) {
        var reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onloadend = function () {
            var base64data = reader.result;
            $.ajax({
                url: "ajax/user-picture-uploder.php",
                method: "POST",
                data: { image: base64data },
                beforeSend: function () {
                    $("#mainloader").show();
                },
                success: function (data) {
                    $modal.modal("hide");
                    $("#mainloader").hide();
                    console.log(data);

                    $.alert({
                        title: "Success!",
                        content: "Profile picture changed successfully!",
                        icon: "fa fa-check-circle",
                        type: "green",
                        theme: "modern",
                        buttons: {
                            Okay: function () {
                                location.reload();
                            },
                        },
                    });
                },
            });
        };
    });
});
//Change img to Crop and Upload



//UPDATE - START
$("body").on("click", "#btnUpdateClientProfile", function () {
    var formData = new FormData();

    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection

    var txtClientFirstName = $("#txtClientFirstName").val();
    formData.append("txtClientFirstName", txtClientFirstName);

    var txtClientLastName = $("#txtClientLastName").val();
    formData.append("txtClientLastName", txtClientLastName);

    //VALIDATION
    if (txtClientFirstName == "") {
        $("#txtClientFirstName").focus();
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

    if (txtClientLastName == "") {
        $("#txtClientLastName").focus();
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
        url: "ajax/client-update-controller.php",
        type: "POST",
        cache: false,
        processData: false,
        contentType: false,
        data: formData,
        beforeSend: function () {
            $("#mainloader").show();
        },
        success: function (data) {
            console.log(data);

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
//REGISTER - END

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
      url: "ajax/password-update-controller.php",
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