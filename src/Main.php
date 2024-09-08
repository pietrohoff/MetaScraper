<?php
require_once 'Extractor.php';

class Main {
    private static $visitedLinks = [];  // Links já visitados
    private static $foundLinks = [];    // Links encontrados (subdomínios e pastas)

    public static function execute($url) {
        // Verifica se o link já foi visitado
        if (in_array($url, self::$visitedLinks)) {
            return;
        }

        // Adiciona o link à lista de visitados
        self::$visitedLinks[] = $url;

        // Baixa o conteúdo da URL fornecida
        $content = @file_get_contents($url);
        if (!$content) {
            echo "Não foi possível acessar o conteúdo da URL: $url\n";
            return;
        }

        // Extrai links de páginas internas e subdomínios
        $pageLinks = Extractor::extractPageLinks($content, $url);   // Usando extractPageLinks() para pastas
        $subdomainLinks = Extractor::extractSubdomains($content, $url); // Usando extractSubdomains() para subdomínios

        // Armazena links únicos de subdomínios e pastas
        foreach ($pageLinks as $link) {
            if (!in_array($link, self::$foundLinks)) {
                self::$foundLinks[] = $link;
            }
        }

        foreach ($subdomainLinks as $subdomain) {
            if (!in_array($subdomain, self::$foundLinks)) {
                self::$foundLinks[] = $subdomain;
            }
        }

        // Recursivamente explora as páginas
        foreach ($pageLinks as $pageLink) {
            self::execute($pageLink);
        }
    }

    // Mostra o resultado final de todos os links encontrados
    public static function showResults() {
        echo "Links encontrados (subdomínios e pastas):\n";
        foreach (self::$foundLinks as $link) {
            echo $link . "\n";
        }
    }
}
