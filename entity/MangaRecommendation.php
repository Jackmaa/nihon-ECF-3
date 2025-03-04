<?php
class MangaRecommendation {
    public readonly Manga $manga;
    public readonly string $message;

    public function __construct(Manga $manga, string $message) {
        $this->manga   = $manga;
        $this->message = $message;
    }
}