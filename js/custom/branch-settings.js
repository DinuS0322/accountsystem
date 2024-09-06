$(document).ready(function(){
    $('#viewBranches').DataTable({
        responsive: true,
        dom: 'Bfrtip', // Add buttons to the DOM
        buttons: [
            {
                extend: 'excel',
                exportOptions: {
                    columns: [0, 1, 2,3] // Export only the first three columns
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [0, 1, 2,3] // Export only the first three columns
                }
            },
            
        ]
    });
});

//Create branch - START

$('body').on('click', '#btnCreateBranch', function(){
    var formData = new FormData();

    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection

    var txtBranchName = $("#txtBranchName").val();
    formData.append("txtBranchName", txtBranchName);

    var txtOpenDate = $("#txtOpenDate").val();
    formData.append("txtOpenDate", txtOpenDate);

    var txtNotes = $("#txtNotes").val();
    formData.append("txtNotes", txtNotes);

    var txtActive = $("#txtActive").val();
    formData.append("txtActive", txtActive);

    var txtBinNumber = $("#txtBinNumber").val();
    formData.append("txtBinNumber", txtBinNumber);

    //VALIDATION 
    if (txtBranchName == "") {
        $("#txtBranchName").focus();
        $.alert({
            title: "Alert!",
            content: "Please enter a branch name",
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

    if (txtOpenDate == "") {
        $("#txtOpenDate").focus();
        $.alert({
            title: "Alert!",
            content: "Please enter a open date",
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

    if (txtBinNumber == "") {
        $("#txtBinNumber").focus();
        $.alert({
            title: "Alert!",
            content: "Please enter a branch number",
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
        url: "ajax/subpage/branch-controller.php",
        type: "POST",
        cache: false,
        processData: false,
        contentType: false,
        data: formData,
        beforeSend: function () {
            $("#mainloader").show();
        },
        success: function (data) {
            if (data == 'success'){
                $.alert({
                    title: "Success!",
                    content: "Create branch successfully",
                    icon: "fa fa-check-circle",
                    type: "green",
                    theme: "modern",
                    buttons: {
                        Okay: function () {
                            location.reload();
                        },
                    },
                });
            }else{
                $.alert({
                    title: "Alert!",
                    content: 'somthing wrong try again',
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

//Create branch - START



//Update branch - START

$('body').on('click', '#btnUpdateBranch', function(){
    var formData = new FormData();

    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection

    var txtBranchName = $("#txtUpdateBranchName").val();
    formData.append("txtBranchName", txtBranchName);

    var txtNotes = $("#txtUpdateNotes").val();
    formData.append("txtNotes", txtNotes);

    var txtActive = $("#txtUpdateActive").val();
    formData.append("txtActive", txtActive);

    var txtBinNumber = $("#txtUpdateBinNumber").val();
    formData.append("txtBinNumber", txtBinNumber);

    var branchId = $(this).attr("branch-id");
    formData.append("branchId", branchId);

    //VALIDATION 
    if (txtBranchName == "") {
        $("#txtUpdateBranchName").focus();
        $.alert({
            title: "Alert!",
            content: "Please enter a branch name",
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

    if (txtBinNumber == "") {
        $("#txtUpdateBinNumber").focus();
        $.alert({
            title: "Alert!",
            content: "Please enter a branch number",
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
        url: "ajax/subpage/update-branch-controller.php",
        type: "POST",
        cache: false,
        processData: false,
        contentType: false,
        data: formData,
        beforeSend: function () {
            $("#mainloader").show();
        },
        success: function (data) {
            if (data == 'success'){
                $.alert({
                    title: "Success!",
                    content: "Update branch successfully",
                    icon: "fa fa-check-circle",
                    type: "green",
                    theme: "modern",
                    buttons: {
                        Okay: function () {
                            location.reload();
                        },
                    },
                });
            }else{
                $.alert({
                    title: "Alert!",
                    content: 'somthing wrong try again',
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

//Update branch - START


//Delete Branch - START
$("body").on("click", ".btnDeleteBranch", function () {
    var formData = new FormData();
  
    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection
  
    var branchId = $(this).attr("branch-id");
    formData.append("branchId", branchId);
  

  
    $.confirm({
      title: "Confirm!",
      content: "Are you sure want to delete ?",
      buttons: {
        confirm: function () {
          $.ajax({
            url: "ajax/subpage/delete-branch-controller.php",
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
//Delete Branch - END