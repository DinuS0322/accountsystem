$(document).ready(function(){
    $('#viewUsers').DataTable({
        responsive: true
    });
    $('#txtUserType').trigger('change');
})

$('body').on('click', '#btnAddUser', function(){
    var formData = new FormData();

    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection

    var txtFirstName = $("#txtFirstName").val();
    formData.append("txtFirstName", txtFirstName);

    var txtLastName = $("#txtLastName").val();
    formData.append("txtLastName", txtLastName);

    var txtGender = $("#txtGender").val();
    formData.append("txtGender", txtGender);

    var txtNumber = $("#txtNumber").val();
    formData.append("txtNumber", txtNumber);

    var txtUserType = $("#txtUserType").val();
    formData.append("txtUserType", txtUserType);

    var txtEmail = $("#txtEmail").val();
    formData.append("txtEmail", txtEmail);

    var txtPassword = $("#txtPassword").val();
    formData.append("txtPassword", txtPassword);

    var txtConfirmPassword = $("#txtConfirmPassword").val();
    formData.append("txtConfirmPassword", txtConfirmPassword);

    var txtAddress = $("#txtAddress").val();
    formData.append("txtAddress", txtAddress);



    if(txtUserType == 'fieldOfficer'){
        var txtbranchData = $("#txtbranchData").val();
        formData.append("txtBranch", txtbranchData);
    }else{
        formData.append("txtBranch", '');
    }
    console.log(txtbranchData);
    //VALIDATION
    if (txtFirstName == "") {
        $("#txtFirstName").focus();
        $.alert({
            title: "Alert!",
            content: "Please enter a first name",
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
        return false;
    }

    if (txtLastName == "") {
        $("#txtLastName").focus();
        $.alert({
            title: "Alert!",
            content: "Please enter a last name",
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
        return false;
    }

    if (txtEmail == "") {
        $("#txtEmail").focus();
        $.alert({
            title: "Alert!",
            content: "Please enter a email address",
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
        return false;
    }

    if (txtPassword == "") {
        $("#txtPassword").focus();
        $.alert({
            title: "Alert!",
            content: "Please enter a password",
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
        return false;
    }

    if (txtConfirmPassword == "") {
        $("#txtConfirmPassword").focus();
        $.alert({
            title: "Alert!",
            content: "Please enter a confirm password",
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
        return false;
    }

    if (txtConfirmPassword != txtPassword) {
        $("#txtPassword").focus();
        $.alert({
            title: "Alert!",
            content: "Password not match try agin",
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
        return false;
    }
    //VALIDATION

    $.ajax({
        url: "ajax/subpage/create-user-controller.php",
        type: "POST",
        cache: false,
        processData: false,
        contentType: false,
        data: formData,
        beforeSend: function () {
            $("#mainloader").show();
        },
        success: function (data) {
            if (data == 'success') {
                $.alert({
                    title: "Success!",
                    content: "Create User successfully",
                    icon: "fa fa-check-circle",
                    type: "green",
                    theme: "modern",
                    buttons: {
                        Okay: function () {
                            location.reload();
                        },
                    },
                });
            } else if(data == "userFound"){
                $.alert({
                    title: "Alert!",
                    content: "Already registered email address try again",
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
})

//Delete User - START
$("body").on("click", ".btnDeleteUser", function () {
    var formData = new FormData();
  
    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection
  
    var userId = $(this).attr("user-id");
    formData.append("userId", userId);
  

  
    $.confirm({
      title: "Confirm!",
      content: "Are you sure want to delete ?",
      buttons: {
        confirm: function () {
          $.ajax({
            url: "ajax/subpage/delete-user-controller.php",
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
              $.alert({
                title: "Success!",
                content: "Deleted successfully",
                icon: "fa fa-check-circle",
                type: "green",
                theme: "modern",
                buttons: {
                  Okay: function () {
                    location.reload();
                  },
                },
              });
              $("#mainloader").hide();
            },
            error: function (data) {
              console.log(data);
              $("#overlay-Loader").hide();
            },
          });
        },
        cancel: function () {},
      },
    });
  });
//Delete User - END

//Update User - START
$('body').on('click', '#btnUpdateUser', function(){
    var formData = new FormData();

    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection

    var txtFirstName = $("#txtUpdateFirstName").val();
    formData.append("txtFirstName", txtFirstName);

    var txtLastName = $("#txtUpdateLastName").val();
    formData.append("txtLastName", txtLastName);

    var txtGender = $("#txtUpdateGender").val();
    formData.append("txtGender", txtGender);

    var txtNumber = $("#txtUpdateNumber").val();
    formData.append("txtNumber", txtNumber);

    var txtUserId = $(this).attr("user-id");
    formData.append("txtUserId", txtUserId);

    var txtAddress = $("#txtUpdateAddress").val();
    formData.append("txtAddress", txtAddress);

    //VALIDATION
    if (txtFirstName == "") {
        $("#txtUpdateFirstName").focus();
        $.alert({
            title: "Alert!",
            content: "Please enter a first name",
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
        return false;
    }

    if (txtLastName == "") {
        $("#txtUpdateLastName").focus();
        $.alert({
            title: "Alert!",
            content: "Please enter a last name",
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
        return false;
    }
    //VALIDATION

    $.ajax({
        url: "ajax/subpage/update-user-controller.php",
        type: "POST",
        cache: false,
        processData: false,
        contentType: false,
        data: formData,
        beforeSend: function () {
            $("#mainloader").show();
        },
        success: function (data) {
            if (data == 'success') {
                $.alert({
                    title: "Success!",
                    content: "Update User successfully",
                    icon: "fa fa-check-circle",
                    type: "green",
                    theme: "modern",
                    buttons: {
                        Okay: function () {
                            location.reload();
                        },
                    },
                });
            } else{
                $.alert({
                    title: "Alert!",
                    content: "Something went wrong try again",
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
})
//Update User - END


//filter branch - START
$('body').on('change', '#txtUserType', function(){
    var txtUserTypeVal = $('#txtUserType').val();
    if(txtUserTypeVal == 'fieldOfficer'){
        var branchDiv = document.getElementById('branchDiv');
        branchDiv.classList.remove("hidden");
    }else{
        var branchDiv = document.getElementById('branchDiv');
        branchDiv.classList.add("hidden");
    }

});
//filter branch - START

$('body').on('click', '#btnChangePassword', function(){
    var formData = new FormData();

    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection

    var txtPassword = $("#txtPassword").val();
    formData.append("txtPassword", txtPassword);

    var txtConfirmPassword = $("#txtConfirmPassword").val();
    formData.append("txtConfirmPassword", txtConfirmPassword);

    var $userId = $(this).attr("data-id");
    formData.append("userId", $userId);


    if (txtPassword == "") {
        $("#txtPassword").focus();
        $.alert({
            title: "Alert!",
            content: "Please enter a password",
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
        return false;
    }

    if (txtConfirmPassword == "") {
        $("#txtConfirmPassword").focus();
        $.alert({
            title: "Alert!",
            content: "Please enter a confirm password",
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
        return false;
    }

    if (txtConfirmPassword != txtPassword) {
        $("#txtPassword").focus();
        $.alert({
            title: "Alert!",
            content: "Password not match try agin",
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
        return false;
    }
    //VALIDATION

    $.ajax({
        url: "ajax/subpage/change-password-controller.php",
        type: "POST",
        cache: false,
        processData: false,
        contentType: false,
        data: formData,
        beforeSend: function () {
            $("#mainloader").show();
        },
        success: function (data) {
            if (data == 'success') {
                $.alert({
                    title: "Success!",
                    content: "password change successfully",
                    icon: "fa fa-check-circle",
                    type: "green",
                    theme: "modern",
                    buttons: {
                        Okay: function () {
                            location.href="index.php?page=all-subpages&subpage=view-users"
                        },
                    },
                });
            } else {
                $.alert({
                    title: "Alert!",
                    content: "somthing wrong try again!",
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
})