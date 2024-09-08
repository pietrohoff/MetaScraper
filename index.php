<?php
// index.php

require_once 'src/Download.php';
require_once 'src/Extractor.php';
require_once 'src/MetaDataAnalyzer.php';

// Solicita ao usuário a URL no terminal
echo "Digite a URL do site: ";
$url = trim(fgets(STDIN)); // Lê a entrada do usuário no terminal

// Verifica se a URL é válida
if (filter_var($url, FILTER_VALIDATE_URL) === false) {
    die("A URL fornecida não é válida. Tente novamente.\n");
}

$saveDirectory = __DIR__ . '/downloads/';

// Baixa o conteúdo da URL fornecida
$content = Download::downloadContent($url);

if (!$content) {
    die("Não foi possível baixar o conteúdo da URL.\n");
}

// Extrai os links de subdomínios e páginas internas
$pageLinks = Extractor::extractPageLinks($content, $url);   // Usando extractPageLinks para páginas internas
$subdomainLinks = Extractor::extractSubdomains($content, $url); // Usando extractSubdomains para subdomínios

// Exibe os links de páginas internas
echo "Páginas internas encontradas:\n";
foreach ($pageLinks as $link) {
    echo $link . "\n";
}

// Exibe os subdomínios
echo "\nSubdomínios encontrados:\n";
foreach ($subdomainLinks as $subdomain) {
    echo $subdomain . "\n";
}

// Função para baixar todas as imagens de uma página e analisar metadados
function downloadAndAnalyzeImagesFromPage($pageUrl, $saveDirectory) {
    // Baixar o conteúdo da página
    $content = Download::downloadContent($pageUrl);

    if (!$content) {
        echo "Não foi possível baixar o conteúdo da página: $pageUrl\n";
        return;
    }

    // Extrair as URLs das imagens da página
    $imageLinks = Extractor::extractImageLinks($content, $pageUrl);

    // Baixar cada imagem encontrada e analisar metadados
    foreach ($imageLinks as $imageLink) {
        $imageName = basename($imageLink);  // Extrai o nome do arquivo de imagem
        $savePath = $saveDirectory . $imageName;

        // Baixa o arquivo da imagem
        echo "Baixando imagem: $imageName de $pageUrl\n";
        Download::downloadFile($imageLink, $savePath);

        // Analisa os metadados
        echo "Analisando metadados de $imageName...\n";
        $metaData = MetaDataAnalyzer::analyzeMetaData($savePath);

        // Exibe os metadados
        print_r($metaData);
        echo "\n";
    }
}

// Baixar e analisar todas as imagens de cada página interna
foreach ($pageLinks as $pageLink) {
    downloadAndAnalyzeImagesFromPage($pageLink, $saveDirectory);
}
