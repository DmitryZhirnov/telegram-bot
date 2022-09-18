<?php

namespace App\Domain\SwearingWord;

use Illuminate\Database\Eloquent\Model;

class SwearingWord extends Model implements \JsonSerializable
{
    protected $table = 'swearing_words';
    protected $fillable = ['word'];
    private int $id;
    private string $word;

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'word' => $this->word,
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getWord(): string
    {
        return $this->word;
    }

    /**
     * @param string $word
     */
    public function setWord(string $word): void
    {
        $this->word = $word;
    }
}