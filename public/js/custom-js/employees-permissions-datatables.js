$(function () {
   
    var table = $('#employees-permissions-table').DataTable({
		'iDisplayLength': 100,
        processing: true,
        serverSide: true,
		dom: 'Bfrtip',
        buttons: [
            'colvis'
        ],
        ajax:{
            "url":  "employee/permissions/index",
            "type": "GET"
        },
        columns: [ 
            {data: 'check_all'},		
			{data: 'employee', name: 'employee.full_name_en'},
			{data: 'permission', name: 'permission.type'},
			{data: 'day'},
            {data: 'from'},
			{data: 'to'},
			{data: 'status'},
			{data: 'action'},
           
        ],
		"rowCallback": function( row, data, index ) {
      if ( data['status'] == "pending" || data['status'] == "manger_permission"){
        $('td', row).css('background-color', 'orange');
    }
    },
	
    });
	oTable = $('#employees-permissions-table').dataTable();
                 $('#employees-permissions-table-checkall').click(function (e) {
                 $('#employees-permissions-table tbody :checkbox').prop('checked', $(this).is(':checked'));
                 e.stopImmediatePropagation();
                });
   
  });