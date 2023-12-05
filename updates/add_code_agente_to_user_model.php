<?php Namespace Tecnotrade\Mallextraadmin\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddCodeAgenteToUserModel extends Migration
{
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('code_agente')->nullable();

        });
    }

    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('code_agente');
            

        });
    }
}

