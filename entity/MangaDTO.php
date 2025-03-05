<?php
class MangaDTO {
    public readonly Manga $manga;
    public readonly string $author;
    public readonly string $categories;

    public function __construct(Manga $manga, string $author, string $categories) {
        $this->manga = $manga;
        $this->author = $author;
        $this->categories = $categories;
    }   
}