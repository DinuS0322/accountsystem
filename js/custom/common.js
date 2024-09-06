$(document).ready(function(){

    $("#viewActivity").DataTable({
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
            doc.pageSize = 'A4'; 
            doc.content[1].table.widths = '*';
        } 
        }
        ]
    });
})