/******* users datatablr ****///////////
$(function () {
    
    var table = $('#users-table').DataTable({
       'iDisplayLength': 100,
        processing: true,
        serverSide: true,
		dom: 'Bfrtip',
        buttons: [
            'colvis'
        ],
        ajax: "users/index",
        columns: [
		    {data: 'check_all', name: 'checke_all', orderable: false, searchable: false},
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });

