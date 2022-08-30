@php(App::setLocale('en'))
<div class="dashboard-header">
        <nav class="navbar navbar-expand-lg bg-white fixed-top" style="background-color: #d9ba71 !important;">
           <img src="{{asset('img/login-img.png')}}" style="width:70px;height:70px;margin-right:10px;">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars navbar-toggler-icon"></i>
            </button>
            <div class="collapse navbar-collapse " id="navbarSupportedContent">
			 <div class="btn-group filter-dropdown">
            <button type="button" class="btn  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #eadaa8;margin-right:10px;">
             {{ __('header.Presence') }}
             </button>
  <div class="dropdown-menu">
 
         @if(auth()->user()->authority('view','attendance_departure')==1)
          <a href="{{url('check-in/index')}}"  class="dropdown-item">{{ __('header.Attendance_Departure') }}</a>
	     @endif
		 @if(auth()->user()->authority('view','attendance_list')==1 || auth()->user()->authority('view_only_employee_data','attendance_list')==1)
		  <a href="{{url('attendance/index')}}"  class="dropdown-item">{{ __('header.Attendance_List') }}</a>
	    @endif
	  @if(auth()->user()->authority('view','attendance_net_list')==1 || auth()->user()->authority('view_only_employee_data','attendance_net_list')==1)
		   <a href="{{url('attendance-net/index')}}"  class="dropdown-item">{{ __('header.Attendance_Net_List') }}</a>
	   @endif
	   @if(auth()->user()->authority('view','absence_list')==1 || auth()->user()->authority('view_only_employee_data','absence_list')==1)
		  <a href="{{url('absence/index')}}"  class="dropdown-item">{{ __('header.Absence_List') }}</a>
	  @endif
	  @if(auth()->user()->authority('view','official_holidays')==1)
		    <a href="{{url('vacations/index')}}" class="dropdown-item">{{ __('header.Official_Holidays') }}</a>
		@endif


  </div>
</div>
 <div class="btn-group filter-dropdown">
  <button type="button" class="btn  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #eadaa8;">
   {{ __('header.General_Settings') }}
  </button>
  <div class="dropdown-menu">
         @if(auth()->user()->authority('view','work_schedule_profiles')==1)
		  <a href="{{url('work/schedules/index')}}" class="dropdown-item">{{ __('header.Work_Schedule_Profiles') }}</a>
	  @endif
	  @if(auth()->user()->authority('view','overtime_profiles')==1)
		  <a href="{{url('overtime/profiles/index')}}" class="dropdown-item"> {{ __('header.Overtime_Profiles') }}</a>
	  @endif
	  @if(auth()->user()->authority('view','permission_types')==1)
		   <a href="{{url('permissions/index')}}"  class="dropdown-item">{{ __('header.Permission_Types') }}</a>
	   @endif
	   @if(auth()->user()->authority('view','leave_types')==1)
		   <a href="{{url('leaves/index')}}"  class="dropdown-item">{{ __('header.Leave_Types') }}</a>
	   @endif

  </div>
</div>
 <div class="btn-group filter-dropdown">
  <button type="button" class="btn  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #eadaa8;margin-left:10px;">
  {{ __('header.Application_Authorities') }}

  </button>
  <div class="dropdown-menu">
              @if(auth()->user()->authority('view','users')==1 || auth()->user()->authority('view_only_employee_data','users')==1)
               <a href="{{ url('users/index')}}"class="dropdown-item">{{ __('header.Users') }}</a>
		     @endif
		    @if(auth()->user()->authority('view','users_roles')==1)
			  <a href="{{ url('roles/index')}}"class="dropdown-item"> {{ __('header.Users_Roles') }}</a>
		   @endif
            


  </div>
</div>
 <div class="btn-group filter-dropdown">
  <button type="button" class="btn  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #eadaa8;margin-left:10px;">
  {{ __('header.Employees') }}
  </button>
  <div class="dropdown-menu">
              @if(auth()->user()->authority('view','employees')==1 || auth()->user()->authority('view_only_employee_data','employees')==1)
              <a href="{{url('employees/index')}}"  class="dropdown-item">{{ __('header.Employees') }}</a>
		  @endif
		      @if(auth()->user()->authority('view','assign_employee_permission')==1 || auth()->user()->authority('view_only_employee_data','assign_employee_permission')==1)
            <a href="{{url('employee/permissions/index')}}" class="dropdown-item"> {{ __('header.Assign_Employee_Permission') }}</a>
		@endif
		    @if(auth()->user()->authority('view','assign_employee_leave')==1 || auth()->user()->authority('view_only_employee_data','assign_employee_leave')==1)
            <a href="{{url('employee/leaves/index')}}" class="dropdown-item"> {{ __('header.Assign_Employee_Leave') }}</a>
		@endif
		    @if(auth()->user()->authority('view','employee_input_fields')==1)
			 <a href="{{url('input/fields/index')}}"  class="dropdown-item">{{ __('header.Employee_Input_Fields') }}</a>
		 @endif
		 @if(auth()->user()->authority('view','employees')==1 || auth()->user()->authority('view_only_employee_data','employees')==1)
              <a href="{{url('employees/salaries/index')}}"  class="dropdown-item">{{ __('header.employees_salaries') }}</a>
		  @endif
		  @if(auth()->user()->authority('view','employees')==1 || auth()->user()->authority('view_only_employee_data','employees')==1)
              <a href="{{url('employees/salaries/index')}}"  class="dropdown-item">{{ __('header.employees_salaries') }}</a>
		  @endif
		   @if(auth()->user()->authority('view','employees')==1 || auth()->user()->authority('view_only_employee_data','employees')==1)
              <a href="{{url('employee/solde/deduction/index')}}"  class="dropdown-item">{{ __('header.employees_solde_deduction') }}</a>
		  @endif


  </div>
</div>
                <div class="btn-group filter-dropdown">
                    <button type="button" class="btn  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #eadaa8;margin-left:10px;">
                        {{ __('header.Reports') }}
                    </button>
                    <div class="dropdown-menu">
					@if(auth()->user()->authority('view','reports')==1)
                        <a href="{{url('reports/generate')}}" class="dropdown-item">{{ __('header.Generate_Reports') }}</a>
					@endif
					@if(auth()->user()->authority('view','salary_report')==1)
						 <a href="{{url('reports/salary/report')}}" class="dropdown-item">{{ __('header.Salary_Report') }}</a>
					 @endif
					
						 <a href="{{url('reports/saved')}}" class="dropdown-item">{{ __('header.Saved_Report') }}</a>
					 

                    </div>
                </div>
 <div class="btn-group filter-dropdown">
  <button type="button" class="btn  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #eadaa8;margin-left:10px;">
  {{ __('header.Tools') }}

  </button>
  <div class="dropdown-menu">
  @if(auth()->user()->authority('view','backup')==1)
              <a   href=""class="dropdown-item">{{ __('header.Backup') }}</a>
		  @endif
		   <a  href="{{url('admin/log-reader')}}" class="dropdown-item">{{ __('header.logs_reader') }}</a>


  </div>
</div>


                <ul class="navbar-nav ml-auto navbar-right-top">
                    <li class="nav-item dropdown ">
                        <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('img/user.png')}}" alt="" class="user-avatar-md rounded-circle" style="width:40px;height:40px;"></a>
                        <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">

                      {{--  <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i>{{ __('header.Profile') }}</a> --}}

                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">

                             <i class="fas fa-power-off mr-2"></i>{{ __('header.Logout') }}</a>
                             <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                 @csrf
                             </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- ============================================================== -->
    <!-- end navbar -->
    <!-- ============================================================== -->
