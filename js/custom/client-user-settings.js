$(document).ready(function () {
  $("#viewAllClientUsers").DataTable({
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
});

$("body").on("click", ".btnActive", function () {
  var formData = new FormData();

  //CSRF Protection
  var CSRF_TOKEN = $("#CSRF_TOKEN").val();
  formData.append("CSRF_TOKEN", CSRF_TOKEN);
  //CSRF Protection

  var userId = $(this).attr("userId");
  formData.append("userId", userId);

  var data_status = $(this).attr("data-status");
  formData.append("data_status", data_status);

  $.ajax({
    url: "ajax/subpage/update-user-status-controller.php",
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
          content: "Update client users successfully",
          icon: "fa fa-check-circle",
          type: "green",
          theme: "modern",
          buttons: {
            Okay: function () {
              location.reload();
            },
          },
        });
      } else{
        $.alert({
          title: "Error!",
          content: "Update client users failed",
          icon: "fa fa-times-circle",
          type: "red",
          theme: "modern",
          buttons: {
            Okay: function () {
              location.reload();
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

$("body").on("click", ".btnNonActive", function () {
    var formData = new FormData();
  
    //CSRF Protection
    var CSRF_TOKEN = $("#CSRF_TOKEN").val();
    formData.append("CSRF_TOKEN", CSRF_TOKEN);
    //CSRF Protection
  
    var userId = $(this).attr("userId");
    formData.append("userId", userId);
  
    var data_status = $(this).attr("data-status");
    formData.append("data_status", data_status);
  
    $.ajax({
      url: "ajax/subpage/update-user-status-controller.php",
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
              content: "Update client users successfully",
              icon: "fa fa-check-circle",
              type: "green",
              theme: "modern",
              buttons: {
                Okay: function () {
                  location.reload();
                },
              },
            });
          } else{
            $.alert({
              title: "Error!",
              content: "Update client users failed",
              icon: "fa fa-times-circle",
              type: "red",
              theme: "modern",
              buttons: {
                Okay: function () {
                  location.reload();
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
