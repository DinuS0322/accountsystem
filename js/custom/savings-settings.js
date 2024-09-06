$(document).ready(function(){
    $('#searchProduct').selectize();
    $('#clientData').selectize();
    $('#txtProductCategory').selectize();
    $('#txtOtherProductYears').selectize();
    $("#viewSavingsHistory").DataTable({
        responsive: false,
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excel', text: 'Excel', className: 'btn-custom', buttonWidth: '100px',
               exportOptions: {
              columns:[0,1,2,3,4]
          }, },
            { extend: 'pdf', text: 'PDF', className: 'btn-custom', buttonWidth: '100px'  ,
            exportOptions: {
              columns:[0,1,2,3,4]
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
    $("#viewAllLoanSavingsData").DataTable({
        responsive: false,
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excel', text: 'Excel', className: 'btn-custom', buttonWidth: '100px',
               exportOptions: {
              columns:[0,1,2,3]
          }, },
            { extend: 'pdf', text: 'PDF', className: 'btn-custom', buttonWidth: '100px'  ,
            exportOptions: {
              columns:[0,1,2,3]
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
    $("#viewManageProduct").DataTable({
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excel', text: 'Excel', className: 'btn-custom', buttonWidth: '100px',
               exportOptions: {
              columns:[0,1,2,3,4]
          }, },
            { extend: 'pdf', text: 'PDF', className: 'btn-custom', buttonWidth: '100px'  ,
            exportOptions: {
              columns:[0,1,2,3,4]
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

    $("#viewAllSavings").DataTable({
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

    $("#viewAllSavingsDetails").DataTable({
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

    $("#viewAllOtherSavings").DataTable({
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

    $("#viewAllChildrenSavings").DataTable({
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

    $("#viewAllLoanSavings").DataTable({
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

    $('#searchClient').selectize();
});

$('body').on('change', '#clientData', function () {
    var formData = new FormData();

    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection

    var clientData = $("#clientData").val();
    formData.append("clientData", clientData);
    

    $.ajax({
        url: "ajax/subpage/get-Saving-data-controller.php",
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
            if(responceData['code'] == 200){
              $('#viewSavingsData').html(responceData['dataOption']);
              $('#savingAccount').selectize();
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


$('body').on('click', '#btnSavingDeposit', function () {
    var formData = new FormData();

    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection

    var clientData = $("#clientData").val();
    formData.append("clientData", clientData);

    var savingAccount = $("#savingAccount").val();
    formData.append("savingAccount", savingAccount);

    var txtSavingAmount = $("#txtSavingAmount").val();
    formData.append("txtSavingAmount", txtSavingAmount);

    if(savingAccount == ""){
        $("#savingAccount").focus();
        $.alert({
            title: "Alert!",
            content: "Please select your account",
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

    if(txtSavingAmount == ""){
        $("#txtSavingAmount").focus();
        $.alert({
            title: "Alert!",
            content: "Please enter the amount",
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
        url: "ajax/subpage/create-Saving-deposit-controller.php",
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
            if(data == "success"){
                $.alert({
                    title: "Success!",
                    content: "Create savings deposit successfully",
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


$('body').on('click', '#btnCreateSaving', function () {
    var formData = new FormData();

    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection

    var searchClient = $("#searchClient").val();
    formData.append("searchClient", searchClient);

    var searchProduct = $("#searchProduct").val();
    formData.append("searchProduct", searchProduct);

    var txtSavingAmount = $("#txtSavingAmount").val();
    formData.append("txtSavingAmount", txtSavingAmount);

    var txtGetCategory = $("#txtGetCategory").val();

    if(txtGetCategory == "Normal" || txtGetCategory == "Others"){
        var txtPersonalName = $("#txtPersonalName").val();
        formData.append("txtPersonalName", txtPersonalName);

        var txtStartDate = $("#txtStartDate").val();
        formData.append("txtStartDate", txtStartDate);

        formData.append("txtChildrenName",'');
        formData.append("txtChildrenDateOfBirth",'');

        if (txtPersonalName == "") {
            $("#txtPersonalName").focus();
            $.alert({
                title: "Alert!",
                content: "Please enter your name",
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

        if (txtStartDate == "") {
            $("#txtStartDate").focus();
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
    
    }else{
        var txtChildrenName = $("#txtChildrenName").val();
        formData.append("txtChildrenName", txtChildrenName);

        var txtChildrenDateOfBirth = $("#txtChildrenDateOfBirth").val();
        formData.append("txtChildrenDateOfBirth", txtChildrenDateOfBirth);

        formData.append("txtPersonalName",'');
        formData.append("txtStartDate",'');

        if (txtChildrenName == "") {
            $("#txtChildrenName").focus();
            $.alert({
                title: "Alert!",
                content: "Please enter your name",
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

        if (txtChildrenDateOfBirth == "") {
            $("#txtChildrenDateOfBirth").focus();
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
    }

    if (searchClient == "") {
        $("#searchClient").focus();
        $.alert({
            title: "Alert!",
            content: "Please select a client",
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
            content: "Please select a product",
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

    if (txtSavingAmount == "") {
        $("#txtSavingAmount").focus();
        $.alert({
            title: "Alert!",
            content: "Please Enter your amount",
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
        url: "ajax/subpage/create-Saving-controller.php",
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
            if(data == "success"){
                $.alert({
                    title: "Success!",
                    content: "Create savings successfully",
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

$('body').on('change', '#txtProductCategory', function () {
    var txtProductCategory = $('#txtProductCategory').val();

    if(txtProductCategory == 'Others'){
        var txtOtherProductYears  = document.getElementById('txtOtherProductYearsDiv');
        txtOtherProductYears.classList.remove('hidden');
    }else{
        var txtOtherProductYears  = document.getElementById('txtOtherProductYearsDiv');
        txtOtherProductYears.classList.add('hidden');
    }
});

$('body').on('click', '#btnCreateSavingsProduct', function () {
    var formData = new FormData();

    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection

    var txtProductCategory = $("#txtProductCategory").val();
    formData.append("txtProductCategory", txtProductCategory);

    if(txtProductCategory == 'Others'){
        var txtOtherProductYears = $("#txtOtherProductYears").val();
        formData.append("txtOtherProductYears", txtOtherProductYears);
    }else{
        var txtOtherProductYears = '';
        formData.append("txtOtherProductYears", txtOtherProductYears);
    }

    var txtProductName = $("#txtProductName").val();
    formData.append("txtProductName", txtProductName);

    var txtProductShortName = $("#txtProductShortName").val();
    formData.append("txtProductShortName", txtProductShortName);

    var txtProductDescription = $("#txtProductDescription").val();
    formData.append("txtProductDescription", txtProductDescription);

    var txtProductInterest = $("#txtProductInterest").val();
    formData.append("txtProductInterest", txtProductInterest);

    if (txtProductCategory == "") {
        $("#txtProductCategory").focus();
        $.alert({
            title: "Alert!",
            content: "Please select a category",
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

    if (txtProductName == "") {
        $("#txtProductName").focus();
        $.alert({
            title: "Alert!",
            content: "Please enter your product name",
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

    if (txtProductShortName == "") {
        $("#txtProductShortName").focus();
        $.alert({
            title: "Alert!",
            content: "Please enter a short name",
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

    if (txtProductInterest == "") {
        $("#txtProductInterest").focus();
        $.alert({
            title: "Alert!",
            content: "Please enter your product interest",
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
        url: "ajax/subpage/create-Saving-product-controller.php",
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
            if(data == "success"){
                $.alert({
                    title: "Success!",
                    content: "Create savings product successfully",
                    icon: "fa fa-check-circle",
                    type: "green",
                    theme: "modern",
                    buttons: {
                        Okay: function () {
                            location.reload();
                        },
                    },
                });
            }else if(data == 0){
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
            }else{
                $.alert({
                    title: "Alert!",
                    content: "Something wrong try again",
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

$('body').on('change', '#searchProduct', function () {
    var formData = new FormData();

        //CSRF Protection
        var CSRF_TOKEN = $("#CSRF_TOKEN").val();
        formData.append("CSRF_TOKEN", CSRF_TOKEN);
        //CSRF Protection

    var searchProduct = $('#searchProduct').val();
    formData.append("searchProduct", searchProduct);


    $.ajax({
        url: "ajax/subpage/get-Saving-product-controller.php",
        type: "POST",
        cache: false,
        processData: false,
        contentType: false,
        data: formData,
        beforeSend: function () {
            $("#mainloader").show();
        },
        success: function (data) {
            const responseData = JSON.parse(data);
            if(responseData['code'] == 200){
            $('#savingsProductDiv').html(responseData['productDetails']);
            $('#txtGetCategory').val(responseData['category']);

            if(responseData['category'] == 'Normal' || responseData['category'] == 'Others'){
                var personaldetailsDiv  = document.getElementById('personaldetailsDiv');
                personaldetailsDiv.classList.remove('hidden');
                var childrendetailsDiv  = document.getElementById('childrendetailsDiv');
                childrendetailsDiv.classList.add('hidden');
            }else{
                var childrendetailsDiv  = document.getElementById('childrendetailsDiv');
                childrendetailsDiv.classList.remove('hidden');
                var personaldetailsDiv  = document.getElementById('personaldetailsDiv');
                personaldetailsDiv.classList.add('hidden');
            }

            var txtOtherProductYears  = document.getElementById('savingsProductDiv');
            txtOtherProductYears.classList.remove('hidden');
            }else{
                $.alert({
                    title: "Alert!",
                    content: "somthing error try again",
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


$("body").on("click", "#savingBasic", function () {
    var savingBasic = document.getElementById("savingBasic");
    savingBasic.classList.add("active");
    var savingsHistory = document.getElementById("savingsHistory");
    savingsHistory.classList.remove("active");
    $("#basicDetailsDiv").show();
    $("#savingHistoryDiv").hide();
  });

  $("body").on("click", "#savingsHistory", function () {
    var savingBasic = document.getElementById("savingBasic");
    savingBasic.classList.remove("active");
    var savingsHistory = document.getElementById("savingsHistory");
    savingsHistory.classList.add("active");
    $("#basicDetailsDiv").hide();
    $("#savingHistoryDiv").show();
  });