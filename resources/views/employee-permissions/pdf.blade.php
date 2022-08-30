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
<h2>Employee permissions report</h2>
</head>
<body>
<div class="system-table-div goods-table-div">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header table-header">Employee permissions List</h5>
            <div class="card-body">
                <div class="table-responsive">
                    <!----------------datatabled table  !------------------->
                    <table class="table table-striped table-bordered first data-table" id="employees-table">
                        <thead>

      <tr>

          <th scope="col" class="img-title text-center">employee name </th>
          <th scope="col" class="product-name-title text-center">Permission Type</th>
          <th scope="col" class="product-name-title text-center">day</th>
          <th scope="col" class="category-title text-center">from</th>
          <th scope="col" class="options-title text-center">to</th>
          <th scope="col" class="options-title text-center">status</th>





     </tr>
                          </thead>
                          <tbody>
						  @foreach($employee_permissions as $employee_permission)

                              <tr class="table-row">

                                  <td scope="col" class="category-title text-center"> {{$employee_permission->employee->full_name_en }}</td>
                                  <td scope="col" class="options-title text-center"> {{ $employee_permission->permission->type}}</td>
                                  <td scope="col" class="options-title text-center"> {{$employee_permission->day}}</td>
                                  <td scope="col" class="options-title text-center">  {{$employee_permission->from}} </td>
                                  <td scope="col" class="options-title text-center"> {{$employee_permission->to}} </td>
                                  <td scope="col" class="options-title text-center"> {{ $employee_permission->status}} </td>


								   </tr>
                      @endforeach
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
</body>
</html>
