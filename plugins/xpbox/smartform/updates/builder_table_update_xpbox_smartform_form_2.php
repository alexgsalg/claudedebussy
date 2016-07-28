<?php namespace Xpbox\Smartform\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateXpboxSmartformForm2 extends Migration
{
    public function up()
    {
        Schema::table('xpbox_smartform_form', function($table)
        {
            $table->string('from')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('xpbox_smartform_form', function($table)
        {
            $table->string('from', 255)->nullable(false)->change();
        });
    }
}
