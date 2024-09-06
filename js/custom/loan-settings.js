$(document).ready(function () {
  $(".selectize").selectize({});


  $("#viewRepaymentTable").DataTable({
    responsive: false,
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

  $("#viewLoanChargeTable").DataTable({
    responsive: false,
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

  $("#viewpaymentTable").DataTable({
    responsive: false,
    dom: "Bfrtip",
    buttons: [
      {
        extend: "excel",
        text: "Excel",
        className: "btn-custom",
        buttonWidth: "100px",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
        },
      },
      {
        extend: "pdf",
        text: "PDF",
        className: "btn-custom",
        buttonWidth: "100px",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
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

  $("#viewGuarantors").DataTable({
    responsive: false,
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

  $("#viewAllClientLoans").DataTable({
    response: true,
  });
  $("#viewAllClientSavings").DataTable({
    response: true,
  });
  $("#viewAllClientTransection").DataTable({
    response: true,
  });
  $("#searchClient").selectize();
  $("#searchProduct").selectize();
  $("#txtGurantorsFromClient").selectize({
    MaxItems: null,
  });
});

$("body").on("change", "#searchProduct", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  var searchProduct = $("#searchProduct").val();
  formData.append("searchProduct", searchProduct);

  var searchClient = $("#searchClient").val();
  formData.append("searchClient", searchClient);

  if (searchClient == "") {
    $("#searchClient").focus();
    $.alert({
      title: "Alert!",
      content: "Please select a client first.",
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
    url: "ajax/subpage/get-loan-data.php",
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
        //GET DATA
        shortName = responceData["shortName"];
        description = responceData["description"];
        defaultPrincipal = responceData["defaultPrincipal"];
        DefaultLoanTerm = responceData["DefaultLoanTerm"];
        DefaultInterestRate = responceData["DefaultInterestRate"];
        InterestPer = responceData["InterestPer"];
        RepaymentFrequency = responceData["RepaymentFrequency"];
        repaymentType = responceData["repaymentType"];
        fund = responceData["fund"];
        interestRate = responceData["interestRate"];
        CreditChecks = responceData["CreditChecks"];
        loanOfficerId = responceData["loanOfficerId"];
        $("#shortNameDiv").html(shortName);
        $("#descriptionDiv").html(description);
        $("#txtDefaultPrincipal").val(defaultPrincipal);
        $("#txtDefaultLoanTerm").val(DefaultLoanTerm);
        $("#txtDefaultInterestRate").val(DefaultInterestRate);
        $("#txtRepaymentFrequency").val(RepaymentFrequency);
        $("#txtrepaymentType").val(repaymentType);
        $("#interestPer").val(InterestPer);
        $("#txtfund").val(fund);
        $("#interestType").append(interestRate);
        $("#txtCreditChecks").val(CreditChecks);
        $("#txtLoanOfficerId").val(loanOfficerId);
        //GET DATA
        $("#showTermsLoan").show();
        $("#mainloader").hide();
      } else if (responceData["code"] == 502) {
        $("#showTermsLoan").hide();
        $("#mainloader").hide();
      } else {
        $("#showTermsLoan").hide();
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

$("body").on("click", "#addCharges", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  var getAllChargers = $("#getAllChargers").val();
  formData.append("getAllChargers", getAllChargers);

  var searchProduct = $("#searchProduct").val();
  formData.append("searchProduct", searchProduct);

  var searchClient = $("#searchClient").val();
  formData.append("searchClient", searchClient);

  $.ajax({
    url: "ajax/subpage/get-charges-data.php",
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
        //GET DATA
        chargeName = responceData["chargeName"];
        amount = responceData["amount"];
        chargeType = responceData["chargeType"];
        //GET DATA
        var table = document
          .getElementById("viewCharges")
          .getElementsByTagName("tbody")[0];
        var newRow = table.insertRow(table.rows.length);

        var cell1 = newRow.insertCell(0);
        var cell2 = newRow.insertCell(1);
        var cell3 = newRow.insertCell(2);

        cell1.innerHTML = chargeName;
        cell2.innerHTML = chargeType;
        cell3.innerHTML = amount;
        $("#mainloader").hide();
      } else {
        $("#showTermsLoan").hide();
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

$("body").on("keyup", "#txtDefaultPrincipal", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  var getDefaultPrincipal = document.getElementById("txtDefaultPrincipal");
  var validationCheckPrincipal = document.getElementById(
    "validationCheckPrincipal"
  );

  var txtDefaultPrincipal = $("#txtDefaultPrincipal").val();
  formData.append("txtDefaultPrincipal", txtDefaultPrincipal);

  var searchProduct = $("#searchProduct").val();
  formData.append("searchProduct", searchProduct);

  $.ajax({
    url: "ajax/subpage/calculate-principal-data.php",
    type: "POST",
    cache: false,
    processData: false,
    contentType: false,
    data: formData,
    beforeSend: function () {
      $("#mainloader").hide();
    },
    success: function (data) {
      const responceData = JSON.parse(data);
      console.log(responceData);
      if (responceData["code"] == 200) {
        getDefaultPrincipal.classList.remove("is-invalid");
        getDefaultPrincipal.classList.add("is-valid");
        validationCheckPrincipal.classList.add("hidden");
        $("#mainloader").hide();
      } else if (responceData["code"] == 502) {
        maximumPrincipal = responceData["maximumPrincipal"];
        minimumPrincipal = responceData["minimumPrincipal"];
        getDefaultPrincipal.classList.add("is-invalid");
        validationCheckPrincipal.classList.remove("hidden");
        getDefaultPrincipal.classList.remove("is-valid");
        $("#validationCheckPrincipal").html(
          "<div id='validationServer03Feedback' class='invalid - feedback text-danger'>Please enter range " +
            minimumPrincipal +
            " to " +
            maximumPrincipal +
            "</div > "
        );

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

$("body").on("keyup", "#txtDefaultLoanTerm", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  var getDefaultLoanTerm = document.getElementById("txtDefaultLoanTerm");
  var validationCheckLognterm = document.getElementById(
    "validationCheckLognterm"
  );

  var txtDefaultLoanTerm = $("#txtDefaultLoanTerm").val();
  formData.append("txtDefaultLoanTerm", txtDefaultLoanTerm);

  var searchProduct = $("#searchProduct").val();
  formData.append("searchProduct", searchProduct);

  $.ajax({
    url: "ajax/subpage/calculate-longterm-data.php",
    type: "POST",
    cache: false,
    processData: false,
    contentType: false,
    data: formData,
    beforeSend: function () {
      $("#mainloader").hide();
    },
    success: function (data) {
      const responceData = JSON.parse(data);
      console.log(responceData);
      if (responceData["code"] == 200) {
        getDefaultLoanTerm.classList.remove("is-invalid");
        getDefaultLoanTerm.classList.add("is-valid");
        validationCheckLognterm.classList.add("hidden");
        $("#mainloader").hide();
      } else if (responceData["code"] == 502) {
        MinimumLoanTerm = responceData["MinimumLoanTerm"];
        MaximumLoanTerm = responceData["MaximumLoanTerm"];
        getDefaultLoanTerm.classList.add("is-invalid");
        validationCheckLognterm.classList.remove("hidden");
        getDefaultLoanTerm.classList.remove("is-valid");
        $("#validationCheckLognterm").html(
          "<div id='validationServer03Feedback' class='invalid - feedback text-danger'>Please enter range " +
            MinimumLoanTerm +
            " to " +
            MaximumLoanTerm +
            "</div > "
        );

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

$("body").on("keyup", "#txtDefaultInterestRate", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  var getDefaultInterestRate = document.getElementById(
    "txtDefaultInterestRate"
  );
  var validationCheckRate = document.getElementById("validationCheckRate");

  var txtDefaultInterestRate = $("#txtDefaultInterestRate").val();
  formData.append("txtDefaultInterestRate", txtDefaultInterestRate);

  var searchProduct = $("#searchProduct").val();
  formData.append("searchProduct", searchProduct);

  $.ajax({
    url: "ajax/subpage/calculate-interestrate-data.php",
    type: "POST",
    cache: false,
    processData: false,
    contentType: false,
    data: formData,
    beforeSend: function () {
      $("#mainloader").hide();
    },
    success: function (data) {
      const responceData = JSON.parse(data);
      console.log(responceData);
      if (responceData["code"] == 200) {
        getDefaultInterestRate.classList.remove("is-invalid");
        getDefaultInterestRate.classList.add("is-valid");
        validationCheckRate.classList.add("hidden");
        $("#mainloader").hide();
      } else if (responceData["code"] == 502) {
        MinimumInterestRate = responceData["MinimumInterestRate"];
        MaximumInterestRate = responceData["MaximumInterestRate"];
        getDefaultInterestRate.classList.add("is-invalid");
        validationCheckRate.classList.remove("hidden");
        getDefaultInterestRate.classList.remove("is-valid");
        $("#validationCheckRate").html(
          "<div id='validationServer03Feedback' class='invalid - feedback text-danger'>Please enter range " +
            MinimumInterestRate +
            " to " +
            MaximumInterestRate +
            "</div > "
        );

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

$("body").on("click", "#createLoan", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  var searchClient = $("#searchClient").val();
  formData.append("searchClient", searchClient);

  var searchProduct = $("#searchProduct").val();
  formData.append("searchProduct", searchProduct);

  var txtfund = $("#txtfund").val();
  formData.append("txtfund", txtfund);

  var txtDefaultPrincipal = $("#txtDefaultPrincipal").val();
  formData.append("txtDefaultPrincipal", txtDefaultPrincipal);

  var txtDefaultLoanTerm = $("#txtDefaultLoanTerm").val();
  formData.append("txtDefaultLoanTerm", txtDefaultLoanTerm);

  var txtDefaultInterestRate = $("#txtDefaultInterestRate").val();
  formData.append("txtDefaultInterestRate", txtDefaultInterestRate);

  var interestPer = $("#interestPer").val();
  formData.append("interestPer", interestPer);

  var txtRepaymentFrequency = $("#txtRepaymentFrequency").val();
  formData.append("txtRepaymentFrequency", txtRepaymentFrequency);

  var txtrepaymentType = $("#txtrepaymentType").val();
  formData.append("txtrepaymentType", txtrepaymentType);

  var txtCreditChecks = $("#txtCreditChecks").val();
  formData.append("txtCreditChecks", txtCreditChecks);

  txtGurantorsFromClient = $("#txtGurantorsFromClient").val();
  formData.append("txtGurantorsFromClient", txtGurantorsFromClient);

  var txtGurantors = $("#txtGurantors").val();
  formData.append("txtGurantors", txtGurantors);

  var txtLoanOfficerId = $("#txtLoanOfficerId").val();
  formData.append("txtLoanOfficerId", txtLoanOfficerId);

  var txtLoanPurpose = $("#txtLoanPurpose").val();
  formData.append("txtLoanPurpose", txtLoanPurpose);

  var txtFundSource = $("#txtFundSource").val();
  formData.append("txtFundSource", txtFundSource);

  var interestType = $("#interestType").val();
  formData.append("interestType", interestType);

  var txtExpectedFirstRepaymentdDate = $(
    "#txtExpectedFirstRepaymentdDate"
  ).val();
  formData.append(
    "txtExpectedFirstRepaymentdDate",
    txtExpectedFirstRepaymentdDate
  );

  //VALIDATION
  if (searchClient == "") {
    $("#searchClient").focus();
    $.alert({
      title: "Alert!",
      content: "Please select a client first.",
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

  if (searchProduct == "") {
    $("#searchProduct").focus();
    $.alert({
      title: "Alert!",
      content: "Please select a product first.",
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

  if (txtDefaultPrincipal == "") {
    $("#txtDefaultPrincipal").focus();
    $.alert({
      title: "Alert!",
      content: "Please enter a principal",
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

  if (txtDefaultLoanTerm == "") {
    $("#txtDefaultLoanTerm").focus();
    $.alert({
      title: "Alert!",
      content: "Please enter a loan term",
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

  if (txtDefaultInterestRate == "") {
    $("#txtDefaultInterestRate").focus();
    $.alert({
      title: "Alert!",
      content: "Please enter a interest rate",
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
    url: "ajax/subpage/create-loan-controller.php",
    type: "POST",
    cache: false,
    processData: false,
    contentType: false,
    data: formData,
    beforeSend: function () {
      $("#mainloader").show();
    },
    success: function (data) {
      if (data == "pass") {
        $.alert({
          title: "Success!",
          content: "Create Loan successfully",
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
    },
    error: function (data) {
      console.log(data);
      $("#mainloader").hide();
      ajaxError(data);
    },
  });
});

$("body").on("change", "#txtGurantors", function () {
  $txtGurantors = $("#txtGurantors").val();
  if ($txtGurantors == "Gurantors from client") {
    $("#gurantorsFromClientDiv").show();
    $("#tableOtherGurantorsDiv").hide();
    $("#otherGnBtnDiv").hide();
  } else if ($txtGurantors == "Gurantors from others") {
    $("#gurantorsFromClientDiv").hide();
    $("#tableOtherGurantorsDiv").show();
    $("#otherGnBtnDiv").show();
  } else {
    $("#gurantorsFromClientDiv").hide();
    $("#tableOtherGurantorsDiv").hide();
    $("#otherGnBtnDiv").hide();
  }
});

$("body").on("click", "#btnAddOtherGurantos", function () {
  var formData = new FormData();
  var formData2 = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  txtName = $("#txtName").val();
  formData.append("txtName", txtName);

  txtNicNumber = $("#txtNicNumber").val();
  formData.append("txtNicNumber", txtNicNumber);

  txtAddress = $("#txtAddress").val();
  formData.append("txtAddress", txtAddress);

  txtPhoneNumber = $("#txtPhoneNumber").val();
  formData.append("txtPhoneNumber", txtPhoneNumber);

  txtMonthlySalary = $("#txtMonthlySalary").val();
  formData.append("txtMonthlySalary", txtMonthlySalary);

  txtOtherDetails = $("#txtOtherDetails").val();
  formData.append("txtOtherDetails", txtOtherDetails);

  searchProduct = $("#searchProduct").val();
  formData.append("searchProduct", searchProduct);

  searchClient = $("#searchClient").val();
  formData.append("searchClient", searchClient);
  formData2.append("searchClient", searchClient);
  formData2.append("searchProduct", searchProduct);

  //VALIDATION - START

  if (txtNicNumber == "") {
    $("#txtNicNumber").focus();
    $.alert({
      title: "Alert!",
      content: "Please enter NIC number first!",
      icon: "fa fa-exclamation-triangle",
      type: "red",
      buttons: {
        okay: {
          text: "Okay",
          btnClass: "btn-red",
        },
      },
    });
    return false;
  }

  if (txtName == "") {
    $("#txtName").focus();
    $.alert({
      title: "Alert!",
      content: "Please enter name first!",
      icon: "fa fa-exclamation-triangle",
      type: "red",
      buttons: {
        okay: {
          text: "Okay",
          btnClass: "btn-red",
        },
      },
    });
    return false;
  }

  //VALIDATION - END

  $.ajax({
    url: "ajax/subpage/add-other-gurantos-controller.php",
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
        content: " Added <strong>Successfully!</strong>.",
        icon: "fa fa-check-circle",
        type: "green",
        buttons: {
          okay: function () {
            $.ajax({
              url: "ajax/subpage/show-gurantos-controller.php",
              type: "POST",
              cache: false,
              processData: false,
              contentType: false,
              data: formData2,
              beforeSend: function () {
                $("#mainloader").show();
              },
              success: function (data) {
                console.log(data);
                $("#mainloader").hide();
                $("#tableOtherGurantorsDiv").html(data);
                $("#addOtherGurantors").modal("hide");
                document.querySelector("#txtName").value = "";
                document.querySelector("#txtNicNumber").value = "";
                document.querySelector("#txtAddress").value = "";
                document.querySelector("#txtPhoneNumber").value = "";
                document.querySelector("#txtMonthlySalary").value = "";
                document.querySelector("#txtOtherDetails").value = "";
              },
              error: function (data) {
                console.log(data);
                $("#mainloader").hide();
              },
            });
          },
        },
      });
    },
    error: function (data) {
      console.log(data);
      $("#loader").hide();
    },
  });
});

$("body").on("click", "#btnAddOtherGurantosNew", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  txtName = $("#txtName").val();
  formData.append("txtName", txtName);

  txtNicNumber = $("#txtNicNumber").val();
  formData.append("txtNicNumber", txtNicNumber);

  txtAddress = $("#txtAddress").val();
  formData.append("txtAddress", txtAddress);

  txtPhoneNumber = $("#txtPhoneNumber").val();
  formData.append("txtPhoneNumber", txtPhoneNumber);

  txtMonthlySalary = $("#txtMonthlySalary").val();
  formData.append("txtMonthlySalary", txtMonthlySalary);

  txtOtherDetails = $("#txtOtherDetails").val();
  formData.append("txtOtherDetails", txtOtherDetails);

  searchProduct = $(this).attr("data-productId");
  formData.append("searchProduct", searchProduct);

  searchClient = $(this).attr("data-clientId");
  formData.append("searchClient", searchClient);

  dataLoanId = $(this).attr("data-loanId");
  formData.append("dataLoanId", dataLoanId);

  //VALIDATION - START

  if (txtNicNumber == "") {
    $("#txtNicNumber").focus();
    $.alert({
      title: "Alert!",
      content: "Please enter NIC number first!",
      icon: "fa fa-exclamation-triangle",
      type: "red",
      buttons: {
        okay: {
          text: "Okay",
          btnClass: "btn-red",
        },
      },
    });
    return false;
  }

  if (txtName == "") {
    $("#txtName").focus();
    $.alert({
      title: "Alert!",
      content: "Please enter name first!",
      icon: "fa fa-exclamation-triangle",
      type: "red",
      buttons: {
        okay: {
          text: "Okay",
          btnClass: "btn-red",
        },
      },
    });
    return false;
  }

  //VALIDATION - END

  $.ajax({
    url: "ajax/subpage/add-other-gurantos-new-controller.php",
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
        content: " Added <strong>Successfully!</strong>.",
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
      $("#loader").hide();
    },
  });
});

//VIEW SEPARATE LOAN - START
$(".nav li a").on("click", function () {
  $(".nav li a").removeClass("active");
  $(this).addClass("active");
  activeStatus = $(this).attr("data-status");
  if (activeStatus == "guarantor") {
    $("#viewLoanDetails").hide();
    $("#rePaymentScheduleView").hide();
    $("#rePaymentView").hide();
    $("#loanChargesView").hide();
    $("#viewGurantos").show();
  } else if (activeStatus == "loanDetails") {
    $("#viewLoanDetails").show();
    $("#rePaymentScheduleView").hide();
    $("#rePaymentView").hide();
    $("#loanChargesView").hide();
    $("#viewGurantos").hide();
  } else if (activeStatus == "repaymentSchedule") {
    $("#viewLoanDetails").hide();
    $("#rePaymentScheduleView").show();
    $("#rePaymentView").hide();
    $("#viewGurantos").hide();
    $("#loanChargesView").hide();
  } else if (activeStatus == "repayments") {
    $("#viewLoanDetails").hide();
    $("#rePaymentView").show();
    $("#viewGurantos").hide();
    $("#loanChargesView").hide();
    $("#rePaymentScheduleView").hide();
  } else if (activeStatus == "loanCharge") {
    $("#viewLoanDetails").hide();
    $("#rePaymentView").hide();
    $("#viewGurantos").hide();
    $("#rePaymentScheduleView").hide();
    $("#loanChargesView").show();
  }
});
//VIEW SEPARATE LOAN - END

$(document).on("click", ".btnChangeApprovalModal", function () {
  $loanId = $(this).attr("id");

  $("#changeApprovalStatus").modal("show");
  $("#loanIdView").val($loanId);
});

$(document).on("click", ".btnChangeApprovalModalThird", function () {
  $loanId = $(this).attr("data-id");

  $("#changeApprovalStatusThird").modal("show");
  $("#loanIdViewThird").val($loanId);
});

$("body").on("click", "#btnChangeApprovalStatus", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  loanIdView = $("#loanIdView").val();
  formData.append("loanIdView", loanIdView);

  txtApprovalStatus = $("#txtApprovalStatus").val();
  formData.append("txtApprovalStatus", txtApprovalStatus);

  txtApprovedReason = $("#txtApprovedReason").val();
  formData.append("txtApprovedReason", txtApprovedReason);

  console.log(txtApprovalStatus);

  $.ajax({
    url: "ajax/subpage/change-approval-status-controller.php",
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
      if (data == 0) {
        $.alert({
          title: "Alert!",
          content: "Please set default account try again",
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
      } else if (data.includes("1")) {
        $.alert({
          title: "Alert!",
          content: "Your account balance is low. try again",
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
      }
    },
    error: function (data) {
      console.log(data);
      $("#loader").hide();
    },
  });
});

$("body").on("click", "#btnChangeApprovalStatusThird", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  loanIdView = $("#loanIdViewThird").val();
  formData.append("loanIdView", loanIdView);

  txtApprovalStatus = $("#txtApprovalStatusGet").val();
  formData.append("txtApprovalStatus", txtApprovalStatus);

  txtCheqeNo = $("#txtCheqeNo").val();
  formData.append("txtCheqeNo", txtCheqeNo);

  txtSelectAccount = $("#txtSelectAccount").val();
  formData.append("txtSelectAccount", txtSelectAccount);

  txtApprovedDes = $("#txtApprovedDes").val();
  formData.append("txtApprovedDes", txtApprovedDes);

  
  txtApprovedReason = $("#txtApprovedReason").val();
  formData.append("txtApprovedReason", txtApprovedReason);

  console.log(txtApprovalStatus);

  $.ajax({
    url: "ajax/subpage/change-approval-status-controller.php",
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
      if (data == 0) {
        $.alert({
          title: "Alert!",
          content: "Please set default account try again",
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
      } else if (data.includes("1")) {
        $.alert({
          title: "Alert!",
          content: "Your account balance is low. try again",
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
      }
    },
    error: function (data) {
      console.log(data);
      $("#loader").hide();
    },
  });
});

$("body").on("click", "#btnSubmitRepayment", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  txtPaymentDate = $("#txtPaymentDate").val();
  formData.append("txtPaymentDate", txtPaymentDate);

  txtLoanId = $("#txtLoanId").val();
  formData.append("txtLoanId", txtLoanId);

  txtRepaymentDate = $("#txtRepaymentDate").val();
  formData.append("txtRepaymentDate", txtRepaymentDate);

  txtMonthlyPrincipalAmount = $("#txtMonthlyPrincipalAmount").val();
  formData.append("txtMonthlyPrincipalAmount", txtMonthlyPrincipalAmount);

  txtMonthlyInterest = $("#txtMonthlyInterest").val();
  formData.append("txtMonthlyInterest", txtMonthlyInterest);

  txtMonthlyTotalPayment = $("#txtMonthlyTotalPayment").val();
  formData.append("txtMonthlyTotalPayment", txtMonthlyTotalPayment);

  txtLoanBalance = $("#txtLoanBalance").val();
  formData.append("txtLoanBalance", txtLoanBalance);

  txtLoanBalanceView = $("#txtLoanBalanceView").val();
  formData.append("txtLoanBalanceView", txtLoanBalanceView);

  txtRepaymentOfficer = $("#txtRepaymentOfficer").val();
  formData.append("txtRepaymentOfficer", txtRepaymentOfficer);

  txtRemarks = $("#txtRemarks").val();
  formData.append("txtRemarks", txtRemarks);

  txtPaymentAmount = $("#txtPaymentAmount").val();
  formData.append("txtPaymentAmount", txtPaymentAmount);

  txtReceiptNo = $("#txtReceiptNo").val();
  formData.append("txtReceiptNo", txtReceiptNo);

  txtUniqueNo = $("#txtUniqueNo").val();
  formData.append("txtUniqueNo", txtUniqueNo);

  dropPaymentOption = $("#dropPaymentOption").val();
  formData.append("dropPaymentOption", dropPaymentOption);

  txtMonthlySavings = $("#txtMonthlySavings").val();
  formData.append("txtMonthlySavings", txtMonthlySavings);
  formData.append("txtSavingCheck", "true");

  // var savingCheckBox = document.getElementById("txtSavingCheck");
  // if (savingCheckBox.checked == true) {

  // }else{
  //     formData.append("txtMonthlySavings", '0');
  //     formData.append("txtSavingCheck", 'false');
  // }

  // var reduceCheckBox = document.getElementById("txtReduceCheck");
  // if (reduceCheckBox.checked == true) {
  //     txtMonthlyReducePrincipal = $('#txtMonthlyReducePrincipal').val();
  //     formData.append("txtMonthlyReducePrincipal", txtMonthlyReducePrincipal);
  //     formData.append("txtReduceCheck", 'true');
  // } else {
  //     formData.append("txtMonthlyReducePrincipal", '0');
  //     formData.append("txtReduceCheck", 'false');
  // }

  $.ajax({
    url: "ajax/subpage/add-repayment-flat-controller.php",
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
      if (data == 0) {
        $.alert({
          title: "Alert!",
          content: "Please set default account try again",
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
          title: "Success!",
          content: " Added <strong>Successfully!</strong>.",
          icon: "fa fa-check-circle",
          type: "green",
          buttons: {
            confirm: {
              text: "Okey",
              btnClass: "btn-green",
              action: function () {
                location.reload();
              },
            },
            decline: {
              text: "View Report",
              btnClass: "btn-blue",
              action: function () {
                location.href =
                  "index.php?page=all-subpages&subpage=view-repayment-report&id=" +
                  data +
                  "";
              },
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

function savingsFunction() {
  var checkBox = document.getElementById("txtSavingCheck");
  if (checkBox.checked == true) {
    $("#savingsDiv").show();
  } else {
    $("#savingsDiv").hide();
  }
}

function myFunction() {
  var checkBox = document.getElementById("txtReduceCheck");
  if (checkBox.checked == true) {
    $("#reduceDiv").show();
  } else {
    $("#reduceDiv").hide();
  }
}

$("body").on("keyup", "#txtPaymentAmount", function () {
  txtPaymentAmount = $("#txtPaymentAmount").val();
  txtPaymentAmount = parseFloat(txtPaymentAmount);
  txtMonthlyTotalPayment = $("#txtMonthlyTotalPayment").val();
  txtMonthlyTotalPayment = txtMonthlyTotalPayment.replace(",", "");
  txtMonthlyTotalPayment = parseFloat(txtMonthlyTotalPayment);

  console.log(txtMonthlyTotalPayment);
  console.log(txtPaymentAmount);
  savingBalance = txtPaymentAmount - txtMonthlyTotalPayment;
  savingBalance = savingBalance.toFixed(2);

  // totalpaybal = txtLoanBalance - txtPaymentAmount;
  // totalpaybal = parseFloat(totalpaybal);
  // totalpaybal = totalpaybal.toFixed(2);

  $("#txtMonthlySavings").val(savingBalance);

  // txtMonthlyReducePrincipal = $('#txtMonthlyReducePrincipal').val();
  // txtMonthlyReducePrincipal = parseFloat(txtMonthlyReducePrincipal);

  // var txtLoanBalance = $('#txtLoanBalance').val();
  //  txtLoanBalance = txtLoanBalance.replace(',', '');
  // txtLoanBalance = parseFloat(txtLoanBalance);

  // fff = txtLoanBalance - txtMonthlyReducePrincipal;
  // fff = fff.toFixed(2);
  // $('#txtLoanBalanceView').val(fff)
});

$("body").on("keyup", "#txtMonthlySavings", function () {
  txtPaymentAmount = $("#txtPaymentAmount").val();
  txtPaymentAmount = parseFloat(txtPaymentAmount);
  txtMonthlySavings = $("#txtMonthlySavings").val();
  txtMonthlySavings = parseFloat(txtMonthlySavings);
  txtMonthlyTotalPayment = $("#txtMonthlyTotalPayment").val();
  txtMonthlyTotalPayment = txtMonthlyTotalPayment.replace(",", "");
  txtMonthlyTotalPayment = parseFloat(txtMonthlyTotalPayment);

  totlal = txtMonthlyTotalPayment + txtMonthlySavings;
  totlal = parseFloat(totlal);
  reduceBalance = txtPaymentAmount - totlal;
  reduceBalancee = txtPaymentAmount - totlal;
  reduceBalancee = parseFloat(reduceBalancee);
  reduceBalance = reduceBalance.toFixed(2);

  txtMonthlyTotalPayment = $("#txtMonthlyTotalPayment").val();
  txtMonthlyTotalPayment = parseFloat(txtMonthlyTotalPayment);

  txtMonthlyReducePrincipal = $("#txtMonthlyReducePrincipal").val();
  txtMonthlyReducePrincipal = parseFloat(txtMonthlyReducePrincipal);
  ccc = txtMonthlyReducePrincipal - txtMonthlySavings;
  $("#txtMonthlyReducePrincipal").val(reduceBalance);

  txtLoanBalance = $("#txtLoanBalance").val();
  txtLoanBalance = txtLoanBalance.replace(",", "");
  txtLoanBalance = parseFloat(txtLoanBalance);

  totalpay = txtPaymentAmount - txtMonthlySavings;
  totalpaybal = txtLoanBalance - reduceBalancee;
  totalpaybal = parseFloat(totalpaybal);
  totalpaybal = totalpaybal.toFixed(2);

  $("#txtLoanBalanceView").val(totalpaybal);
});

$("body").on("click", ".generatePaymentReport", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  var repaymentId = $(this).attr("data-repaymentId");
  formData.append("repaymentId", repaymentId);

  $.ajax({
    url: "ajax/subpage/generate-repayment-report.php",
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
        content: " Added <strong>Successfully!</strong>.",
        icon: "fa fa-check-circle",
        type: "green",
        buttons: {
          decline: {
            text: "View Report",
            btnClass: "btn-blue",
            action: function () {
              window.open("../upload/generateDoc/" + data + ".pdf", "_blank");
              location.reload();
            },
          },
        },
      });
    },
    error: function (data) {
      console.log(data);
      $("#loader").hide();
    },
  });
});

$("body").on("click", ".btnDeleteLoan", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  var id = $(this).attr("data-id");
  formData.append("id", id);

  $.confirm({
    title: "Confirm!",
    content: "Are you sure want to delete ?",
    buttons: {
      confirm: function () {
        $.ajax({
          url: "ajax/subpage/remove-loan.php",
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
              content: "Removed <strong>Successfull!</strong>.",
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

$("body").on("click", ".requestForLoan", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  var id = $(this).attr("data-id");
  formData.append("id", id);

  $.confirm({
    title: "Confirm!",
    content: "Are you sure want to Request For Loan ?",
    buttons: {
      confirm: function () {
        $.ajax({
          url: "ajax/subpage/request-loan.php",
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
              content: "Requested <strong>Successfull!</strong>.",
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
// $(document).ready(function () {
//     calculateDate();
// })

function calculateDate() {
  var sDate = $("#txtPaymentDate").val();
  var eDate = $("#txtRepaymentDate").val();
  var txtMonthlyInterest = $("#txtMonthlyInterest").val();
  var txtrepaymentType = $("#txtrepaymentType").val();
  var txtprincipal = $("#txtprincipal").val();
  txtprincipal = parseFloat(txtprincipal);
  var txtinterestRate = $("#txtinterestRate").val();
  txtinterestRate = parseFloat(txtinterestRate);
  var txtinterestPer = $("#txtinterestPer").val();
  var txtinterestRateType = $("#txtinterestRateType").val();
  if (txtMonthlyInterest == "0" || txtMonthlyInterest == "0.00") {
  } else {
    var startDate = new Date(sDate);
    var endDate = new Date(eDate);

    var timeDifference = endDate.getTime() - startDate.getTime();
    var totalDays = Math.floor(timeDifference / (1000 * 3600 * 24)) + 1;
    totalDays = parseInt(totalDays);
    console.log(totalDays);

    if (startDate > endDate) {
      if (txtinterestRateType == "Reduce Amount") {
        if (txtinterestPer == "Month") {
          calculate = (txtinterestRate / 100) * txtprincipal;
          fcal = (calculate / 30) * totalDays;
          txtMonthlyInterest = parseFloat(txtMonthlyInterest);
          lcal = txtMonthlyInterest - fcal;
          $("#txtMonthlyInterest").val(lcal);
        }
      }

      console.log("yes");
    } else if (startDate.getTime() === endDate.getTime()) {
      console.log("equal");
    } else {
      console.log("no");
    }
  }
}

$("body").on("click", "#btnWriteOff", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  var loanId = $("#txtfinalLoanId").val();
  formData.append("loanId", loanId);

  var writeoffReason = $("#writeoffReason").val();
  formData.append("writeoffReason", writeoffReason);

  $.confirm({
    title: "Confirm!",
    content: "<strong>Are you sure want to write off loan?</strong>",
    buttons: {
      confirm: {
        text: "Confirm",
        btnClass: "btn-red",
        action: function () {
          $.ajax({
            url: "ajax/subpage/writeoff-loan-controller.php",
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
                content: "Requested <strong>Successfully!</strong>.",
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
      },
      cancel: function () {},
    },
  });
});

$("body").on("click", "#btnInterestWise", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  var loanId = $("#txtfinalLoanId").val();
  formData.append("loanId", loanId);

  console.log(loanId);
  var txtInterestWiseReason = $("#txtInterestWiseReason").val();
  formData.append("txtInterestWiseReason", txtInterestWiseReason);

  $.confirm({
    title: "Confirm!",
    content: "<strong>Are you sure want to interest wise loan?</strong>",
    buttons: {
      confirm: {
        text: "Confirm",
        btnClass: "btn-red",
        action: function () {
          $.ajax({
            url: "ajax/subpage/interestwise-loan-controller.php",
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
                content: "Requested <strong>Successfully!</strong>.",
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
      },
      cancel: function () {},
    },
  });
});
