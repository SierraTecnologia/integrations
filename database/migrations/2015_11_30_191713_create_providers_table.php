<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'providers', function (Blueprint $table) {

                // Set the storage engine and primary key
                $table->engine = 'InnoDB';
                $table->increments('id');

                // Ordinary columns
                $table->string('name')->unique();
                $table->string('slug')->unique();
                $table->unsignedInteger('login_count')->default(0);

                // Automatic columns
                $table->timestamps();
                $table->softDeletes();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('providers');
    }
}
