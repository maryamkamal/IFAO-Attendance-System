/******* attendance datatable ****///////////
$(function () {
    $('#attendance-net-table thead tr')
        .clone(true)
        .addClass('filters')
        .appendTo('#attendance-net-table thead');
		
     

    var table = $('#attendance-net-table').DataTable({
       'iDisplayLength': 100,
        'dom': 'Blfrtip',
        buttons: [
            'colvis'
        ],
	   processing: true,
        serverSide: true,
        ajax:{
            "url":  "attendance-net/index",
            "type": "GET"
        },
        columns: [
		    
		    {data: 'check_all'},
			{data: 'employee', name: 'employee.full_name_en'},
            {data: 'day'},
			{data: 'worked_duration'},
			{data: 'final_overtime_hours'},
			{data: 'overtime_net_percentage'},
			{data: 'overtime_bonus'},
			{data: 'delay_deduction'},
			{data: 'deducted_delay'},
			{data: 'delay'},
			{data: 'action'},
           
        ],
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
 
            // For each column
            api
                .columns([1,2,3,4,5,6,7,8])
                .eq(0)
                .each(function (colIdx) {
                    // Set the header cell to contain the input element
                    var cell = $('.filters th').eq(
                        $(api.column(colIdx).header()).index()
                    );
                    var title = $(cell).text();
                    $(cell).html('<input type="text" placeholder="' + title + '" style="width:100%"/>');
 
                    // On every keypress in this input
                    $(
                        'input',
                        $('.filters th').eq($(api.column(colIdx).header()).index())
                    )
                        .off('keyup change')
                        .on('keyup change', function (e) {
                            e.stopPropagation();
 
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})'; //$(this).parents('th').find('select').val();
 
                            var cursorPosition = this.selectionStart;
                            // Search the column for that value
                            api
                                .column(colIdx)
                                .search(
                                    this.value != ''
                                        ? regexr.replace('{search}', '(((' + this.value + ')))')
                                        : '',
                                    this.value != '',
                                    this.value == ''
                                )
                                .draw();
 
                            $(this)
                                .focus()[0]
                                .setSelectionRange(cursorPosition, cursorPosition);
                        });
                });
        },
    });
	oTable = $('#attendance-net-table').dataTable();
                 $('#attendance-net-checkall').click(function (e) {
                 $('#attendance-net-table tbody :checkbox').prop('checked', $(this).is(':checked'));
                 e.stopImmediatePropagation();
                });
				$('table th').resizable({
    handles: 'e',
    stop: function(e, ui) {
      $(this).width(ui.size.width);
    }
  });
   
  });