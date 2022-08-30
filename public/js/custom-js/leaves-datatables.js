 $(function () {
    
    var table = $('#leaves-table').DataTable({
       'iDisplayLength': 100,
        processing: true,
        serverSide: true,
		dom: 'Bfrtip',
        buttons: [
            'colvis'
        ],
        ajax:{
            "url":  "leaves/index",
            "type": "GET"
        },
        columns: [
            {data: 'check_all'},
			{data: 'type'},
			{data: 'is_paid'},
			{data: 'solde_deduction'},
			{data: 'action'},
        ]
    });
    oTable = $('#leaves-table').dataTable();
                 $('#leaves-table-checkall').click(function (e) {
                 $('#leaves-table tbody :checkbox').prop('checked', $(this).is(':checked'));
                 e.stopImmediatePropagation();
                });
  });