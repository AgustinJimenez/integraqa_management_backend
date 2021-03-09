<?php

use App\Models\{ActivityType, BudgetRequest, BudgetRequestCompanyActivityType};
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetRequestsCompanyActivityTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new BudgetRequestCompanyActivityType)->getTable(), function (Blueprint $table) {
            $table->id();
            
            $table->integer('activity_type_id')->unsigned()->index();
            $table->foreign('activity_type_id')->references('id')->on( (new ActivityType())->getTable() )->onDelete('cascade');

            $table->integer('budget_request_id')->unsigned()->index();
            $table->foreign('budget_request_id')->references('id')->on( (new BudgetRequest())->getTable() )->onDelete('cascade');

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
        Schema::dropIfExists((new BudgetRequestCompanyActivityType)->getTable());
    }
}
