$(document).ready(function () {
  $('#txtBranchSearch').selectize();
  const  viewTable = $("#viewClients").DataTable({
    responsive: true,
    dom: 'Bfrtip',
    buttons: [
        { extend: 'excel', text: 'Excel', className: 'btn-custom', buttonWidth: '100px',
           exportOptions: {
          columns:[0,1,2,3,4,5]
      }, },
        { extend: 'pdf', text: 'PDF', className: 'btn-custom', buttonWidth: '100px'  ,
        exportOptions: {
          columns:[0,1,2,3,4,5]
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

$('#dateRangePicker').daterangepicker({
  opens: 'left' // Adjust the position of the calendar picker
}, function(start, end, label) {
  // Filter DataTable based on the selected date range
  viewTable.columns(1).search(start.format('YYYY-MM-DD') + '|' + end.format('YYYY-MM-DD'), true, false).draw();
});

  $('#loginDetailsDiv').hide();

  $("#txtUpdateBranchId").selectize();
  $("#txtUpdateTitle").selectize();
  $("#txtUpdateGender").selectize();
  $("#txtUpdateMaritalStatus").selectize();
  $("#txtUpdateLoanOfficerId").selectize();

});


$('body').on('change', '#txtBranchSearch', function(){
  var txtBranchSearch = $("#txtBranchSearch").val();
  txtBranchSearchValue = txtBranchSearch.toLowerCase(); 
  const viewClients = document.getElementById("viewClients");
  const rows = viewClients.getElementsByTagName("tr");

  for (let i = 1; i < rows.length; i++) { // Start from 1 to skip header row
    const row = rows[i];
    const rowData = row.getElementsByTagName("td");
    let found = false;

    for (let j = 0; j < rowData.length; j++) {
        const cell = rowData[j];
        if (cell.textContent.toLowerCase().indexOf(txtBranchSearchValue) > -1) {
            found = true;
            break;
        }
    }

    if (found) {
        row.style.display = "";
    } else {
        row.style.display = "none";
    }
}


})

$('body').on('click', '#pdfConvert', function(){
  const table = document.getElementById("viewClients");
  
  var rows = [];
  for (var i = 0; i < table.rows.length; i++) {
    var rowData = [];
    for (var j = 0; j < table.rows[i].cells.length; j++) {
      rowData.push(table.rows[i].cells[j].innerText);
    }
    rows.push(rowData);
  }
  var docDefinition = {
    pageSize: 'A4',
    content: [
      {
        table: {
          headerRows: 1,
          body: rows
        }
      }
    ],
    pageMargins: [10, 10, 10, 10] // Adjust margins as needed
  };
  pdfMake.createPdf(docDefinition).download('table.pdf');
})

$('body').on('click', '#excelConvert', function(){
  const table = document.getElementById("viewClients");
  
  const columnsToExport = [];
  for (let i = 0; i < table.rows.length; i++) {
    const row = table.rows[i];
    const rowData = [];
    for (let j = 0; j < 6; j++) {
      if (row.cells[j]) {
        rowData.push(row.cells[j].innerText);
      }
    }
    columnsToExport.push(rowData);
  }
  

  const ws = XLSX.utils.aoa_to_sheet(columnsToExport);

  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, "SheetJS");

  XLSX.writeFile(wb, "client_data.xlsx");
})

$("body").on("click", "#btnCreateClient", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  var txtBranchId = $("#txtBranchId").val();
  formData.append("txtBranchId", txtBranchId);

  var txtClientNicNumber = $("#txtClientNicNumber").val();
  formData.append("txtClientNicNumber", txtClientNicNumber);

  var txtclientNicIssueDate = $("#txtclientNicIssueDate").val();
  formData.append("txtclientNicIssueDate", txtclientNicIssueDate);

  var txtTitle = $("#txtTitle").val();
  formData.append("txtTitle", txtTitle);

  var txtFirstName = $("#txtFirstName").val();
  formData.append("txtFirstName", txtFirstName);

  var txtLastName = $("#txtLastName").val();
  formData.append("txtLastName", txtLastName);

  var txtAddress = $("#txtAddress").val();
  formData.append("txtAddress", txtAddress);

  var txtGender = $("#txtGender").val();
  formData.append("txtGender", txtGender);

  var txtMaritalStatus = $("#txtMaritalStatus").val();
  formData.append("txtMaritalStatus", txtMaritalStatus);

  var txtPhoneNumber = $("#txtPhoneNumber").val();
  formData.append("txtPhoneNumber", txtPhoneNumber);

  var txtNewAccountNumber = $("#txtNewAccountNumber").val();
  formData.append("txtNewAccountNumber", txtNewAccountNumber);

  var txtOldAccountNumber = $("#txtOldAccountNumber").val();
  formData.append("txtOldAccountNumber", txtOldAccountNumber);

  var txtProfession = $("#txtProfession").val();
  formData.append("txtProfession", txtProfession);

  var txtLoanOfficerId = $("#txtLoanOfficerId").val();
  formData.append("txtLoanOfficerId", txtLoanOfficerId);

  var txtSubmittedOn = $("#txtSubmittedOn").val();
  formData.append("txtSubmittedOn", txtSubmittedOn);

  var uploadClientPhoto = document.getElementById("uploadClientPhoto").files[0];
  formData.append("uploadClientPhoto", uploadClientPhoto);

  var eSignature = document.getElementById("eSignature").files[0];
  formData.append("eSignature", eSignature);

  var folowerName = $("#folowerName").val();
  formData.append("folowerName", folowerName);

  var followerNicNumber = $("#followerNicNumber").val();
  formData.append("followerNicNumber", followerNicNumber);

  var followerNicIssueDate = $("#followerNicIssueDate").val();
  formData.append("followerNicIssueDate", followerNicIssueDate);

  var followerAddress = $("#followerAddress").val();
  formData.append("followerAddress", followerAddress);

  //VALIDATION
  if (txtBranchId == "") {
    $("#txtBranchId").focus();
    $.alert({
      title: "Alert!",
      content: "Please select a branch",
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

  if (txtclientNicIssueDate == "" || txtTitle == "" || txtLastName == "" 
  || txtAddress == "" || txtGender == "" || txtMaritalStatus == "" || txtPhoneNumber == "" || 
  txtOldAccountNumber == "" || txtProfession == "" || folowerName == "" || followerNicNumber == "" || 
  followerNicIssueDate == "" || followerAddress == "") {
    $("#txtBranchId").focus();
    $.alert({
      title: "Alert!",
      content: "Some fields are missing try again",
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

  if (txtClientNicNumber == "") {
    $("#txtClientNicNumber").focus();
    $.alert({
      title: "Alert!",
      content: "Please enter Nic Number",
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

  if (txtFirstName == "") {
    $("#txtFirstName").focus();
    $.alert({
      title: "Alert!",
      content: "Please enter your first name",
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

  if (txtNewAccountNumber == "") {
    $("#txtNewAccountNumber").focus();
    $.alert({
      title: "Alert!",
      content: "Please enter account number",
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

  if (txtLoanOfficerId == "") {
    $("#txtLoanOfficerId").focus();
    $.alert({
      title: "Alert!",
      content: "Please select a loan officer",
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

  if (uploadClientPhoto != undefined) {
    var type = uploadClientPhoto.type;
    console.log(type);
    if (type.includes("png")) {
      formData.append("uploadClientPhotoType", ".png");
    } else if (type.includes("jpg")) {
      formData.append("uploadClientPhotoType", ".jpg");
    } else if (type.includes("jpeg")) {
      formData.append("uploadClientPhotoType", ".jpeg");
    } else {
      $.alert({
        title: "Alert!",
        content: "Please Select Only JPG / PNG",
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
  } else {
    formData.append("uploadClientPhotoType", "empty");
  }

  if (eSignature != undefined) {
    var type = eSignature.type;
    console.log(type);
    if (type.includes("png")) {
      formData.append("eSignatureType", ".png");
    } else if (type.includes("jpg")) {
      formData.append("eSignatureType", ".jpg");
    } else if (type.includes("jpeg")) {
      formData.append("eSignatureType", ".jpeg");
    } else {
      $.alert({
        title: "Alert!",
        content: "Please Select Only JPG / PNG",
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
  } else {
    formData.append("eSignatureType", "empty");
  }
  //VALIDATION

  $.ajax({
    url: "ajax/subpage/create-client-controller.php",
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
          content: "Create Client successfully",
          icon: "fa fa-check-circle",
          type: "green",
          theme: "modern",
          buttons: {
            Okay: function () {
              location.reload();
            },
          },
        });
      } else if (data == "already exists") {
        $.alert({
          title: "Alert!",
          content: "Already exit client try again",
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

$("body").on("click", "#clientBasic", function () {
  var clientBasic = document.getElementById("clientBasic");
  clientBasic.classList.add("active");
  var loginDetails = document.getElementById("loginDetails");
  loginDetails.classList.remove("active");
  var clientBasic = document.getElementById("clientLoanDetails");
  clientBasic.classList.remove("active");
  var clientSavings = document.getElementById("clientSavingsDetails");
  clientSavings.classList.remove("active");
  var transection = document.getElementById("clientTransectionDetails");
  transection.classList.remove("active");
  $("#basicDetailsDiv").show();
  $("#loanDetailsDiv").hide();
  $("#savingsDetailsDiv").hide();
  $("#loginDetailsDiv").hide();
  $("#transectionDetailsDiv").hide();
});

$("body").on("click", "#clientLoanDetails", function () {
  var clientBasic = document.getElementById("clientBasic");
  clientBasic.classList.remove("active");
  var loginDetails = document.getElementById("loginDetails");
  loginDetails.classList.remove("active");
  var clientBasic = document.getElementById("clientLoanDetails");
  clientBasic.classList.add("active");
  var clientSavings = document.getElementById("clientSavingsDetails");
  clientSavings.classList.remove("active");
  var transection = document.getElementById("clientTransectionDetails");
  transection.classList.remove("active");
  $("#basicDetailsDiv").hide();
  $("#loanDetailsDiv").show();
  $("#savingsDetailsDiv").hide();
  $("#loginDetailsDiv").hide();
  $("#transectionDetailsDiv").hide();
});

$("body").on("click", "#clientSavingsDetails", function () {
  var clientBasic = document.getElementById("clientBasic");
  clientBasic.classList.remove("active");
  var loginDetails = document.getElementById("loginDetails");
  loginDetails.classList.remove("active");
  var clientBasic = document.getElementById("clientLoanDetails");
  clientBasic.classList.remove("active");
  var clientSavings = document.getElementById("clientSavingsDetails");
  clientSavings.classList.add("active");
  var transection = document.getElementById("clientTransectionDetails");
  transection.classList.remove("active");
  $("#basicDetailsDiv").hide();
  $("#loanDetailsDiv").hide();
  $("#savingsDetailsDiv").show();
  $("#loginDetailsDiv").hide();
  $("#transectionDetailsDiv").hide();
});

$("body").on("click", "#clientTransectionDetails", function () {
  var loginDetails = document.getElementById("loginDetails");
  loginDetails.classList.remove("active");
  var clientBasic = document.getElementById("clientBasic");
  clientBasic.classList.remove("active");
  var clientBasic = document.getElementById("clientLoanDetails");
  clientBasic.classList.remove("active");
  var clientSavings = document.getElementById("clientSavingsDetails");
  clientSavings.classList.remove("active");
  var transection = document.getElementById("clientTransectionDetails");
  transection.classList.add("active");
  $("#basicDetailsDiv").hide();
  $("#loanDetailsDiv").hide();
  $("#savingsDetailsDiv").hide();
  $("#loginDetailsDiv").hide();
  $("#transectionDetailsDiv").show();
});

$("body").on("click", "#loginDetails", function () {
  var loginDetails = document.getElementById("loginDetails");
  loginDetails.classList.add("active");
  var clientBasic = document.getElementById("clientBasic");
  clientBasic.classList.remove("active");
  var clientLoanDetails = document.getElementById("clientLoanDetails");
  clientLoanDetails.classList.remove("active");
  var clientSavings = document.getElementById("clientSavingsDetails");
  clientSavings.classList.remove("active");
  var transection = document.getElementById("clientTransectionDetails");
  transection.classList.remove("active");
  $("#basicDetailsDiv").hide();
  $("#loanDetailsDiv").hide();
  $("#savingsDetailsDiv").hide();
  $("#loginDetailsDiv").show();
  $("#transectionDetailsDiv").hide();
});

$("body").on("click", "#btnCreateClientUser", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  var txtFirstName = $("#txtFirstName").val();
  formData.append("txtFirstName", txtFirstName);

  var txtLastName = $("#txtLastName").val();
  formData.append("txtLastName", txtLastName);

  var txtNicNumber = $("#txtNicNumber").val();
  formData.append("txtNicNumber", txtNicNumber);

  var clientId = $(this).attr('data-id');
  formData.append("clientId", clientId);

  $.ajax({
    url: "ajax/subpage/create-client-user-controller.php",
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
          content: "Create Client successfully",
          icon: "fa fa-check-circle",
          type: "green",
          theme: "modern",
          buttons: {
            Okay: function () {
              location.reload();
            },
          },
        });
      } else if (data == "already exists") {
        $.alert({
          title: "Alert!",
          content: "Already exit client try again",
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


// update client - START
$("body").on("click", "#btnUpdateClient", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  var txtBranchId = $("#txtUpdateBranchId").val();
  formData.append("txtBranchId", txtBranchId);

  var clientId = $(this).attr("client-id");
  formData.append("clientId", clientId);

  var txtTitle = $("#txtUpdateTitle").val();
  formData.append("txtTitle", txtTitle);

  var txtFirstName = $("#txtUpdateFirstName").val();
  formData.append("txtFirstName", txtFirstName);

  var txtLastName = $("#txtUpdateLastName").val();
  formData.append("txtLastName", txtLastName);

  var txtAddress = $("#txtUpdateAddress").val();
  formData.append("txtAddress", txtAddress);

  var txtGender = $("#txtUpdateGender").val();
  formData.append("txtGender", txtGender);

  var txtMaritalStatus = $("#txtUpdateMaritalStatus").val();
  formData.append("txtMaritalStatus", txtMaritalStatus);

  var txtPhoneNumber = $("#txtUpdatePhoneNumber").val();
  formData.append("txtPhoneNumber", txtPhoneNumber);

  var txtOldAccountNumber = $("#txtUpdateOldAccountNumber").val();
  formData.append("txtOldAccountNumber", txtOldAccountNumber);

  var txtProfession = $("#txtUpdateProfession").val();
  formData.append("txtProfession", txtProfession);

  var txtLoanOfficerId = $("#txtUpdateLoanOfficerId").val();
  formData.append("txtLoanOfficerId", txtLoanOfficerId);


  var folowerName = $("#folowerUpdateName").val();
  formData.append("folowerName", folowerName);

  var followerAddress = $("#followerUpdateAddress").val();
  formData.append("followerAddress", followerAddress);

  //VALIDATION
  if (txtBranchId == "") {
    $("#txtUpdateBranchId").focus();
    $.alert({
      title: "Alert!",
      content: "Please select a branch",
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

  if (txtFirstName == "") {
    $("#txtUpdateFirstName").focus();
    $.alert({
      title: "Alert!",
      content: "Please enter your first name",
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

  if (txtLoanOfficerId == "") {
    $("#txtUpdateLoanOfficerId").focus();
    $.alert({
      title: "Alert!",
      content: "Please select a loan officer",
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
    url: "ajax/subpage/update-client-controller.php",
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
          content: "Update Client successfully",
          icon: "fa fa-check-circle",
          type: "green",
          theme: "modern",
          buttons: {
            Okay: function () {
              location.reload();
            },
          },
        });
      } else if (data == "already exists") {
        $.alert({
          title: "Alert!",
          content: "Already exit client try again",
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
// update client - END


//Delete Client- START
$("body").on("click", ".btnDeleteClient", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  var clientId = $(this).attr("client-id");
  formData.append("clientId", clientId);



  $.confirm({
    title: "Confirm!",
    content: "Are you sure want to delete ?",
    buttons: {
      confirm: function () {
        $.ajax({
          url: "ajax/subpage/delete-client-controller.php",
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
//Delete Client - END


//update profile image - start

$("body").on("click", ".updateClientPhoto", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  var clientId = $(this).attr("data-id");
  formData.append("clientId", clientId);

  var uploadClientPhoto = document.getElementById("uploadClientPhoto").files[0];
  formData.append("uploadClientPhoto", uploadClientPhoto);

  if (uploadClientPhoto != undefined) {
    var type = uploadClientPhoto.type;
    console.log(type);
    if (type.includes("png")) {
      formData.append("uploadClientPhotoType", ".png");
    } else if (type.includes("jpg")) {
      formData.append("uploadClientPhotoType", ".jpg");
    } else if (type.includes("jpeg")) {
      formData.append("uploadClientPhotoType", ".jpeg");
    } else {
      $.alert({
        title: "Alert!",
        content: "Please Select Only JPG / PNG",
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
  } else {
    formData.append("uploadClientPhotoType", "empty");
  }


  $.ajax({
    url: "ajax/subpage/update-client-profile-controller.php",
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
          content: "Update Client profile successfully",
          icon: "fa fa-check-circle",
          type: "green",
          theme: "modern",
          buttons: {
            Okay: function () {
              location.reload();
            },
          },
        });
      }else {
        $.alert({
          title: "Alert!",
          content: "Somthing went wrong",
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

//update profile image - end


//update signature image - start

$("body").on("click", ".updateClientSignature", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  var clientId = $(this).attr("data-id");
  formData.append("clientId", clientId);

  var eSignature = document.getElementById("eSignature").files[0];
  formData.append("eSignature", eSignature);

  if (eSignature != undefined) {
    var type = eSignature.type;
    console.log(type);
    if (type.includes("png")) {
      formData.append("eSignatureType", ".png");
    } else if (type.includes("jpg")) {
      formData.append("eSignatureType", ".jpg");
    } else if (type.includes("jpeg")) {
      formData.append("eSignatureType", ".jpeg");
    } else {
      $.alert({
        title: "Alert!",
        content: "Please Select Only JPG / PNG",
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
  } else {
    formData.append("eSignatureType", "empty");
  }


  $.ajax({
    url: "ajax/subpage/update-client-signature-controller.php",
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
          content: "Update Client signature successfully",
          icon: "fa fa-check-circle",
          type: "green",
          theme: "modern",
          buttons: {
            Okay: function () {
              location.reload();
            },
          },
        });
      }else {
        $.alert({
          title: "Alert!",
          content: "Somthing went wrong",
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

//update signature image - end