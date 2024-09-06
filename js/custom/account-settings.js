$(document).ready(function () {
  $('#txtFieldOfficerId').selectize();
  $("#viewAllTransectionHistory").DataTable({
    responsive: true,
    dom: "Bfrtip",
    buttons: [
      {
        extend: "excel",
        text: "Excel",
        className: "btn-custom",
        buttonWidth: "100px",
        exportOptions: {
          columns: [0, 1, 2, 3, 4],
        },
      },
      {
        extend: "pdf",
        text: "PDF",
        className: "btn-custom",
        buttonWidth: "100px",
        exportOptions: {
          columns: [0, 1, 2, 3, 4],
        },
        customize: function (doc) {
          doc.defaultStyle.fontSize = 10;
          doc.styles.tableHeader.fontSize = 10;
          doc.styles.tableHeader.alignment = "left";
          doc.pageSize = "A4";
          doc.content[1].table.widths = "*";
        },
      },
    ],
  });
  $("#viewAllTransection").DataTable({
    responsive: true,
    dom: "Bfrtip",
    buttons: [
      {
        extend: "excel",
        text: "Excel",
        className: "btn-custom",
        buttonWidth: "100px",
        exportOptions: {
          columns: [0, 1, 2, 3, 4],
        },
      },
      {
        extend: "pdf",
        text: "PDF",
        className: "btn-custom",
        buttonWidth: "100px",
        exportOptions: {
          columns: [0, 1, 2, 3, 4],
        },
        customize: function (doc) {
          doc.defaultStyle.fontSize = 10;
          doc.styles.tableHeader.fontSize = 10;
          doc.styles.tableHeader.alignment = "left";
          doc.pageSize = "A4";
          doc.content[1].table.widths = "*";
        },
      },
    ],
  });
  $("#viewAccountTable").DataTable({
    responsive: true,
    dom: "Bfrtip",
    buttons: [
      {
        extend: "excel",
        text: "Excel",
        className: "btn-custom",
        buttonWidth: "100px",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5],
        },
      },
      {
        extend: "pdf",
        text: "PDF",
        className: "btn-custom",
        buttonWidth: "100px",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5],
        },
        customize: function (doc) {
          doc.defaultStyle.fontSize = 10;
          doc.styles.tableHeader.fontSize = 10;
          doc.styles.tableHeader.alignment = "left";
          doc.pageSize = "A4";
          doc.content[1].table.widths = "*";
        },
      },
    ],
  });

  $("#viewBalanceTransfer").DataTable({
    responsive: true,
    dom: "Bfrtip",
    buttons: [
      {
        extend: "excel",
        text: "Excel",
        className: "btn-custom",
        buttonWidth: "100px",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5],
        },
      },
      {
        extend: "pdf",
        text: "PDF",
        className: "btn-custom",
        buttonWidth: "100px",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5],
        },
        customize: function (doc) {
          doc.defaultStyle.fontSize = 10;
          doc.styles.tableHeader.fontSize = 10;
          doc.styles.tableHeader.alignment = "left";
          doc.pageSize = "A4";
          doc.content[1].table.widths = "*";
        },
      },
    ],
  });

  $("#viewTransferHistory").DataTable({
    responsive: true,
    dom: "Bfrtip",
    buttons: [
      {
        extend: "excel",
        text: "Excel",
        className: "btn-custom",
        buttonWidth: "100px",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6],
        },
      },
      {
        extend: "pdf",
        text: "PDF",
        className: "btn-custom",
        buttonWidth: "100px",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6],
        },
        customize: function (doc) {
          doc.defaultStyle.fontSize = 10;
          doc.styles.tableHeader.fontSize = 10;
          doc.styles.tableHeader.alignment = "left";
          doc.pageSize = "A4";
          doc.content[1].table.widths = "*";
        },
      },
    ],
  });

  $("#txtSelectAccount").selectize();
  $("#txtFromAccount").selectize();
  $("#txtToAccount").selectize();
  $("#txtDefaultAccount").selectize();

  $("#txtSelectCollectionAccount").selectize();
});


$("body").on("change", "#txtFieldOfficerId", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  var txtFieldOfficerId = $("#txtFieldOfficerId").val();
  formData.append("txtFieldOfficerId", txtFieldOfficerId);

  $.ajax({
    url: "ajax/subpage/get-officer-collection-controller.php",
    type: "POST",
    cache: false,
    processData: false,
    contentType: false,
    data: formData,
    beforeSend: function () {
      $("#mainloader").show();
    },
    success: function (data) {
      $('#txtCollectionDepositAmount').val(data);
      $("#mainloader").hide();
    },
    error: function (data) {
      console.log(data);
      $("#mainloader").hide();
      ajaxError(data);
    },
  });
});


