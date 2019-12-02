<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageFieldToGamesHighscoresView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('games_highscores_view', function (Blueprint $table) {
            DB::statement("DROP VIEW IF EXISTS sort_games_by_scores");
        
        DB::statement("
        CREATE VIEW sort_games_by_scores AS SELECT DISTINCT
        g.id, g.title, g.body, g.image, g.created_at, g.updated_at, Count(h.game_id) AS scoreCount
        FROM games g JOIN highscores h
        ON g.id = h.game_id
        GROUP BY g.title
        UNION
        SELECT DISTINCT
        g2.id, g2.title, g2.body, g2.image, g2.created_at, g2.updated_at, Count(h2.game_id) AS scoreCount
        FROM games g2 LEFT JOIN highscores h2
        ON g2.id = h2.game_id
        WHERE h2.game_id IS NULL
        GROUP BY g2.title
        ORDER BY scoreCount DESC;");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('games_highscores_view', function (Blueprint $table) {
            //
        });
    }
}
