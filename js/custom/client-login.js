//LOGIN- START
$("body").on("click", "#btnLogin", function () {
    $("#divLoginFormCard").waitMe({
      effect: "timer",
      text: "Please Wait...",
      bg: "#ffffffbd",
      color: "#000",
      maxSize: "",
      waitTime: -1,
      textPos: "vertical",
      fontSize: "",
      source: "",
    });
  
    var formData = new FormData();
      $("#divLoginFormCard").waitMe("hide");
  
      //CSRF Protection
      var CSRF_TOKEN = $("#CSRF_TOKEN").val();
      formData.append("CSRF_TOKEN", CSRF_TOKEN);
      //CSRF Protection
  
      var txtLoginNic = $("#txtLoginNic").val();
      formData.append("txtLoginNic", txtLoginNic);
  
      var txtLoginPassword = $("#txtLoginPassword").val();
      formData.append("txtLoginPassword", txtLoginPassword);
  
      //VALIDATION
      if (txtLoginNic === "") {
        $("#txtLoginNic").focus();
        Toastify({
          text: "Please enter the valid Nic Number",
          duration: 5000,
          newWindow: false,
          close: true,
          gravity: "top",
          position: "center",
          stopOnFocus: false,
          style: {
            background: "#fbeb61",
            color: "#2c2c2c",
          },
        }).showToast();
        return false;
      }
  
      if (txtLoginPassword == "") {
        $("#txtLoginPassword").focus();
        Toastify({
          text: "Password filed Must Needed.",
          duration: 5000,
          newWindow: false,
          close: true,
          gravity: "top",
          position: "center",
          stopOnFocus: false,
          style: {
            background: "#fbeb61",
            color: "#2c2c2c",
          },
        }).showToast();
        return false;
      }
      //VALIDATION
  
      $.ajax({
        url: "ajax/client-login-controller.php",
        type: "POST",
        cache: false,
        processData: false,
        contentType: false,
        data: formData,
        beforeSend: function () {
          $("#divLoginFormCard").waitMe({
            effect: "timer",
            text: "Please Wait...",
            bg: "#ffffffbd",
            color: "#000",
            maxSize: "",
            waitTime: -1,
            textPos: "vertical",
            fontSize: "",
            source: "",
          });
        },
        success: function (data) {
          console.log(data);
          const responceData = JSON.parse(data);
          console.log(responceData);
  
          if (responceData["code"] == 200) {
            window.location.replace("/index.php");
          } else if (responceData["code"] == 405) {
            $.alert({
              title: "Alert!",
              content: "Your account has been non active, first savings your account after try again.",
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
            $("#divLoginFormCard").waitMe("hide");
          }else if (responceData["code"] == 401) {
            $.alert({
              title: "Alert!",
              content: "Incorrect Password. Try Again !",
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
            $("#divLoginFormCard").waitMe("hide");
          } else if (responceData["code"] == 404) {
            $.alert({
              title: "Alert!",
              content: "User Not Found. Check your email first !",
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
            $("#divLoginFormCard").waitMe("hide");
          } else if (responceData["code"] == 505) {
            $.alert({
              title: "Alert!",
              content: "Unauthorized access attempted. </br> This incident will be reported.",
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
            $("#divLoginFormCard").waitMe("hide");
          } else if (responceData["code"] == 408) {
            $.alert({
              title: "Alert!",
              content:
                "Your account still not activated. Please go your email and active first !",
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
            $("#divLoginFormCard").waitMe("hide");
          } else {
            $.alert({
              title: "Alert!",
              content: responceData["message"],
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
            $("#divLoginFormCard").waitMe("hide");
          }
        },
        error: function (data) {
          console.log(data);
          $("#divLoginFormCard").waitMe("hide");
          ajaxError(data);
        },
      });
  });
  //LOGIN- START
  