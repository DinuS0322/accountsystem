$(document).ready(function () {
    $("#viewrepaymentTable").DataTable({
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

    $('#txtLoanId').selectize();
    $('#dropPaymentOption').selectize();

})

$('body').on('change', '#txtLoanId', function () {
    var formData = new FormData();

    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection

    var txtLoanId = $("#txtLoanId").val();
    formData.append("txtLoanId", txtLoanId);

    $.ajax({
        url: "ajax/subpage/get-repayment-data.php",
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
            var selectElement = document.getElementById("txtRepaymentDate");
            selectElement.options.length = 0;
            $('#txtRepaymentDate').append(responceData['dueRepaymentDate']);
            $("#mainloader").hide();
        },
        error: function (data) {
            console.log(data);
            $("#mainloader").hide();
            ajaxError(data);
        },
    });
})

$('body').on('change', '#txtRepaymentDate', function () {
    var formData = new FormData();

    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection

    var txtRepaymentDate = $("#txtRepaymentDate").val();
    formData.append("txtRepaymentDate", txtRepaymentDate);

    var txtLoanId = $("#txtLoanId").val();
    formData.append("txtLoanId", txtLoanId);

    $.ajax({
        url: "ajax/subpage/get-repayment-date-data.php",
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
            $('#txtMonthlyPrincipalAmount').val(responceData['monthlyPrincipalAmount']);
            $('#txtMonthlyInterest').val(responceData['monthlyInterest']);
            $('#txtMonthlyTotalPayment').val(responceData['monthlyamountToPay']);
            $('#txtPaymentAmount').val(responceData['monthlyamountToPay']);
            $('#txtLoanBalance').val(responceData['monthlybalance']);
            $("#mainloader").hide();
        },
        error: function (data) {
            console.log(data);
            $("#mainloader").hide();
            ajaxError(data);
        },
    });
})


$('body').on('click', '#btnSubmitRepayment', function () {

    var formData = new FormData();

    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection

    txtPaymentDate = $('#txtPaymentDate').val();
    formData.append("txtPaymentDate", txtPaymentDate);

    txtLoanId = $('#txtLoanId').val();
    formData.append("txtLoanId", txtLoanId);

    txtRepaymentDate = $('#txtRepaymentDate').val();
    formData.append("txtRepaymentDate", txtRepaymentDate);

    txtMonthlyPrincipalAmount = $('#txtMonthlyPrincipalAmount').val();
    formData.append("txtMonthlyPrincipalAmount", txtMonthlyPrincipalAmount);

    txtMonthlyInterest = $('#txtMonthlyInterest').val();
    formData.append("txtMonthlyInterest", txtMonthlyInterest);

    txtMonthlyTotalPayment = $('#txtMonthlyTotalPayment').val();
    formData.append("txtMonthlyTotalPayment", txtMonthlyTotalPayment);

    txtLoanBalance = $('#txtLoanBalance').val();
    formData.append("txtLoanBalance", txtLoanBalance);

    txtPaymentAmount = $('#txtPaymentAmount').val();
    formData.append("txtPaymentAmount", txtPaymentAmount);

    txtReceiptNo = $('#txtReceiptNo').val();
    formData.append("txtReceiptNo", txtReceiptNo);

    txtUniqueNo = $('#txtUniqueNo').val();
    formData.append("txtUniqueNo", txtUniqueNo);

    txtRepaymentOfficer = $('#txtRepaymentOfficer').val();
    formData.append("txtRepaymentOfficer", txtRepaymentOfficer);

    txtRemarks = $('#txtRemarks').val();
    formData.append("txtRemarks", txtRemarks);

    dropPaymentOption = $('#dropPaymentOption').val();
    formData.append("dropPaymentOption", dropPaymentOption);


        txtMonthlySavings = $('#txtMonthlySavings').val();
        formData.append("txtMonthlySavings", txtMonthlySavings);
        formData.append("txtSavingCheck", 'true');

    // var savingCheckBox = document.getElementById("txtSavingCheck");
    // if (savingCheckBox.checked == true) {

    // } else {
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
            if(data == 0){
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
            }else if(data == 3){
                $.alert({
                    title: "Alert!",
                    content: "Client savings account balance insufficient. Please try again. ",
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
                    title: "Success!",
                    content: " Added <strong>Successfully!</strong>.",
                    icon: "fa fa-check-circle",
                    type: "green",
                    buttons: {
                        confirm: {
                            text: 'Okey',
                            btnClass: 'btn-green',
                            action: function () {
    
                                location.reload();
                            }
                        },
                        decline: {
                            text: 'View Report',
                            btnClass: 'btn-blue',
                            action: function () {
                                location.href = "index.php?page=all-subpages&subpage=view-repayment-report&id="+data+"";
                            }
                        }
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
        $('#savingsDiv').show();


    } else {
        $('#savingsDiv').hide();

    }
}

function myFunction() {
    var checkBox = document.getElementById("txtReduceCheck");
    if (checkBox.checked == true) {
        $('#reduceDiv').show();

    } else {
        $('#reduceDiv').hide();
    }
}


$('body').on('keyup', '#txtPaymentAmount', function () {
    txtPaymentAmount = $('#txtPaymentAmount').val();
    txtPaymentAmount = parseFloat(txtPaymentAmount);
    txtMonthlyTotalPayment = $('#txtMonthlyTotalPayment').val();
    txtMonthlyTotalPayment = txtMonthlyTotalPayment.replace(',', '');
    txtMonthlyTotalPayment = parseFloat(txtMonthlyTotalPayment);

    console.log(txtMonthlyTotalPayment);
    console.log(txtPaymentAmount);
    savingBalance = txtPaymentAmount - txtMonthlyTotalPayment;
    savingBalance = savingBalance.toFixed(2);

    $('#txtMonthlySavings').val(savingBalance)
})


// $('body').on('keyup', '#txtMonthlySavings', function () {
//     txtPaymentAmount = $('#txtPaymentAmount').val();
//     txtPaymentAmount = parseFloat(txtPaymentAmount);
//     txtMonthlySavings = $('#txtMonthlySavings').val();
//     txtMonthlySavings = parseFloat(txtMonthlySavings);
//     txtMonthlyTotalPayment = $('#txtMonthlyTotalPayment').val();
//     txtMonthlyTotalPayment = parseFloat(txtMonthlyTotalPayment);

//     totlal = txtMonthlyTotalPayment + txtMonthlySavings;

//     reduceBalance = txtPaymentAmount - totlal;
//     reduceBalance = reduceBalance.toFixed(2);

//     $('#txtMonthlyReducePrincipal').val(reduceBalance)
// })

$('body').on('change', '#dropPaymentOption', function(){
    var dropPaymentOption = $('#dropPaymentOption').val();

    if(dropPaymentOption === 'cash'){
        const txtPaymentAmount = document.getElementById('txtPaymentAmount');
        txtPaymentAmount.removeAttribute('readonly');
    }else{
        const txtPaymentAmount = document.getElementById('txtPaymentAmount');
        txtPaymentAmount.setAttribute('readonly', 'readonly');
    }
})