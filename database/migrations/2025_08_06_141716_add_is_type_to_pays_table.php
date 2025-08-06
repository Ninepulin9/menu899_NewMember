<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsTypeToPaysTable extends Migration
{
    public function up()
    {
        Schema::table('pays', function (Blueprint $table) {
            $table->tinyInteger('is_type')->default(0)->comment('0=เงินสด, 1=โอนเงิน')->after('total');
            $table->decimal('received_amount', 10, 2)->nullable()->comment('จำนวนเงินที่รับมา')->after('is_type');
            $table->decimal('change_amount', 10, 2)->nullable()->comment('เงินทอน')->after('received_amount');
        });
    }

    public function down()
    {
        Schema::table('pays', function (Blueprint $table) {
            $table->dropColumn(['is_type', 'received_amount', 'change_amount']);
        });
    }
}