/******* overtime-profile datatable ****///////////
$(function () {
    
    var table = $('#overtime-profile-table').DataTable({
		
       'iDisplayLength': 100,
        processing: true,
        serverSide: true,
		dom: 'Bfrtip',
        buttons: [
            'colvis'
        ],
        ajax:{
            "url":  "overtime/profiles/index",
            "type": "GET"
        },
        columns: [
		   {data: 'check_all'},
		    {data: 'id'},
			{data: 'name'},
			{data: 'first_two_hours_time_ratio'},
            {data: 'next_hours_time_ratio'},
			{data: 'weekend_days_time_ratio'},
			{data: 'holidays_time_ratio'},
			{data: 'first_two_hours_bonus_ratio'},
            {data: 'next_hours_bonus_ratio'},
			{data: 'weekend_days_bonus_ratio'},
			{data: 'holidays_bonus_ratio'},
            {data: 'action'},
        ]
    });
    oTable = $('#overtime-profile-table').dataTable();
                 $('#overtime-profile-checkall').click(function (e) {
                 $('#overtime-profile-table tbody :checkbox').prop('checked', $(this).is(':checked'));
                 e.stopImmediatePropagation();
                });
  });