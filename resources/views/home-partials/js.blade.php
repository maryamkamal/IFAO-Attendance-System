

<!-- scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://code.jquery.com/jquery-3.5.1.js"></script> 
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>  
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<!--<script type="text/javascript" src="DataTables/datatables.min.js"></script> -->
<script src="js/helpers-js/popper.min.js"></script>
<script src="js/helpers-js/bootstrap.min.js"></script>
<script src="js/helpers-js/fontawesome.js"></script>
<!-- nice scroll -->
<script src="js/helpers-js/nice-scroll.js"></script>
<!-- wow.js -->
<script src="js/helpers-js/WOW.js"></script>
<script src="js/helpers-js/wow.min.js"></script>
<script src="js/helpers-js/wow-scroll-animation.js"></script>

<!-- datatables js -->
<script src="js/custom-js/users-datatables.js"></script>
<script src="js/custom-js/employees-datatables.js"></script>
<script src="js/custom-js/employee-salary-history-datatables.js"></script>
<script src="js/custom-js/attendance-datatables.js"></script>
<script src="js/custom-js/attendance-net-datatables.js"></script>
<script src="js/custom-js/absence-datatables.js"></script>
<script src="js/custom-js/overtime-profile-datatables.js"></script>
<script src="js/custom-js/vacations-datatables.js"></script>
<script src="js/custom-js/work-profile-datatables.js"></script>
<script src="js/custom-js/permissions-datatables.js"></script>
<script src="js/custom-js/leaves-datatables.js"></script>
<script src="js/custom-js/employees-permissions-datatables.js"></script>
<script src="js/custom-js/employees-solde-deductions-datatables.js"></script>
<script src="js/custom-js/employees-leaves-datatables.js"></script>
<script src="js/custom-js/ajax.js"></script>
<script src="js/helpers-js/nice-scroll.js"></script>

<script src="js/custom-js/main-js.js"></script>
<script src="js/custom-js/home.js"></script>
<script src="js/helpers-js/clock.js"></script>


<!-- Select2 JS --> 
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
$(".filter-dropdown").on("click", ".dropdown-toggle", function(e) { 
    e.preventDefault();
    $(this).parent().addClass("show");
    $(this).attr("aria-expanded", "true");
    $(this).next().addClass("show"); 
  });
  $(document).ready(function(){
 
  // Initialize select2
  $("#selEmployee").select2();

});
</script>