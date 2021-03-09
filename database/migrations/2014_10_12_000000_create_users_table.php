<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( (new User)->getTable() , function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('email', 90)->unique();
            $table->string('image', 160)->nullable();
            $table->string('utr', 12)->nullable()->comment('Unique Taxpayer Reference');
            $table->string('password');
            $table->boolean('enabled')->default(false);
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists( (new User)->getTable() );
    }
}
