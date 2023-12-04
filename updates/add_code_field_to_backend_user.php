<?php Namespace Tecnotrade\Mallfornitori\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddCodeFieldToBackendUser extends Migration
{
    public function up()
    {
        Schema::table('backend_users', function ($table) {
            $table->string('internal_code',50)->nullable()->unique();

        });
    }

    public function down()
    {
        Schema::table('backend_users', function ($table) {
            $table->dropColumn('internal_code');
            

        });
    }
}

