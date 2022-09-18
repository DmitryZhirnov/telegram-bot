<?php

use Phinx\Migration\AbstractMigration;

class InsertSwearingWords extends AbstractMigration
{
    public function up(): void
    {
        $words = file_get_contents(__DIR__ . "/../data/swearwords.txt");
        $words = explode(PHP_EOL, $words);
        foreach ($words as $word) {
            $this->table('swearing_words')
                ->insert(
                    [
                        'word' => $word
                    ]
                )->save();
        }

    }

    public function down(): void
    {
        $this->table('swearing_words')->truncate();
    }
}
