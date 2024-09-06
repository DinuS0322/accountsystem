$(document).ready(function(){
    $('#viewMeetings').DataTable({
        response:true
    })
});

$('body').on('change','#txtBranch', function(){
    var formData = new FormData();

    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection

    var txtBranch = $("#txtBranch").val();
    formData.append("txtBranch", txtBranch);

    $.ajax({
        url: "ajax/subpage/get-meeting-client-controller.php",
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
            $('#viewClient').html(responceData['clientDetails']);
            $("#mainloader").hide();

        },
        error: function (data) {
            console.log(data);
            $("#mainloader").hide();
            ajaxError(data);
        },
    });

});

$('body').on('click','#btnMeetingSubmit', function(){
    var formData = new FormData();

    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection

    var txtMeetingName = $("#txtMeetingName").val();
    formData.append("txtMeetingName", txtMeetingName);

    var txtDate = $("#txtDate").val();
    formData.append("txtDate", txtDate);

    var txtTime = $("#txtTime").val();
    formData.append("txtTime", txtTime);

    var txtSpecialGuest = $("#txtSpecialGuest").val();
    formData.append("txtSpecialGuest", txtSpecialGuest);

    var Remarks = $("#Remarks").val();
    formData.append("Remarks", Remarks);

    var txtBranch = $("#txtBranch").val();
    formData.append("txtBranch", txtBranch);

    function getCheckedRadioButton() {
        var radioButtonArray = [];
        var inputElements = document.getElementsByClassName('getClientId');
        Array.from(inputElements).forEach(function (inputElement) {
            getValue = inputElement.value;
            var radioButtons = document.querySelectorAll('input[name="meetingDetails-'+getValue+'"]:checked');
            radioButtons.forEach(function (radioButton) {
                var radioButtonObject = {
                    id: radioButton.id,
                    value: radioButton.value
                };
                radioButtonArray.push(radioButtonObject);
            });
        });

        return radioButtonArray;
    }

    var checkedRadioButtons = getCheckedRadioButton();

    formData.append("checkedRadioButtons", JSON.stringify(checkedRadioButtons));

    console.log(JSON.stringify(checkedRadioButtons));
    $.ajax({
        url: "ajax/subpage/create-meeting-controller.php",
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

        },
        error: function (data) {
            console.log(data);
            $("#mainloader").hide();
            ajaxError(data);
        },
    });
})