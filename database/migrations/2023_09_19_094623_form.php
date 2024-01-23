<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Form extends Migration
{
    public function up()
    {
        Schema::create('form', function (Blueprint $table) {
            $table->id();
            $table->string('form_id')->unique()->after('id');
            $table->string('company_name', 100);
            $table->string('company_hq_office_address');
            $table->string('company_website');
            $table->string('company_country_of_origin');
            $table->integer('year_of_establishment');
            $table->string('contact_name');
            $table->string('contact_designation');
            $table->string('contact_email_address');
            $table->string('contact_phone_number');
            $table->string('type_of_products');
            $table->string('care_segment');
            $table->string('main_products');
            $table->string('presence_of_distributor');
            $table->string('country_of_interest_for_distribution');
            $table->string('potential_relationship')->nullable();
            $table->string('potential_service_offered_by_ids')->nullable();
            $table->string('other_potential_relationship')->nullable();
            $table->string('other_potential_service_offered_by_ids')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('form');
    }
}
