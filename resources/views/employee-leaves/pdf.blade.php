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
<h2> {{__('employee-leaves.Employee Leaves report')}} </h2>
</head>
<body>
<div class="system-table-div goods-table-div">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header table-header">{{__('employee-leaves.Employee Leaves List')}}</h5>
            <div class="card-body">
                <div class="table-responsive">
                    <!----------------datatabled table  !------------------->
                    <table class="table table-striped table-bordered first data-table" id="employees-table">
                        <thead>

      <tr>

          <th scope="col" class="img-title text-center">{{__('employee-leaves.Employee')}}  </th>
          <th scope="col" class="product-name-title text-center">{{__('employee-leaves.Leave')}}</th>
          <th scope="col" class="category-title text-center">{{__('employee-leaves.from')}} </th>
          <th scope="col" class="options-title text-center">{{__('employee-leaves.to')}} </th>
          <th scope="col" class="options-title text-center">{{__('employee-leaves.status')}} </th>





     </tr>
                          </thead>
                          <tbody>
						  @foreach($leaves as $leave)

                              <tr class="table-row">

                                  <td scope="col" class="category-title text-center"> {{$leave->employee->full_name_en }}</td>
                                  <td scope="col" class="options-title text-center"> {{ $leave->permission->type}}</td>
                                  <td scope="col" class="options-title text-center">  {{$leave->from}} </td>
                                  <td scope="col" class="options-title text-center"> {{$leave->to}} </td>
                                  <td scope="col" class="options-title text-center"> {{ $leave->status}} </td>


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
