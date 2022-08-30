$(function () {
   
    var table = $('#employees-leaves-table').DataTable({
		'iDisplayLength': 100,
        processing: true,
        serverSide: true,
		dom: 'Bfrtip',
        buttons: [
            'colvis'
        ],
        ajax:{
            "url":  "employee/leaves/index",
            "type": "GET"
        },
        columns: [  
		    {data: 'check_all'},
			{data: 'employee', name: 'employee.full_name_en'},
			{data: 'leave', name: 'leave.type'},
            {data: 'from'},
			{data: 'to'},
			{data: 'status'},
			{data: 'action'},
           
        ],
		"rowCallback": function( row, data, index ) {
      if ( data['status'] == "pending" || data['status'] == "manger_permission"){
        $('td', row).css('background-color', 'red');
    }
    },
	
    });
   oTable = $('#employees-leaves-table').dataTable();
                 $('#employees-leaves-table-checkall').click(function (e) {
                 $('#employees-leaves-table tbody :checkbox').prop('checked', $(this).is(':checked'));
                 e.stopImmediatePropagation();
                });
  });