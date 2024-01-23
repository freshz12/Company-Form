<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FormFiles extends Migration
{
    public function up()
    {
        Schema::create('form_files', function (Blueprint $table) {
            $table->id();
            $table->string('form_id');
            $table->string('company_profile');
            $table->string('product_brochure');
            $table->string('other_relevant_file')->nullable();
            $table->string('updated_by');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('form_files');
    }
}