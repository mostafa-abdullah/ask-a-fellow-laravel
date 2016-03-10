<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VotesAndTriggers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->integer('votes');
        });


        DB::unprepared('
        CREATE TRIGGER UpdateQuestionVotesIn AFTER INSERT ON `question_votes` FOR EACH ROW
        BEGIN
         UPDATE questions SET votes = ((SELECT COUNT(*) FROM question_votes WHERE question_id = NEW.question_id AND type = 0)
         - (SELECT COUNT(*) FROM question_votes WHERE question_id = NEW.question_id AND type = 1)) WHERE id = NEW.question_id;
        END
        ');

        DB::unprepared('
        CREATE TRIGGER UpdateQuestionVotesDel AFTER DELETE ON `question_votes` FOR EACH ROW
        BEGIN
         UPDATE questions SET votes = ((SELECT COUNT(*) FROM question_votes WHERE question_id = OLD.question_id AND type = 0)
         - (SELECT COUNT(*) FROM question_votes WHERE question_id = OLD.question_id AND type = 1)) WHERE id = OLD.question_id;
        END
        ');


        Schema::table('answers', function (Blueprint $table) {
            $table->integer('votes');
        });


        DB::unprepared('
        CREATE TRIGGER UpdateAnswerVotesIn AFTER INSERT ON `answer_votes` FOR EACH ROW
        BEGIN
         UPDATE answers SET votes = ((SELECT COUNT(*) FROM answer_votes WHERE answer_id = NEW.answer_id AND type = 0)
         - (SELECT COUNT(*) FROM answer_votes WHERE answer_id = NEW.answer_id AND type = 1)) WHERE id = NEW.answer_id;
        END
        ');

        DB::unprepared('
        CREATE TRIGGER UpdateAnswerVotesDel AFTER DELETE ON `answer_votes` FOR EACH ROW
        BEGIN
         UPDATE answers SET votes = ((SELECT COUNT(*) FROM answer_votes WHERE answer_id = OLD.answer_id AND type = 0)
         - (SELECT COUNT(*) FROM answer_votes WHERE answer_id = OLD.answer_id AND type = 1)) WHERE id = OLD.answer_id;
        END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER UpdateQuestionVotesIn');
        DB::unprepared('DROP TRIGGER UpdateQuestionVotesDel');
        DB::unprepared('DROP TRIGGER UpdateAnswerVotesIn');
        DB::unprepared('DROP TRIGGER UpdateAnswerVotesDel');
    }
}
