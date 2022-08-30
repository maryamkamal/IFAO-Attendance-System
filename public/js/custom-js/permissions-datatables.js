 $(function () {
    
    var table = $('#permissions-table').DataTable({
        'iDisplayLength': 100,
        processing: true,
        serverSide: true,
		dom: 'Bfrtip',
        buttons: [
            'colvis'
        ],
        ajax:{
            "url":  "permissions/index",
            "type": "GET"
        },
        columns: [
		   {data: 'check_all'},
		    {data: 'id'},
			{data: 'type'},
			{data: 'is_paid'},
			{data: 'action'},
        ]
    });
    oTable = $('#permissions-table').dataTable();
                 $('#permissions-table-checkall').click(function (e) {
                 $('#permissions-table tbody :checkbox').prop('checked', $(this).is(':checked'));
                 e.stopImmediatePropagation();
                });
  });