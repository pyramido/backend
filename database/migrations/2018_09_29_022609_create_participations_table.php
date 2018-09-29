<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->unsignedInteger('event_id')->nullable();
            $table
                ->foreign('event_id')
                ->references('id')
                ->on('events');
            $table->unsignedInteger('invite_id')->nullable();
            $table
                ->foreign('invite_id')
                ->references('id')
                ->on('invites');
            $table->unsignedInteger('reward_id')->nullable();
            $table
                ->foreign('reward_id')
                ->references('id')
                ->on('rewards');
            $table->index(
                ['user_id', 'event_id', 'invite_id', 'reward_id'],
                'participations_indexes'
            );
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
        Schema::dropIfExists('participations');
    }
}
