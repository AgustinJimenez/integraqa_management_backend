<?php

use App\Models\{User, Company};
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\UserCompany;

class CreateUserCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new UserCompany)->getTable(), function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on( (new User)->getTable() )->onDelete('cascade');

            $table->integer('company_id')->unsigned()->index();
            $table->foreign('company_id')->references('id')->on( (new Company())->getTable() )->onDelete('cascade');

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
        Schema::dropIfExists((new UserCompany)->getTable());
    }
}
