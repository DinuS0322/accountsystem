$(document).ready(function(){

    $("#viewChargeTable").DataTable({
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
})

$('body').on('click', '#btnAddCharges', function(){
    var formData = new FormData();

    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection

    var txtChargeName = $("#txtChargeName").val();
    formData.append("txtChargeName", txtChargeName);

    var txtChargesType = $("#txtChargesType").val();
    formData.append("txtChargesType", txtChargesType);

    var txtAmount = $("#txtAmount").val();
    formData.append("txtAmount", txtAmount);

    var txtChargeOption = $("#txtChargeOption").val();
    formData.append("txtChargeOption", txtChargeOption);

    var txtPenalty = $("#txtPenalty").val();
    formData.append("txtPenalty", txtPenalty);

    var txtOverride = $("#txtOverride").val();
    formData.append("txtOverride", txtOverride);

    var txtActive = $("#txtActive").val();
    formData.append("txtActive", txtActive);


    //VALIDATION
    if (txtChargeName == "") {
        $("#txtChargeName").focus();
        $.alert({
            title: "Alert!",
            content: "Please enter charge name",
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

    if (txtChargesType == "") {
        $("#txtChargesType").focus();
        $.alert({
            title: "Alert!",
            content: "Please enter charge Type",
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
    //VALIDATION

    $.ajax({
        url: "ajax/subpage/create-loan-charge-controller.php",
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
                    content: "Create Charge successfully",
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