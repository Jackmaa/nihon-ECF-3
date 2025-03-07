<?php
class MangaDTO {
    public readonly Manga $manga;
    public readonly string $author;
    public readonly string $categories;
    public readonly string $editor;

    public function __construct(Manga $manga, string $author, string $categories, string $editor) {
        $this->manga = $manga;
        $this->author = $author;
        $this->categories = $categories;
        $this->editor = $editor;
    }   
}