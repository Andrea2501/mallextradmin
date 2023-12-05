<?php Namespace Tecnotrade\Mallextraadmin\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddPiECfToUsers extends Migration
{
    public function up()
    {
        Schema::table('users', function ($table) {
                        
            $table->string('partitaiva')->nullable();
            $table->string('codicefiscale')->nullable();
            
        });
    }

    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('partitaiva');
            $table->dropColumn('codicefiscale');
            
        });
    }
}