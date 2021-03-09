<?php

use App\Models\{User, BudgetRequest};
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        /*  
        - Solicitud o Certificación de productos orgánicos según UE 834/2007					
        - SOLICITUD DE CERTIFICADO Y PPA PARA EMPRESAS DE PRODUCCIÓN VEGETAL Y PECUARIAS				
		- SOLICITUD DE CERTIFICADO PROCESADORAS Y COMERCIALIZADORAS				
		- FORMATO DE SOLICITUD PARA LA CERTIFICACIÓN NOP USDA PARA PRODUCTORES									
		- FORMATO DE SOLICITUD PARA LA CERTIFICACIÓN NOP USDA PARA EMPRESAS DE TRANSFORMACIÓN					
        - SOLICITUD PARA CERTIFICACIÓN JAS					
		- SOLICITUD PARA CERTIFICACIÓN JAS (Referente a Productos Agrícolas y Piensos Orgánicos)
		- SOLICITUD PARA CERTIFICACIÓN JAS (Referente a Alimentos Procesados y Piensos Orgánicos)
        - PLAN ANUAL DE PRODUCCIÓN PARA JAS						

        */

        Schema::create((new BudgetRequest)->getTable(), function (Blueprint $table) {
            $table->id();
            
            $table->string('company_name', 150);
            $table->string('company_address', 150);
            $table->text('company_others_addresses');
            $table->string('company_utr', 12)->comment('Unique Taxpayer Reference');
            $table->string('contact');
            $table->string('email', 60);
            $table->string('telephone', 15);

            $table->text('company_conventional_activity_description');
            $table->string('property_ubication', 30);
            $table->boolean('ground_analysis');
            $table->string('water_test_file', 120);
            $table->float('land_area', 9, 5)->nullable();

            $table->text('company_organic_activity_description');

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
        Schema::dropIfExists((new BudgetRequest)->getTable());
    }
}
