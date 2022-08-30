$("#code").change(function(){
            $.ajax({
                url: "../public/check-in/get_employee?code=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#employee_data').html(data.html);
                }
            });
        });
		$("#check-out-code").change(function(){
            $.ajax({
                url: "../public/check-out/get_employee?code=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#employee_data').html(data.html);
                }
            });
        });
		/********** report  section ****/
		function getTableColumns(table_name) {
            document.getElementById("columns-card").style.display = "block";
            document.getElementById("filter-card").style.display = "block";
            document.getElementById('runQuery').style.display = "block";


            $('#table_name').text(table_name);
            $.ajax({
                url: "../public/reports/getTableColumns?table_name=" + table_name,
                method: 'GET',
                success: function (data) {
                    $('#table_coulmns').html(data.columns);
                    $('#filter_column').html(data.filters);
                    $('#filter_column_1').html(data.filters);
                    $('#filter_column_2').html(data.filters);
                    $('#filter_column_3').html(data.filters);
                    $('#filter_column_4').html(data.filters);
                    $('#filter_column_5').html(data.filters);
                }
            });
        }
function InputType() {
    var column_name = document.getElementById("filter_column").value;
    $.ajax({
        url: "../public/reports/getFilterInput?column_name=" + column_name,
        method: 'GET',
        success: function (data) {
            $('#filter_input').html(data.input);
        }
    });
}
function getInputType(i){
    var column_name = document.getElementById("filter_column_"+i).value;
    $.ajax({
        url: "../public/reports/getFilterInput?column_name=" + column_name,
        method: 'GET',
        success: function(data) {
            $("#filter_input_"+i).html(data.input);
        }
    });
}

		function clone(i){
            document.getElementById("filters_"+i).style.visibility = "visible";
        }
function remove(i){
    document.getElementById("filters_"+i).remove();
}

/******************************************************************************/
		/**** delete image*****/
		$(document).ready(function() {

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
       var employee_id = $('#employee_id').val();
        $('#skipQuestion').on('click', function(e){
            e.preventDefault();

            $.ajax({
                method: "GET",
                url: "../public/employees/delete_image/" + employee_id,
                success: function (response) {
                    location.reload();
                },
                error:function(error){
                    console.log(error);
                }
            });
        });

    });
/******* salary report search result *****/
let month_number = '';

function search_date() {
  search_date = document.getElementById("search_date").value;
}
function getSalaryReport(){
	  search_date();
     employee_id = $("#EmployeeID :selected").val();
	
    $.ajax({
        url: "../public/reports/getSalaryReport?search_date="+search_date+"&employee_id="+employee_id,
        method: 'GET',
        success: function(data) {
            $("#salary_result").html(data.salary);
        }
    });
}