$(document).ready(function(){

    $('.selectize').selectize();

    $("#viewAllLoansReports").DataTable({
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

});

$('body').on('click','#btnViewArrears', function(){
    var formData = new FormData();

    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection

    var txtEndDate = $("#txtEndDate").val();
    formData.append("txtEndDate", txtEndDate);
    
    if(txtEndDate == ""){
        $("#txtEndDate").focus();
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

    $.ajax({
        url: "ajax/subpage/get-arrears-report-controller.php",
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
            $('#viewArreasDiv').html(responceData['arreasReport']);
            $("#dueReports").DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'excel', text: 'Excel', className: 'btn-custom', buttonWidth: '100px',
                       exportOptions: {
                      columns:[0,1,2,3,4,5,6,7,8]
                  }, },
                    { extend: 'pdf', text: 'PDF', className: 'btn-custom', buttonWidth: '100px'  ,
                    exportOptions: {
                        columns:[0,1,2,3,4,5,6,7,8]
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
            $("#mainloader").hide();

        },
        error: function (data) {
            console.log(data);
            $("#mainloader").hide();
            ajaxError(data);
        },
    });

});

$('body').on('click','#btnViewCollection', function(){
    var formData = new FormData();

    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection

    var txtEndDate = $("#txtEndDate").val();
    formData.append("txtEndDate", txtEndDate);
    console.log(txtEndDate);

    var txtStartDate = $("#txtStartDate").val();
    formData.append("txtStartDate", txtStartDate);

    var selectLoanOfficer = $("#selectLoanOfficer").val();
    formData.append("selectLoanOfficer", selectLoanOfficer);
    
    if(txtEndDate == ""){
        $("#txtEndDate").focus();
        $.alert({
            title: "Alert!",
            content: "Please select a end date",
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

    if(txtStartDate == ""){
        $("#txtStartDate").focus();
        $.alert({
            title: "Alert!",
            content: "Please select a start date",
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

    if(selectLoanOfficer == ""){
        $("#selectLoanOfficer").focus();
        $.alert({
            title: "Alert!",
            content: "Please select a Loan Officer",
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
        url: "ajax/subpage/get-collection-report-controller.php",
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
            $('#viewCollectionDiv').html(responceData['arreasReport']);
            $("#collectionReports").DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'excel', text: 'Excel', className: 'btn-custom', buttonWidth: '100px',
                       exportOptions: {
                      columns:[0,1,2,3,4,5,6,7,8]
                  }, },
                    { extend: 'pdf', text: 'PDF', className: 'btn-custom', buttonWidth: '100px'  ,
                    exportOptions: {
                        columns:[0,1,2,3,4,5,6,7,8]
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

            $('#viewCollectionTotalDiv').html(responceData['totalPaymentsReport']);
            $("#collectionTotalReports").DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'excel', text: 'Excel', className: 'btn-custom', buttonWidth: '100px',
                       exportOptions: {
                      columns:[0,1,2]
                  }, },
                    { extend: 'pdf', text: 'PDF', className: 'btn-custom', buttonWidth: '100px'  ,
                    exportOptions: {
                        columns:[0,1,2]
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
            $("#mainloader").hide();

        },
        error: function (data) {
            console.log(data);
            $("#mainloader").hide();
            ajaxError(data);
        },
    });

});


$('body').on('click','#btnViewRepayment', function(){
    var formData = new FormData();

    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection

    var txtEndDate = $("#txtEndDate").val();
    formData.append("txtEndDate", txtEndDate);
    console.log(txtEndDate);

    var txtStartDate = $("#txtStartDate").val();
    formData.append("txtStartDate", txtStartDate);

    var selectLoanOfficer = $("#selectLoanOfficer").val();
    formData.append("selectLoanOfficer", selectLoanOfficer);
    
    if(txtEndDate == ""){
        $("#txtEndDate").focus();
        $.alert({
            title: "Alert!",
            content: "Please select a end date",
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

    if(txtStartDate == ""){
        $("#txtStartDate").focus();
        $.alert({
            title: "Alert!",
            content: "Please select a start date",
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

    if(selectLoanOfficer == ""){
        $("#selectLoanOfficer").focus();
        $.alert({
            title: "Alert!",
            content: "Please select a Loan Officer",
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
        url: "ajax/subpage/get-repayment-report-controller.php",
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
            $('#viewRepaymentDiv').html(responceData['arreasReport']);
            $("#repaymentReports").DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'excel', text: 'Excel', className: 'btn-custom', buttonWidth: '100px',
                       exportOptions: {
                      columns:[0,1,2,3,4,5,6,7,8]
                  }, },
                    { extend: 'pdf', text: 'PDF', className: 'btn-custom', buttonWidth: '100px'  ,
                    exportOptions: {
                        columns:[0,1,2,3,4,5,6,7,8]
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
            $("#mainloader").hide();

        },
        error: function (data) {
            console.log(data);
            $("#mainloader").hide();
            ajaxError(data);
        },
    });

});