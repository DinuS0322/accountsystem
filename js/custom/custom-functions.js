//Email Validation
function validateEmail(email) {
  var pattern =
    /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return pattern.test(String(email).toLowerCase());
}
//Email Validation

//Website Validation
function validateWebsite(url) {
  var pattern =
    /^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:[/?#]\S*)?$/i;
  return pattern.test(url);
}
//Website Validation

//PASSWORD - VISIBILITY
$("body").on("click", ".passwordVisibility", function () {
  var visibility = $(this).attr("data-visibility");
  var target = $(this).attr("data-target");

  if (visibility == 0) {
    $(target).attr("type", "text");
    $(this).attr("data-visibility", "1");
    $(this).html("<i class='material-icons'>visibility</i>");
  } else {
    $(target).attr("type", "password");
    $(this).attr("data-visibility", "0");
    $(this).html("<i class='material-icons'>visibility_off</i>");
  }
});
//PASSWORD - VISIBILITY

//CLEAR WHITE SPACE
$(".no-space").on("keypress", function (e) {
  if (e.which == 32) {
    console.log("Space Detected");
    return false;
  }
});
//CLEAR WHITE SPACE

//AJAX ERROR FUNCTION
function ajaxError(data) {
  Toastify({
    text: "Something went wrong. Try again !",
    duration: 5000,
    newWindow: true,
    close: true,
    gravity: "top",
    position: "center",
    stopOnFocus: false,
    style: {
      background: "#c92626",
    },
  }).showToast();

  if (data["status"] == 405) {
    $.alert({
      title: "CSRF Failed Alert!",
      content: "Something went wrong with the CSRF check.",
      icon: "far fa-frown",
      type: "red",
      theme: "modern",
      buttons: {
        okay: {
          text: "Okay",
          btnClass: "btn-red",
          action: function () {
            window.location.replace("/logout.php?action=csrmFailed");
          },
        },
      },
    });
  }

  if (data["status"] == 505) {
    $.alert({
      title: "Captcha Failed Alert!",
      content: "Something went wrong with the Captcha check.",
      icon: "far fa-frown",
      type: "red",
      theme: "modern",
      buttons: {
        okay: {
          text: "Okay",
          btnClass: "btn-red",
          action: function () {},
        },
      },
    });
  }
}
//AJAX ERROR FUNCTION

//FORMATING DATE
function formatDate(date, splitter) {
  var date = new Date(date);
  var formattedDate = "";
  if (date != "Invalid Date") {
    var yyyy = date.getFullYear();
    var mm = date.getMonth() + 1; // Months start at 0!
    var dd = date.getDate();

    if (dd < 10) dd = "0" + dd;
    if (mm < 10) mm = "0" + mm;

    formattedDate = dd + splitter + mm + splitter + yyyy;
  }
  return formattedDate;
}
//FORMATING DATE

//FORMATING DATE
function formatDateReversed(date, splitter) {
  var parts = date.split("-");

  var newDate = new Date(parts[2], parts[1] - 1, parts[0]);
  var newDateStr =
    newDate.getFullYear() +
    splitter +
    ("0" + (newDate.getMonth() + 1)).slice(-2) +
    splitter +
    ("0" + newDate.getDate()).slice(-2);

  return newDateStr;
}
//FORMATING DATE
