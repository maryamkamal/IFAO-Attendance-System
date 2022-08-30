/******* employees datatable ****///////////
$(function () {
    
    var table = $('#employees-table').DataTable({
		'iDisplayLength': 100,
		dom: 'Bfrtip',
        buttons: [
            'colvis'
        ],
        processing: true,
        serverSide: true,
        ajax:{
            "url":  "employees/index",
            "type": "GET"
        },
        columns: [
		   
		    {data: 'check_all'},
			{data: 'image'},
			{data: 'code'},
            {data: 'full_name_en'},
			{data: 'overtime_profile'},
			{data: 'work_schedule'},
			{data: 'salary'},
			{data: 'hourly_labor_cost'},
			{data: 'solde'},
			{data: 'overtime_hours'},
			{data: 'rfid_id'},
            {data: 'action'},
        ]
    });
   oTable = $('#employees-table').dataTable();
$('#select_all_employees').click(function (e) {
    $('#employees-table tbody :checkbox').prop('checked', $(this).is(':checked'));
    e.stopImmediatePropagation();
});
  });