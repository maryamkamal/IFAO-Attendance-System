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

              
                <div class="system-table-div goods-table-div" >
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"id="report_data">
                            <div class="card">
                                <h5 class="card-header table-header">	Salary Report</h5>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered first data-table" >
                                            <thead id ="table_heading">
                                            <tr>
                                                

                                                 <th scope="col" class="img-title text-center">Employee</th>
												 <th scope="col" class="img-title text-center">Salary</th>
												 <th scope="col" class="img-title text-center">Hourly Labor Cost</th>
												 <th scope="col" class="img-title text-center"> Cumulative Delay </th>
												 <th scope="col" class="img-title text-center"> Vacations Balance </th>
												 <th scope="col" class="img-title text-center"> Cumulative Overtime Bonus</th>
												 <th scope="col" class="img-title text-center">Total Salary</th>
                                        
                                            </tr>
                                            </thead>
                                            <tbody id ="salary_result">
											@foreach( $employees as $employee)
			                      
				                    <?php  
				                           if($employee->solde <= 0){
					                        $employee_total_salary =  $employee->salary -($employee->hourly_labor_cost * $employee->delay_balance);
				                                }
				                           else {
					                         $employee_total_salary =  $employee->salary + $employee_overtime_bonus[$employee->id];
					                          
				                               } ?>
											<tr>
											
											 <td>
											 {{$employee->full_name_en}}
											</td>
											<td>
											{{$employee->salary}}
											</td>
											<td>
											{{$employee->hourly_labor_cost}}
											</td>
											<td>
											 {{$employee->delay_balance}}
											</td>
											<td>
											{{round($employee->solde /8,2)}}
											 </td>
											<td>
											{{$employee_overtime_bonus[$employee->id]}}
											</td>
											<td>
											{{$is_paid}}
											</td>
											<td>
											{{$employee_total_salary}}
											</td>
											
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

      
    </body>
	
</html>
