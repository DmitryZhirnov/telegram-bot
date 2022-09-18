<?php


use Illuminate\Database\Schema\Blueprint;
use Phinx\Migration\AbstractMigration;
use Illuminate\Database\Capsule\Manager as Capsule;

class CreateSwearingWordsTable extends AbstractMigration
{
    public function up(): void
    {
        Capsule::schema()->create('swearing_words', function (Blueprint $table) {
            $table->id();
            $table->string('word');
        });
    }

    public function down(): void
    {
        $this->table('swearing_words')->drop();
    }

}