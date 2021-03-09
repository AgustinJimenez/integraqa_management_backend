<?php

use App\Models\VerificationToken;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerificationTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( (new VerificationToken)->getTable() , function (Blueprint $table) {
            $table->id();
            $table->string('value', 30);
            $table->string('type', 30);
            $table->dateTime('deadline');

            $table->integer('entity_id');
            $table->string('entity_type', 90);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( (new VerificationToken)->getTable() );
    }
}
