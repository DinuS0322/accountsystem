$(document).ready(function(){
    
  var table = $("#viewAllLoans").DataTable({
    responsive: true,
    dom: "Bfrtip",
    buttons: [
      {
        extend: "excel",
        text: "Excel",
        className: "btn-custom",
        buttonWidth: "100px",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7],
        },
      },
      {
        extend: "pdf",
        text: "PDF",
        className: "btn-custom",
        buttonWidth: "100px",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7],
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

  $("#txtFilterStatus").on("change", function () {
    var status = $(this).val();
    console.log(status);
    table.column(7).search(status).draw();
  });
  $("#txtFilterLoanStatus").on("change", function () {
    var status = $(this).val();
    console.log(status);
    table.column(6).search(status).draw();
  });

  //date range filter
  $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    var min = $("#fromdate").val();
    var max = $("#todate").val();
    var date = new Date(data[2]);

    if (
      (min === "" || new Date(min) <= date) &&
      (max === "" || new Date(max) >= date)
    ) {
      return true;
    }
    return false;
  });

  // Handle the date range inputs
  $("#fromdate, #todate").change(function () {
    table.draw();
  });
  //date range filter

  //amount range filter

  function applyRangeFilter() {
    var min = parseFloat($('#fromAmount').val());
    var max = parseFloat($('#toAmount').val());

   
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        var amount = parseFloat(data[3]);
        if ((isNaN(min) || amount >= min) && (isNaN(max) || amount <= max)) {
            return true;
        }
        return false;
    });

    table.draw();
}

$('#fromAmount, #toAmount').on('keyup change', function() {
  $.fn.dataTable.ext.search.pop(); 
  applyRangeFilter();
});
  //amount range filter
})