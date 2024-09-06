$(document).ready(function() {
    $("#viewSavingsWithdrawal").DataTable({
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excel', text: 'Excel', className: 'btn-custom', buttonWidth: '100px',
               exportOptions: {
              columns:[0,1,2,3,4,5,6]
          }, },
            { extend: 'pdf', text: 'PDF', className: 'btn-custom', buttonWidth: '100px'  ,
            exportOptions: {
              columns:[0,1,2,3,4,5,6]
          },
          customize: function (doc) {
            doc.defaultStyle.fontSize = 10; 
            doc.styles.tableHeader.fontSize = 10; 
            doc.styles.tableHeader.alignment = 'left'; 
            doc.pageSize = 'A4'; 
            doc.content[1].table.widths = '*';
        } 
        }
        ]
    });

    $('.selectize').selectize();
});


$('body').on('change','#searchMember', function(){
    var formData = new FormData();

    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection

    var searchMember = $("#searchMember").val();
    formData.append("searchMember", searchMember);

    $.ajax({
        url: "ajax/subpage/get-saving-account-controller.php",
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
            $('#viewSavingsData').html(responceData['dataOption']);
            $('#savingAccount').selectize();
            $("#mainloader").hide();

        },
        error: function (data) {
            console.log(data);
            $("#mainloader").hide();
            ajaxError(data);
        },
    });
});

$('body').on('click','#btnCreateWithdrawal', function(){
    var formData = new FormData();

    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection

    var searchMember = $("#searchMember").val();
    formData.append("searchMember", searchMember);

    var savingAccount = $("#savingAccount").val();
    formData.append("savingAccount", savingAccount);

    var txtAmount = $("#txtAmount").val();
    formData.append("txtAmount", txtAmount);

    var txtReason = $("#txtReason").val();
    formData.append("txtReason", txtReason);

    if (searchMember == "") {
        $("#searchMember").focus();
        $.alert({
          title: "Alert!",
          content: "Please select a member",
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

      if (savingAccount == "") {
        $("#savingAccount").focus();
        $.alert({
          title: "Alert!",
          content: "Please select a account",
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

      if (txtAmount == "") {
        $("#txtAmount").focus();
        $.alert({
          title: "Alert!",
          content: "Please enter your amount",
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

      $.ajax({
        url: "ajax/subpage/create-withdrawal-controller.php",
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
          if (data == "success") {
            $.alert({
              title: "Success!",
              content: " Withdrawal successfully waiting for response.",
              icon: "fa fa-check-circle",
              type: "green",
              theme: "modern",
              buttons: {
                Okay: function () {
                  location.reload();
                },
              },
            });
          } else if(data == 'error amount'){
            $.alert({
              title: "Alert!",
              content: 'Please enter the amount selected account less than amount and try again!',
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
          } else if(data == 'error years'){
            $.alert({
              title: "Alert!",
              content: 'Your savings account is lock this is not a normal account. Please try again!',
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
          }else {
            $.alert({
              title: "Alert!",
              content: data,
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


$("body").on("click", ".btnRequestWithdrawal", function () {
    var formData = new FormData();
  
    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection
  
    var id = $(this).attr("data-id");
    formData.append("id", id);
  
    $.confirm({
      title: "Confirm!",
      content: "Are you sure want to Request ?",
      buttons: {
        confirm: function () {
          $.ajax({
            url: "ajax/subpage/request-withdrawal-controller.php",
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
              $("#mainloader").hide();
              $.alert({
                title: "Success!",
                content: "Requsted <strong>Successfull!</strong>.",
                icon: "fa fa-check-circle",
                type: "green",
                buttons: {
                  okay: function () {
                    location.reload();
                  },
                },
              });
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

  $(document).on("click", ".btnChangeApprovalModal", function () {
    $withdrawalIdView = $(this).attr("id");
  
    $("#changeApprovalStatus").modal("show");
    $("#withdrawalIdView").val($withdrawalIdView);
  });

  $("body").on("click", "#btnChangeApprovalStatus", function () {
    var formData = new FormData();
  
    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection
  
    withdrawalIdView = $("#withdrawalIdView").val();
    formData.append("withdrawalIdView", withdrawalIdView);
  
    txtApprovalStatus = $("#txtApprovalStatus").val();
    formData.append("txtApprovalStatus", txtApprovalStatus);
  
    txtApprovedReason = $("#txtApprovedReason").val();
    formData.append("txtApprovedReason", txtApprovedReason);
  
    console.log(txtApprovalStatus);
  
    $.ajax({
      url: "ajax/subpage/change-withdraw-approval-status-controller.php",
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
        $("#mainloader").hide();
        if (data == 'success') {
            $.alert({
                title: "Success!",
                content: " Added <strong>Successfully!</strong>.",
                icon: "fa fa-check-circle",
                type: "green",
                buttons: {
                  okay: function () {
                    location.reload();
                  },
                },
              });
        }  else {
            $.alert({
                title: "Alert!",
                content: "Somthing wrong try again",
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
      },
      error: function (data) {
        console.log(data);
        $("#loader").hide();
      },
    });
  });


  $(document).on("click", ".btnChangeApprovalModalThird", function () {
    $withdrawalId = $(this).attr("data-id");
  
    $("#changeApprovalStatusThird").modal("show");
    $("#withdrawalIdViewThird").val($withdrawalId);
  });


  $("body").on("click", "#btnChangeApprovalStatusThird", function () {
    var formData = new FormData();
  
    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection
  
    withdrawalIdView = $("#withdrawalIdViewThird").val();
    formData.append("withdrawalIdView", withdrawalIdView);
  
    txtApprovalStatus = $("#txtApprovalStatusGet").val();
    formData.append("txtApprovalStatus", txtApprovalStatus);
  
    txtCheqeNo = $("#txtCheqeNo").val();
    formData.append("txtCheqeNo", txtCheqeNo);
  
    txtSelectAccount = $("#txtSelectAccount").val();
    formData.append("txtSelectAccount", txtSelectAccount);
  
    txtApprovedDes = $("#txtApprovedDes").val();
    formData.append("txtApprovedReason", txtApprovedDes);
  
  
    console.log(txtApprovalStatus);
  
    $.ajax({
      url: "ajax/subpage/change-withdraw-approval-status-controller.php",
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
        $("#mainloader").hide();
        if (data == 'Insufficient Balance try again') {
          $.alert({
            title: "Alert!",
            content: "Insufficient Balance try again",
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
        } else if(data == 'success'){
          $.alert({
            title: "Success!",
            content: " Added <strong>Successfully!</strong>.",
            icon: "fa fa-check-circle",
            type: "green",
            buttons: {
              okay: function () {
                location.reload();
              },
            },
          });
        }else{
            $.alert({
                title: "Alert!",
                content: "Somthing wrong try again",
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
      },
      error: function (data) {
        console.log(data);
        $("#loader").hide();
      },
    });
  });