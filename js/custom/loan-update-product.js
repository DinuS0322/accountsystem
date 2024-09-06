$('body').on('click', '#btnUpdateProduct', function () {
    var formData = new FormData();

    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection

    var txtProductid = $("#txtProductid").val();
    formData.append("txtProductid", txtProductid);

    var txtProductName = $("#txtProductName").val();
    formData.append("txtProductName", txtProductName);

    var txtShortName = $("#txtShortName").val();
    formData.append("txtShortName", txtShortName);

    var txtDescription = $("#txtDescription").val();
    formData.append("txtDescription", txtDescription);

    var txtFund = $("#txtFund").val();
    formData.append("txtFund", txtFund);

    var txtDefaultPrincipal = $("#txtDefaultPrincipal").val();
    formData.append("txtDefaultPrincipal", txtDefaultPrincipal);

    var txtMinimumPrincipal = $("#txtMinimumPrincipal").val();
    formData.append("txtMinimumPrincipal", txtMinimumPrincipal);

    var txtMaximumPrincipal = $("#txtMaximumPrincipal").val();
    formData.append("txtMaximumPrincipal", txtMaximumPrincipal);

    var txtDefaultLoanTerm = $("#txtDefaultLoanTerm").val();
    formData.append("txtDefaultLoanTerm", txtDefaultLoanTerm);

    var txtMinimumLoanTerm = $("#txtMinimumLoanTerm").val();
    formData.append("txtMinimumLoanTerm", txtMinimumLoanTerm);

    var txtMaximumLoanTerm = $("#txtMaximumLoanTerm").val();
    formData.append("txtMaximumLoanTerm", txtMaximumLoanTerm);

    var txtRepaymentFrequency = $("#txtRepaymentFrequency").val();
    formData.append("txtRepaymentFrequency", txtRepaymentFrequency);

    var txtType = $("#txtType").val();
    formData.append("txtType", txtType);

    var txtDefaultInterestRate = $("#txtDefaultInterestRate").val();
    formData.append("txtDefaultInterestRate", txtDefaultInterestRate);

    var txtMinimumInterestRate = $("#txtMinimumInterestRate").val();
    formData.append("txtMinimumInterestRate", txtMinimumInterestRate);

    var txtMaximumInterestRate = $("#txtMaximumInterestRate").val();
    formData.append("txtMaximumInterestRate", txtMaximumInterestRate);

    var txtInterestPer = $("#txtInterestPer").val();
    formData.append("txtInterestPer", txtInterestPer);

    var txtCharges = $("#txtCharges").val();
    formData.append("txtCharges", txtCharges);

    var txtCreditChecks = $("#txtCreditChecks").val();
    formData.append("txtCreditChecks", txtCreditChecks);

    var txtActive = $("#txtActive").val();
    formData.append("txtActive", txtActive);

    var txtInterestType = $("#txtInterestType").val();
    formData.append("txtInterestType", txtInterestType);


    //VALIDATION
    if (txtProductName == "") {
        $("#txtProductName").focus();
        $.alert({
            title: "Alert!",
            content: "Please enter product name",
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
            content: "Please enter default principal",
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
            content: "Please enter default interest rate",
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
        url: "ajax/subpage/update-loan-product-controller.php",
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
                    content: "Updated product successfully",
                    icon: "fa fa-check-circle",
                    type: "green",
                    theme: "modern",
                    buttons: {
                        Okay: function () {
                            location.reload();
                        },
                    },
                });
            }
            else {
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


})