<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmailRepliesProfileFlag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('allow_replies')->after('remember_token')->default(false);
            $table->char('unsubscribe_replies_token', 32)->after('allow_replies')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('allow_replies');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('unsubscribe_replies_token');
        });
    }
}
