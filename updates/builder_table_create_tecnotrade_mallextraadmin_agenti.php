<?php namespace Tecnotrade\Mallextraadmin\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTecnotradeMallextraadminAgenti extends Migration
{
    public function up()
    {
        Schema::create('tecnotrade_mallextraadmin_agenti', function($table)
        {
            $table->increments('id')->unsigned();
            $table->string('cognome')->nullable();
            $table->string('nome')->nullable();
            $table->string('email')->nullable();
            $table->text('indirizzo')->nullable();
            $table->string('codice_agente')->nullable();
            $table->string('password')->nullable();
            $table->string('mobile')->nullable();
            $table->string('telefono_2')->nullable();
            $table->text('note')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tecnotrade_mallextraadmin_agenti');
    }
}
