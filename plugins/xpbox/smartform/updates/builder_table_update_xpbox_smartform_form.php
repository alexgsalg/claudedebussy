<?php namespace Xpbox\Smartform\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateXpboxSmartformForm extends Migration
{
    public function up()
    {
        Schema::table('xpbox_smartform_form', function($table)
        {
            $table->text('message');
        });
    }
    
    public function down()
    {
        Schema::table('xpbox_smartform_form', function($table)
        {
            $table->dropColumn('message');
        });
    }
}
