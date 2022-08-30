/******* work-profile datatable ****///////////
$(function () {
    
    var table = $('#work-profile-table').DataTable({
		
        'iDisplayLength': 100,
        processing: true,
        serverSide: true,
		dom: 'Bfrtip',
        buttons: [
            'colvis'
        ],
        ajax:{
            "url":  "work/schedules/index",
            "type": "GET"
        },
        columns: [
		   {data: 'check_all'},
		    {data: 'id'},
			{data: 'name'},
			{data: 'start'},
            {data: 'end'},
			{data: 'work_days'},
			{data: 'work_duration'},
            {data: 'action'},
        ]
    });
    oTable = $('#work-profile-table').dataTable();
                 $('#work-profile-table-checkall').click(function (e) {
                 $('#work-profile-table tbody :checkbox').prop('checked', $(this).is(':checked'));
                 e.stopImmediatePropagation();
                });
  });