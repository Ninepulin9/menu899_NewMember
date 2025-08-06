<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingColumnsToPaysTable extends Migration
{
    public function up()
    {
        Schema::table('pays', function (Blueprint $table) {
            if (!Schema::hasColumn('pays', 'is_type')) {
                $table->tinyInteger('is_type')->default(0)->comment('0=เงินสด, 1=โอนเงิน');
            }
            
            if (!Schema::hasColumn('pays', 'change_amount')) {
                $table->decimal('change_amount', 10, 2)->nullable()->comment('เงินทอน');
            }
        });
    }

    public function down()
    {
        Schema::table('pays', function (Blueprint $table) {
            if (Schema::hasColumn('pays', 'is_type')) {
                $table->dropColumn('is_type');
            }
            if (Schema::hasColumn('pays', 'change_amount')) {
                $table->dropColumn('change_amount');
            }
        });
    }
}