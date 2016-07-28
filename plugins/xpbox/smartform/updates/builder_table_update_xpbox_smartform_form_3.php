<?php namespace Xpbox\Smartform\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateXpboxSmartformForm3 extends Migration
{
    public function up()
    {
        Schema::table('xpbox_smartform_form', function($table)
        {
            $table->text('slug');
        });
    }
    
    public function down()
    {
        Schema::table('xpbox_smartform_form', function($table)
        {
            $table->dropColumn('slug');
        });
    }
}
