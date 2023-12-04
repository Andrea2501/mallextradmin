<?php Namespace Tecnotrade\Mallfornitori\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddBackendUserCodeToProduct extends Migration
{
    public function up()
    {
        Schema::table('offline_mall_products', function ($table) {
            $table->string('owner_code')->nullable();

        });
    }

    public function down()
    {
        Schema::table('offline_mall_products', function ($table) {
            $table->dropColumn('owner_code');
            

        });
    }
}

