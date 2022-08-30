/******* employees datatable ****///////////
$(function () {
    
    var table = $('#employees-salaries-table').DataTable({
		'iDisplayLength': 100,
		dom: 'Bfrtip',
        buttons: [
            'colvis'
        ],
        processing: true,
        serverSide: true,
        ajax:{
            "url":  "employees/salaries/index",
            "type": "GET"
        },
        columns: [
		   
		   {data: 'check_all'},
            {data: 'employee'},
			{data: 'salary'},
			{data: 'start'},
			{data: 'end'},
            {data: 'action'},
        ]
    });
   oTable = $('#employees-salaries-table').dataTable();
$('#select_all_employees_salaries').click(function (e) {
    $('#employees-salaries-table tbody :checkbox').prop('checked', $(this).is(':checked'));
    e.stopImmediatePropagation();
});
  });