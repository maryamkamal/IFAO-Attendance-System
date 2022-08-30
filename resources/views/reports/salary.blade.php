@extends('layouts.home')

@section('content')

    <!----------------success & error meessage  !------------------->
    @if ($message = Session::get('success'))

        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif

    @if ($message = Session::get('error'))

        <div class="alert alert-danger alert-block">

            <button type="button" class="close" data-dismiss="alert">×</button>

            <strong>{{ $message }}</strong>

        </div>
    @endif

    <div class="container-fluid">
<div class="card card-body basic-info-content" id="report_result" >
               <div class="row">
                            <div class="col-5">
							 <label class="form-label">Select Employee</label>
                             <select class="form-control" name="employee_id" id="EmployeeID" >
						     <option value="all">All Employees </option>
						   @foreach($employees as $employee)
						    <option value="{{$employee->id}}">{{$employee->full_name_en}} </option>
							@endforeach
						   </select>
                            </div>

                            <div class="col-5">
                                 <label class="form-label">Enter Date</label>
                             <input type="date" class="form-control" name="search_date" id="search_date">
						    
                            </div>
							 <div class="col-2">
                                 <button type="button" class="btn btn-primary export-btn " onclick ="getSalaryReport()" style="background-color: #376861 !important;margin-top:35px">
                                  
                                        <span>Search</span>
                                    </button>
                            </div>
                        </div>
						</div>
                <div class="card card-body basic-info-content" id="report_result" >
                    <div class="table-outer-options-div" >
                        <div class="row">
                            <div class="col-1">
                                <a href="reports/salary_export">
                                    <button type="button" class="btn btn-primary export-btn" style="background-color: #376861 !important;">
                                        <i class="fas fa-file-export"></i>
                                        <span>Export</span>
                                    </button>
                                </a>
                            </div>

                            <div class="col-1">
                                <a href="reports/salary_print">
                                    <button type="button" class="btn btn-secondary print-btn" style="background-color: #d9ba71 !important;">
                                        <i class="fas fa-print"></i>
                                        <span>Print</span>
                                    </button>
                                </a>

                            </div>
                        </div>
                    </div>
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
											
											<!-- get salary search result here !-->
										
                                            </tbody >
                                        </table>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
                  
            </div>

@endsection
