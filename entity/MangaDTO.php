<?php
class MangaDTO {
    public readonly Manga $manga;
    public readonly string $author;

    public function __construct(Manga $manga, string $author) {
        $this->manga = $manga;
        $this->author = $author;
    }   
}