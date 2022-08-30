 $(function () {
    
    var table = $('#vacations-table').DataTable({
		'iDisplayLength': 100,
        processing: true,
        serverSide: true,
		dom: 'Bfrtip',
        buttons: [
            'colvis'
        ],
        ajax:{
            "url":  "vacations/index",
            "type": "GET"
        },
        columns: [
		   {data: 'check_all'},
		    {data: 'name'},
			{data: 'from'},
			{data: 'to'},
			{data: 'action'},
        ]
    });
    oTable = $('#vacations-table').dataTable();
                 $('#vacations-table-checkall').click(function (e) {
                 $('#vacations-table tbody :checkbox').prop('checked', $(this).is(':checked'));
                 e.stopImmediatePropagation();
                });
  });