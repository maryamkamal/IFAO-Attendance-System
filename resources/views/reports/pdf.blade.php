<html lang="en">
    <head>

    </head>
    <body>
       <div class="dashboard-main-wrapper">

          
            <div class="page-content">
                <!-- wrapper  -->
                <div class="dashboard-wrapper page-content-div">
                    <div class="dashboard-ecommerce">
                        <div class="container-fluid dashboard-content ">
                            
                           <div class="container-fluid">

              
                <div class="card card-body basic-info-content" id="report_result" >
                   
                    <div class="system-table-div goods-table-div" >
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"id="report_data">
                            <div class="card">
                                <h5 class="card-header table-header">{{$tableModel}}</h5>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered first data-table" >
                                            <thead id ="table_heading">
                                            <tr>
                                                @foreach ($selected_columns as $column )

                                                 <th scope="col" class="img-title text-center">{{$column}}</th>
                                                @endforeach
                                            </tr>
                                            </thead>
                                            <tbody id ="table_body">
											 @foreach ($query_results as $query_result )
											 @php($query_result = json_decode(json_encode($query_result), true))
											<tr>
											 @foreach ($selected_columns as $column )
											 @if($column == 'employee_id' ||$column =='approved_by')
												 @php($result = App\Employee::find($query_result[$column]))
											 <td>{{$result['full_name_en']}}</td>
										    @elseif($column == 'permission_id')
											@php($result = App\Permission::find($query_result[$column]))
											 <td>{{$result['type']}}</td>
											 @elseif($column == 'leave_id')
											  @php($result = App\leave::find($query_result[$column]))
											 <td>{{$result['type']}}</td>
											 @elseif($column == 'work_schedule_id')
											  @php($result = App\WorkScheduleProfile::find($query_result[$column]))
											 <td>{{$result['name']}}</td>
											 @elseif($column == 'overtime_profile_id')
											  @php($result = App\OvertimeProfile::find($query_result[$column]))
											 <td>{{$result['name']}}</td>
											  
										   @else
											<td>{{$query_result[$column]}}</td>
											 @endif
											@endforeach
											</tr>
											@endforeach
                                            </tbody >
                                        </table>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
                   
            </div>
                        </div>
                    </div>
                </div>
            </div>
 </div>

      
    </body>
	
</html>
