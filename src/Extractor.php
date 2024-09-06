<?php
// src/Extractor.php

class Extractor {
    public static function extractLinks($content) {
        $pattern = '/<img[^>]+src=["\']([^"\']+)["\']/i';
        preg_match_all($pattern, $content, $matches);
        return $matches[1];  // Links de imagens
    }
}
