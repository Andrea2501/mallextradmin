<?php namespace Tecnotrade\Mallextraadmin\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTecnotradeMallextraadminAgenti extends Migration
{
    public function up()
    {
        Schema::table('tecnotrade_mallextraadmin_agenti', function($table)
        {
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('tecnotrade_mallextraadmin_agenti', function($table)
        {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
    }
}
