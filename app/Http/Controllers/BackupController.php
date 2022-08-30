<?php

namespace App\Http\Controllers;
use Symfony\Component\Process\Process;
class BackupController extends Controller
{

  public function getBackup()
    {
		/*("attendances","attendance-net","absences","employees","employee_input_fields","employee_leaves","employee_permissions",
		                             "leaves","over_time_profiles","pages","permissions","roles","role_authorities","saved_reports","users","vacations","work_schedule_profiles"); //here your tables...
*/

       $filename = 'database_backup_on_' . date('Y-m-d') . '.sql';


      $process = new Process(sprintf(
          'mysqldump -u%s -p%s %s > %s',
          config('database.connections.mysql.username'),
          config('database.connections.mysql.password'),
          config('database.connections.mysql.database'),
          storage_path('backups/backup.sql')
      ));
      $process->mustRun();
	 
   }


}
