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
<h2>Employees List</h2>
</head>
<body>
<div class="system-table-div goods-table-div">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header table-header">Employees List</h5>
            <div class="card-body">
                <div class="table-responsive">
                    <!----------------datatabled table  !------------------->
                    <table class="table table-striped table-bordered first data-table" id="employees-table">
                        <thead>

      <tr>
          @php($count=count($all_inputs))
          @php($counter=0)
          @while($counter < $count)
              <td class="barcode-div text-center">{{$all_inputs[$counter]}}</td>
              @php($counter++)
          @endwhile

     </tr>
                          </thead>
                          <tbody>
						  @foreach($employees as $employee)

                              <tr class="table-row">
                                  @php($count=count($all_inputs))
                                  @php($counter=0)
                                @while($counter < $count)
                                  <td class="barcode-div text-center">{{$employee[$all_inputs[$counter]]}}</td>
                                      @php($counter++)
                                  @endwhile

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
