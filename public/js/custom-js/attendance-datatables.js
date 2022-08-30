/******* attendance datatable ****///////////
$(function () {
    $('#attendance-table thead tr')
        .clone(true)
        .addClass('filters')
        .appendTo('#attendance-table thead');
    var table = $('#attendance-table').DataTable({
		'iDisplayLength': 100,
		dom: 'Bfrtip',
        buttons: [
            'colvis'
        ],
        processing: true,
        serverSide: true,
		searchable: true,
        ajax:{
            "url":  "attendance/index",
            "type": "GET"
        },
        columns: [
		    
		   {data: 'check_all'},
		  {data: 'employee', name: 'employee.full_name_en'},
			{data: 'work_schedule', name: 'work_schedule.name'},
			{data: 'overtime_profile', name: 'overtime_profile.name'},
            {data: 'day'},
			{data: 'from'},
			{data: 'to'},
			{data: 'leave_type'},
			{data: 'action'},
           
        ],
		"rowCallback": function( row, data, index ) {
      if ( data['work_schedule'] == "Absent" )
    {
        $('td', row).css('background-color', 'orange');
    }if ( data['work_schedule'] != "Absent" &&(data['from'] == null || data['to'] == null) )
    {
        $('td', row).css('background-color', 'red');
    }
    },
	orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
 
            // For each column
            api
                .columns([1,2,3,4,5,6])
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
	oTable = $('#attendance-table').dataTable();
                 $('#attendance_checkall').click(function (e) {
                 $('#attendance-table tbody :checkbox').prop('checked', $(this).is(':checked'));
                 e.stopImmediatePropagation();
                });

  });