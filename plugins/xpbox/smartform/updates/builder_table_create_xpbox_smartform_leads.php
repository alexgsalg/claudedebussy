<?php namespace Xpbox\Smartform\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateXpboxSmartformLeads extends Migration
{
    public function up()
    {
        Schema::create('xpbox_smartform_leads', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('form_id')->unsigned();
            $table->text('data');
            $table->foreign('form_id')->references('id')->on('xpbox_smartform_form');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::table('xpbox_smartform_leads', function($table)
        {
             $table->dropForeign(['form_id']);
         });
         
        Schema::dropIfExists('xpbox_smartform_leads');
    }
}
