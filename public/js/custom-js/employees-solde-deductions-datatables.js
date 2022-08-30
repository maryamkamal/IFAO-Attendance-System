$(function () {
   
    var table = $('#employees-sold-deduction-table').DataTable({
		'iDisplayLength': 100,
        processing: true,
        serverSide: true,
		dom: 'Bfrtip',
        buttons: [
            'colvis'
        ],
        ajax:{
            "url":  "employee/solde/deduction/index",
            "type": "GET"
        },
        columns: [ 
            {data: 'check_all'},		
			{data: 'employee', name: 'employee.full_name_en'},
			{data: 'deducted_solde'},
			{data: 'note'},
			{data: 'deducted_by'},
			{data: 'action'},
           
        ],
	
    });
	oTable = $('#employees-sold-deduction-table').dataTable();
                 $('#employees-sold-deduction-table-checkall').click(function (e) {
                 $('#employees-sold-deduction-table tbody :checkbox').prop('checked', $(this).is(':checked'));
                 e.stopImmediatePropagation();
                });
   
  });