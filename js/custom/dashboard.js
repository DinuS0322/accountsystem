//Copy Booking Link
$("body").on("click", "#btnCopyBookingLink", function () {
  var range = document.createRange();
  range.selectNode(document.getElementById("spanBookingLink"));
  window.getSelection().removeAllRanges();
  window.getSelection().addRange(range);
  document.execCommand("copy");
  window.getSelection().removeAllRanges();
  $("#bookingLinkModal").modal("hide");

  $.alert({
    title: "Success!",
    content: "Copied <strong>Successfull!</strong>.",
    icon: "fa fa-check-circle",
    type: "green",
    buttons: {
      Okay: function () {},
    },
  });
});
//Copy Booking Link

//Copy Profile Link
$("body").on("click", "#btnCopyProfileLink", function () {
  var range = document.createRange();
  range.selectNode(document.getElementById("spanProfileLink"));
  window.getSelection().removeAllRanges();
  window.getSelection().addRange(range);
  document.execCommand("copy");
  window.getSelection().removeAllRanges();
  $("#profileLinkModal").modal("hide");
  $.alert({
    title: "Success!",
    content: "Copied <strong>Successfull!</strong>.",
    icon: "fa fa-check-circle",
    type: "green",
    buttons: {
      Okay: function () {},
    },
  });
});
//Copy Profile Link

//Download Booking QR
$("body").on("click", "#btnDownloadBookingQr", function () {
  var imgElement = document.getElementById("imgBookingQrCode");
  var canvas = document.createElement("canvas");
  canvas.width = imgElement.width;
  canvas.height = imgElement.height;
  var context = canvas.getContext("2d");
  context.drawImage(imgElement, 0, 0);
  var dataUrl = canvas.toDataURL("image/png");
  var link = document.createElement("a");
  link.href = dataUrl;
  link.download = "Booking-Qr-Code.jpg";
  link.click();
});
//Download Booking QR

//Download Profile QR
$("body").on("click", "#btnDownloadProfilrQr", function () {
  var imgElement = document.getElementById("imgProfileQrCode");
  var canvas = document.createElement("canvas");
  canvas.width = imgElement.width;
  canvas.height = imgElement.height;
  var context = canvas.getContext("2d");
  context.drawImage(imgElement, 0, 0);
  var dataUrl = canvas.toDataURL("image/png");
  var link = document.createElement("a");
  link.href = dataUrl;
  link.download = "Profile-Qr-Code.jpg";
  link.click();
});
//Download Profile QR
