<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function(Blueprint $table) {
          $table->increments('id');
          $table->string('title');
          $table->text('content');
          $table->string('slug');
          $table->string('path');
          $table->string('view');
          $table->string('layout');
          $table->string('status');
          $table->integer('forward_to');

          $table->integer('parent_id')->nullable();
          $table->integer('lft')->nullable();
          $table->integer('rgt')->nullable();
          $table->integer('depth')->nullable();

          $table->timestamps();

          // Default indexes
          // Add indexes on parent_id, lft, rgt columns by default. Of course,
          // the correct ones will depend on the application and use case.
          $table->index('path');
          $table->index('parent_id');
          $table->index('lft');
          $table->index('rgt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pages');
    }

}
