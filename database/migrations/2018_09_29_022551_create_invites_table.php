<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invites', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('event_id')->nullable();
            $table
                ->foreign('event_id')
                ->references('id')
                ->on('events');
            $table->unsignedInteger('sent_by')->nullable();
            $table
                ->foreign('sent_by')
                ->references('id')
                ->on('users');
            $table->unsignedInteger('recipient_email')->nullable();
            $table->unsignedInteger('accepted_by')->nullable();
            $table
                ->foreign('accepted_by')
                ->references('id')
                ->on('users');
            $table->index(['event_id', 'invite_from', 'invite_to'], 'invites_indexes');
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
        Schema::dropIfExists('invites');
    }
}
