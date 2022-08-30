@extends('layouts.home')

@section('content')
    <style>
        button {
            color: #1b1d20;
            background-color: transparent;
            background-repeat: no-repeat;
            border: none;
            cursor: pointer;
            overflow: hidden;
            outline: none;
        }</style>
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
        <div class="row flex-nowrap">
            <div class="col-auto col-2 px-sm-2 px-0">
                <div class="d-flex flex-column align-items-center align-items-sm-middle px-3 pt-2 text-black min-vh-100" style="background-color: #eadaa8;">
                    <a  class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-5 d-none d-sm-inline" style="color: #1b1d20;"><h5>Database Tables</h5> </span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu" >
                        <li class="nav-item">
                            <button href="" class="px-0 pt-2 align-middle"  onclick="getTableColumns('absences')" >
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline" >absences </span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button href="" class="px-0 pt-2 align-middle"  onclick="getTableColumns('attendances')" >
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline" >attendances </span>
                            </button>
                        </li>
						 <li class="nav-item">
                            <button href="" class="px-0 pt-2 align-middle"  onclick="getTableColumns('attendance_net')" >
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline" >attendance_net </span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button href="" class="px-0 pt-2 align-middle" onclick="getTableColumns('employee_leaves')" >
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline" >employee_leaves </span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button href="" class="px-0 pt-2 align-middle" onclick="getTableColumns('employee_permissions')" >
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline" >employee_permissions</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button href="" class="px-0 pt-2 align-middle" onclick="getTableColumns('leaves')" >
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline" >leaves</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button href="" class="px-0 pt-2 align-middle" onclick="getTableColumns('over_time_profiles')" >
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline" >over_time_profiles</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button href="" class="px-0 pt-2 align-middle" onclick="getTableColumns('permissions')" >
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline" >permissions </span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button href="" class="px-0 pt-2 align-middle" onclick="getTableColumns('employees')" >
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline" >employees </span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button href="" class="px-0 pt-2 align-middle" onclick="getTableColumns('users')" >
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline" >users </span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button href="" class="px-0 pt-2 align-middle" onclick="getTableColumns('vacations')" >
                                        <span class="ms-2 d-none d-sm-inline" style="color: #1b1d20;">vacations</span></button>
                        </li>
                        <li class="nav-item">
                            <button href="" class="px-0 pt-2 align-middle" onclick="getTableColumns('work_schedule_profiles')" >
                                <i class="fs-4 bi-table"></i> <span class="ms-2 d-none d-sm-inline" style="color: #1b1d20;">work_schedule_profiles</span></button>
                        </li>
                    </ul>
                    <hr>

                </div>
            </div>

            <div class="col py-10 pt-2">
                <form action="{{url('reports/generated/result')}}" id="QueryForm" method="POST">
                    @csrf
                <div class="card card-body basic-info-content">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label class="form-label"> Report Name </label>
                            <input type="text" class="form-control" name="report_name" required>
                        </div>
                    </div>
                </div>
                <div class="card card-body basic-info-content" id="columns-card" style="display:none;">
                    <div class="row px-2 page-header" id="table_name">
                      Table Coulmns
                     </div>
                          <div id="table_coulmns"></div>
                    </div>
                <div class="card card-body basic-info-content" id="filter-card" style="display:none;">
                    <div class="row px-2 page-header" >
                        Filter Table
                    </div>
                        <!-------------------------------1---------------------------------------!-->

                        <div class="row" style ="margin-left: 10px" id="filters" >
                            <div class="form-group col-lg-4">
                                <select class="form-control" name="filters[0][filter_column]" id="filter_column" onclick="InputType()" >
                                   
                                 </select>
                            </div>
                            <div class="form-group col-lg-2">
                                <select class="form-control" name="filters[0][filter_operator]" id="filter_operator" >
                                    <option value="">Select Operator</option>
                                    <option value="=">=</option>
                                    <option value="!=">!=</option>
                                    <option value=">=">>=</option>
                                    <option value=">">></option>
                                    <option value="<="><=</option>
                                    <option value="<"><</option>
                                    <option value="null">like</option>
                                    <option value="null">null</option>
                                    <option value="!null">!null</option>

                                </select>
                            </div>
                            <div class="form-group col-lg-4" id="filter_input">
                               
                            </div>

                            <div class="form-group col-lg-1" >
                                <button type="button" class="btn btn-outline-success btn-floating" style="background-color: #376861 !important;" onclick="clone(1)">
                                    <i class="fas fa-plus"></i></button>
                            </div>

                        </div>
                        <!------------------------------------2-----------------------------------------------------!-->
                        <div class="row" id="filters_1" style="margin-left:10px;visibility:hidden;" >
                            <div class="form-group col-lg-4">
                                <select class="form-control" name="filters[1][filter_column]" id="filter_column_1"  onclick="getInputType(1)" >
                                   
                                </select>
                            </div>
                            <div class="form-group col-lg-2">
                                <select class="form-control" name="filters[1][filter_operator]" id="filter_operator" >
                                    <option value="">Select Operator</option>
                                    <option value="=">=</option>
                                    <option value="!=">!=</option>
                                    <option value=">=">>=</option>
                                    <option value=">">></option>
                                    <option value="<="><=</option>
                                    <option value="<"><</option>
                                    <option value="null">like</option>
                                    <option value="null">null</option>
                                    <option value="!null">!null</option>

                                </select>
                            </div>
                            <div class="form-group col-lg-4" id="filter_input_1">
                              
                            </div>

                            <div class="form-group col-lg-1" >
                                <button type="button" class="btn btn-outline-success btn-floating" style="background-color: #376861 !important;"
                                        onclick="clone(2)"><i class="fas fa-plus"></i></button>
                            </div>
                            <div class="form-group col-lg-1">
                                <button type="button" class="btn btn-floating"  style="background-color: #9b1717  !important;"
                                        onclick="remove(1)" ><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <!------------------------------------------3-------------------------------------------------!-->
                        <div class="row"  id="filters_2" style="visibility:hidden;margin-left: 10px">
                            <div class="form-group col-lg-4">
                                <select class="form-control" name="filters[2][filter_column]" id="filter_column_2"  onclick="getInputType(2)" >
                                   
                                </select>
                            </div>
                            <div class="form-group col-lg-2">
                                <select class="form-control" name="filters[2][filter_operator]" id="filter_operator" >
                                    <option value="">Select Operator</option>
                                    <option value="=">=</option>
                                    <option value="!=">!=</option>
                                    <option value=">=">>=</option>
                                    <option value=">">></option>
                                    <option value="<="><=</option>
                                    <option value="<"><</option>
                                    <option value="null">like</option>
                                    <option value="null">null</option>
                                    <option value="!null">!null</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-4" id="filter_input_2">
                              
                            </div>

                            <div class="form-group col-lg-1" >
                                <button type="button" class="btn btn-outline-success btn-floating" style="background-color: #376861 !important;" onclick="clone(3)"><i class="fas fa-plus"></i></button>
                            </div>
                            <div class="form-group col-lg-1" >
                                <button type="button" class="btn btn-floating"  style="background-color: #9b1717  !important;"  onclick="remove(2)"  id="remove_filter"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <!---------------------------------------------4-------------------------------------------------------!-->
                        <div class="row"  id="filters_3" style="visibility:hidden;margin-left: 10px">
                            <div class="form-group col-lg-4">
                                <select class="form-control" name="filters[3][filter_column]" id="filter_column_3"  onclick="getInputType(3)" >
                                   
                                </select>
                            </div>
                            <div class="form-group col-lg-2">
                                <select class="form-control" name="filters[3][filter_operator]" id="filter_operator" >
                                    <option value="">Select Operator</option>
                                    <option value="=">=</option>
                                    <option value="!=">!=</option>
                                    <option value=">=">>=</option>
                                    <option value=">">></option>
                                    <option value="<="><=</option>
                                    <option value="<"><</option>
                                    <option value="null">like</option>
                                    <option value="null">null</option>
                                    <option value="!null">!null</option>

                                </select>
                            </div>
                            <div class="form-group col-lg-4" id="filter_input_3">
                              
                            </div>

                            <div class="form-group col-lg-1" >
                                <button type="button" class="btn btn-outline-success btn-floating" style="background-color: #376861 !important;" onclick="clone(4)"><i class="fas fa-plus"></i></button>
                            </div>
                            <div class="form-group col-lg-1" id="filter_input">
                                <button type="button" class="btn btn-floating"  style="background-color: #9b1717  !important;"  onclick="remove(3)"
                                        id="remove_filter"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <!----------------------------------------------5-------------------------------------------------------!-->
                        <div class="row" id="filters_4"  style="visibility:hidden;margin-left: 10px">
                            <div class="form-group col-lg-4">
                                <select class="form-control" name="filters[4][filter_column]" id="filter_column_4" onclick="getInputType(4)" >
                                   
                                </select>
                            </div>
                            <div class="form-group col-lg-2">
                                <select class="form-control" name="filters[4][filter_operator]" id="filter_operator" >
                                    <option value="">Select Operator</option>
                                    <option value="=">=</option>
                                    <option value="!=">!=</option>
                                    <option value=">=">>=</option>
                                    <option value=">">></option>
                                    <option value="<="><=</option>
                                    <option value="<"><</option>
                                    <option value="null">like</option>
                                    <option value="null">null</option>
                                    <option value="!null">!null</option>

                                </select>
                            </div>
                            <div class="form-group col-lg-4" id="filter_input_4">
                             
                            </div>

                            <div class="form-group col-lg-1" >
                                <button type="button" class="btn btn-outline-success btn-floating" style="background-color: #376861 !important;"
                                        onclick="clone(5)"><i class="fas fa-plus"></i></button>
                            </div>
                            <div class="form-group col-lg-1" >
                                <button type="button" class="btn btn-floating"  style="background-color: #9b1717  !important;"  onclick="remove(4)"  id="remove_filter"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <!----------------------------------------6---------------------------------------->
                        <div class="row"  id="filters_5"  style="visibility:hidden;margin-left: 10px">
                            <div class="form-group col-lg-4">
                                <select class="form-control" name="filters[5][filter_column]" id="filter_column_5"  onclick="getInputType(5)" >
                            
                                </select>
                            </div>
                            <div class="form-group col-lg-2">
                                <select class="form-control" name="filters[5][filter_operator]" id="filter_operator" >
                                    <option value="">Select Operator</option>
                                    <option value="=">=</option>
                                    <option value="!=">!=</option>
                                    <option value=">=">>=</option>
                                    <option value=">">></option>
                                    <option value="<="><=</option>
                                    <option value="<"><</option>
                                    <option value="null">like</option>
                                    <option value="null">null</option>
                                    <option value="!null">!null</option>

                                </select>
                            </div>
                            <div class="form-group col-lg-4" id="filter_input_5">
                              
                            </div>

                            <div class="form-group col-lg-1" >
                               
                            </div>
                            <div class="form-group col-lg-1" >
                                <button type="button" class="btn btn-floating"  style="background-color: #9b1717  !important;"  onclick="remove(5)"
                                        id="remove_filter"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <!----------------------------------------------------------------------------------------------------!-->

                </div>
                <button type="submit" class="btn btn-primary btn-block" id="runQuery" style="background-color: #376861 !important;   display:none;">Run Query</button>
                </form>


            </div>
    </div>
    </div>
@endsection
