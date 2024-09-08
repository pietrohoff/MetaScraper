<?php
// src/Extractor.php

class Extractor {
    // Extrair links de páginas internas
    public static function extractPageLinks($content, $baseUrl) {
        $pattern = '/<a[^>]+href=["\']([^"\']+)["\']/i';  // Regex para capturar links
        preg_match_all($pattern, $content, $matches);

        $links = array_filter($matches[1]);  // Todos os links capturados
        $pageLinks = [];

        // Verifica e converte links relativos em absolutos
        foreach ($links as $link) {
            // Remove âncoras (parte do link após "#")
            $link = strtok($link, '#');

            // Se o link é relativo, converte para absoluto
            if (!filter_var($link, FILTER_VALIDATE_URL)) {
                $link = rtrim($baseUrl, '/') . '/' . ltrim($link, '/');
            }

            // Verifica se pertence ao mesmo domínio base
            $baseHost = parse_url($baseUrl, PHP_URL_HOST);
            $linkHost = parse_url($link, PHP_URL_HOST);

            if ($linkHost === $baseHost) {
                $pageLinks[] = $link;
            }
        }

        return array_unique($pageLinks);  // Remove duplicatas
    }

    // Extrair subdomínios do conteúdo
    public static function extractSubdomains($content, $baseUrl) {
        $pattern = '/<a[^>]+href=["\'](https?:\/\/([^"\']+))["\']/i';  // Regex para capturar links
        preg_match_all($pattern, $content, $matches);

        $links = array_filter($matches[1]);  // Todos os links capturados
        $subdomainLinks = [];
        $baseHost = parse_url($baseUrl, PHP_URL_HOST);

        foreach ($links as $link) {
            $linkHost = parse_url($link, PHP_URL_HOST);

            // Verifica se o link é um subdomínio do domínio base
            if ($linkHost !== $baseHost && strpos($linkHost, $baseHost) !== false) {
                $subdomainLinks[] = $link;
            }
        }

        return array_unique($subdomainLinks);  // Remove duplicatas
    }

    // Extrair links de imagens da página
    public static function extractImageLinks($content, $baseUrl) {
        // Regex para encontrar URLs de imagens (img src)
        $pattern = '/<img[^>]+src=["\']([^"\']+)["\']/i';
        preg_match_all($pattern, $content, $matches);

        $imageLinks = array_filter($matches[1]);  // Links de imagens

        // Converter links relativos para absolutos
        $absoluteLinks = array_map(function($link) use ($baseUrl) {
            return self::makeAbsoluteUrl($baseUrl, $link);
        }, $imageLinks);

        return array_unique($absoluteLinks);  // Remove duplicatas
    }

    // Função auxiliar para transformar links relativos em absolutos
    private static function makeAbsoluteUrl($baseUrl, $relativeUrl) {
        // Se já é um URL absoluto, retorna-o
        if (filter_var($relativeUrl, FILTER_VALIDATE_URL)) {
            return $relativeUrl;
        }

        // Converte links relativos para absolutos
        return rtrim($baseUrl, '/') . '/' . ltrim($relativeUrl, '/');
    }
}
