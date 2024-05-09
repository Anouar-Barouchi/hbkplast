<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Slider\Entities\MobileSlider;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_sliders', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Mobile Slider');
            $table->timestamps();
        });

        $m = new MobileSlider;
        $m->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mobile_sliders');
    }
};
