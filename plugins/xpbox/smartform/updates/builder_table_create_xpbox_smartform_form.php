<?php namespace Xpbox\Smartform\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateXpboxSmartformForm extends Migration
{
    public function up()
    {
        Schema::create('xpbox_smartform_form', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('subject');
            $table->string('from');
            $table->string('to');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('xpbox_smartform_form');
    }
}
