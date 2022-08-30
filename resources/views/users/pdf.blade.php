<style>

table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 5px;
}
th {
  text-align: left;
}
</style>
<html>

<head>
<h2>users List</h2>
</head>
<body>
<div style="overflow-x:auto;">
<table >

  <thead>

      <tr>
								  <th >Name</th>
                                  <th >Email</th>
 
     </tr>
                          </thead>
                          <tbody>
						  @foreach($users as $user)

                              <tr class="table-row">
							  
                                  <td class="barcode-div text-center">{{$user->name}}</td>
                                  <td class="product-num-div text-center">{{$user->email}}</td>

								   </tr>
@endforeach
                          </tbody>
                 </table>
				 </div>	
</body>
</html>
		  