$("body").on("click", "#btnCreateAccount", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  var txtAccountName = $("#txtAccountName").val();
  formData.append("txtAccountName", txtAccountName);

  var txtBranchName = $("#txtBranchName").val();
  formData.append("txtBranchName", txtBranchName);

  var txtAccountNumber = $("#txtAccountNumber").val();
  formData.append("txtAccountNumber", txtAccountNumber);

  var txtRegisterDate = $("#txtRegisterDate").val();
  formData.append("txtRegisterDate", txtRegisterDate);

  var txtStatus = $("#txtStatus").val();
  formData.append("txtStatus", txtStatus);

  var txtNote = $("#txtNote").val();
  formData.append("txtNote", txtNote);

  if (txtAccountName == "") {
    $("#txtAccountName").focus();
    $.alert({
      title: "Alert!",
      content: "Please enter the account name",
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

  if (txtBranchName == "") {
    $("#txtBranchName").focus();
    $.alert({
      title: "Alert!",
      content: "Please enter the branch name",
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

  if (txtAccountNumber == "") {
    $("#txtAccountNumber").focus();
    $.alert({
      title: "Alert!",
      content: "Please enter the account number",
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

  if (txtNote == "") {
    $("#txtNote").focus();
    $.alert({
      title: "Alert!",
      content: "Please enter the note",
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
    url: "ajax/subpage/create-account-controller.php",
    type: "POST",
    cache: false,
    processData: false,
    contentType: false,
    data: formData,
    beforeSend: function () {
      $("#mainloader").show();
    },
    success: function (data) {
      if (data == "success") {
        $.alert({
          title: "Success!",
          content: "Create account successfully",
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

//Deposit Function - START
$("body").on("click", "#btnDepositAmount", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  var txtSelectAccount = $("#txtSelectAccount").val();
  formData.append("txtSelectAccount", txtSelectAccount);

  var txtDepositAmount = $("#txtDepositAmount").val();
  formData.append("txtDepositAmount", txtDepositAmount);

  //Validations
  if (txtSelectAccount == "") {
    $("#txtSelectAccount").focus();
    $.alert({
      title: "Alert!",
      content: "Please select the account",
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

  if (txtDepositAmount == "") {
    $("#txtDepositAmount").focus();
    $.alert({
      title: "Alert!",
      content: "Please enter a deposit amount",
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
  //validations

  $.ajax({
    url: "ajax/subpage/deposit-account-controller.php",
    type: "POST",
    cache: false,
    processData: false,
    contentType: false,
    data: formData,
    beforeSend: function () {
      $("#mainloader").show();
    },
    success: function (data) {
      if (data == "success") {
        $.alert({
          title: "Success!",
          content: "Create account successfully",
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
//Deposit Function - END

//Balance Transfer Function - START
$("body").on("change", "#txtFromAccount", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  var txtFromAccount = $("#txtFromAccount").val();
  formData.append("txtFromAccount", txtFromAccount);

  $.ajax({
    url: "ajax/subpage/get-account-balance.php",
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
      if (responceData["code"] == 200) {
        $("#txtAvailableBalance").val(responceData["balance"]);
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

$("body").on("click", "#btnAccountTransfer", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  var txtTransferReason = $("#txtTransferReason").val();
  formData.append("txtTransferReason", txtTransferReason);

  var txtFromAccount = $("#txtFromAccount").val();
  formData.append("txtFromAccount", txtFromAccount);

  var txtToAccount = $("#txtToAccount").val();
  formData.append("txtToAccount", txtToAccount);

  var txtAvailableBalance = $("#txtAvailableBalance").val();
  formData.append("txtAvailableBalance", txtAvailableBalance);

  var txtTransferAmount = $("#txtTransferAmount").val();
  formData.append("txtTransferAmount", txtTransferAmount);

  var txtTransferDate = $("#txtTransferDate").val();
  formData.append("txtTransferDate", txtTransferDate);

  var txtTransferNote = $("#txtTransferNote").val();
  formData.append("txtTransferNote", txtTransferNote);

  //validation
  if (txtTransferReason == "") {
    $("#txtTransferReason").focus();
    $.alert({
      title: "Alert!",
      content: "Please enter transfer reason",
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

  if (txtFromAccount == "") {
    $("#txtFromAccount").focus();
    $.alert({
      title: "Alert!",
      content: "Please select a from account",
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

  if (txtToAccount == "") {
    $("#txtToAccount").focus();
    $.alert({
      title: "Alert!",
      content: "Please select a to account",
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

  if (txtToAccount == txtFromAccount) {
    $("#txtFromAccount").focus();
    $.alert({
      title: "Alert!",
      content: "you are selected same account try again.",
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

  if (txtTransferAmount == "") {
    $("#txtTransferAmount").focus();
    $.alert({
      title: "Alert!",
      content: "Please enter a amount",
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

  if (txtTransferDate == "") {
    $("#txtTransferDate").focus();
    $.alert({
      title: "Alert!",
      content: "Please select a date",
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

  if (txtTransferNote == "") {
    $("#txtTransferNote").focus();
    $.alert({
      title: "Alert!",
      content: "Please enter your note",
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
  //validation

  $.ajax({
    url: "ajax/subpage/balance-transfer-controller.php",
    type: "POST",
    cache: false,
    processData: false,
    contentType: false,
    data: formData,
    beforeSend: function () {
      $("#mainloader").show();
    },
    success: function (data) {
      $.alert({
        title: "Success!",
        content: "Transfer successfully",
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
      $("#mainloader").hide();
      ajaxError(data);
    },
  });
});

$("body").on("click", ".btnFirstApproval", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  var txtTransferId = $(this).attr("data-id");
  formData.append("txtTransferId", txtTransferId);

  var balance = $(this).attr("balance");
  var transferAmount = $(this).attr("transferAmount");

  let finalBalance = parseInt(balance);
  let finalTransferAmount = parseInt(transferAmount);

  if (finalBalance < finalTransferAmount) {
    $.alert({
      title: "Alert!",
      content: "Balance is lower than your available transfer amount",
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

  $.confirm({
    title: "Confirm!",
    content: "Are you sure want to Approval ?",
    buttons: {
      confirm: function () {
        $.ajax({
          url: "ajax/subpage/transfer-first-approval.php",
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
              content: "Transfer successfully",
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

$("body").on("click", ".btnSecondApproval", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  var txtTransferId = $(this).attr("data-id");
  formData.append("txtTransferId", txtTransferId);

  var balance = $(this).attr("balance");
  var transferAmount = $(this).attr("transferAmount");

  let finalBalance = parseInt(balance);
  let finalTransferAmount = parseInt(transferAmount);

  if (finalBalance < finalTransferAmount) {
    $.alert({
      title: "Alert!",
      content: "Balance is lower than your available transfer amount",
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

  $.confirm({
    title: "Confirm!",
    content: "Are you sure want to Approval ?",
    buttons: {
      confirm: function () {
        $.ajax({
          url: "ajax/subpage/transfer-second-approval.php",
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
              content: "Transfer successfully",
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
//Balance Transfer Function - END

//Default Settings - START
$("body").on("click", "#btnDefaultAccount", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  var txtDefaultAccount = $("#txtDefaultAccount").val();
  formData.append("txtDefaultAccount", txtDefaultAccount);

  if (txtDefaultAccount == "") {
    $.alert({
      title: "Alert!",
      content: "Please Select a default account",
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

  $.confirm({
    title: "Confirm!",
    content: "Are you sure want to Default ?",
    buttons: {
      confirm: function () {
        $.ajax({
          url: "ajax/subpage/default-account-controller.php",
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
              content: "Set default successfully",
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
//Default Settings - END

//collection account - START
$("body").on("click", "#btnCollectionDepositAmount", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  var txtSelectCollectionAccount = $("#txtSelectCollectionAccount").val();
  formData.append("txtSelectCollectionAccount", txtSelectCollectionAccount);

  var txtFieldOfficerId = $("#txtFieldOfficerId").val();
  formData.append("txtFieldOfficerId", txtFieldOfficerId);

  var txtCollectionDepositAmount = $("#txtCollectionDepositAmount").val();
  formData.append("txtCollectionDepositAmount", txtCollectionDepositAmount);

  var txtCollectionPayAmount = $("#txtCollectionPayAmount").val();
  formData.append("txtCollectionPayAmount", txtCollectionPayAmount);


  if (txtFieldOfficerId == "") {
    $.alert({
      title: "Alert!",
      content: "Please Select a fieldofficer",
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

  if (txtCollectionDepositAmount == "") {
    $.alert({
      title: "Alert!",
      content: "Please enter your deposit amount",
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

  if (txtCollectionPayAmount == "") {
    $.alert({
      title: "Alert!",
      content: "Please enter your payment amount",
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

  console.log(txtCollectionDepositAmount);
  console.log(txtCollectionPayAmount);
  if (parseFloat(txtCollectionPayAmount) > parseFloat(txtCollectionDepositAmount)) {
    $.alert({
      title: "Alert!",
      content: "Please check the amount",
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
    url: "ajax/subpage/collection-amount-controller.php",
    type: "POST",
    cache: false,
    processData: false,
    contentType: false,
    data: formData,
    beforeSend: function () {
      $("#mainloader").show();
    },
    success: function (data) {
      if (data == "success") {
        $.alert({
          title: "Success!",
          content: "collection successfully",
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
      } else {
        $.alert({
          title: "Alert!",
          content: data,
          icon: "fa fa-exclamation-triangle",
          type: "red",
          theme: "modern",
          buttons: {
            Okay: function () {
              location.reload();
            },
          },
        });
        $("#mainloader").hide();
      }
    },
    error: function (data) {
      console.log(data);
      $("#mainloader").hide();
      ajaxError(data);
    },
  });
});
//collection account - END
