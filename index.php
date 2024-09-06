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

// Extrai os links das imagens
$links = Extractor::extractLinks($content);

if (empty($links)) {
    die("Nenhuma imagem encontrada no conteúdo da URL.\n");
}

// Processa cada link de imagem
foreach ($links as $link) {
    $fileName = basename($link);  // Extrai o nome do arquivo
    $savePath = $saveDirectory . $fileName;

    // Baixa o arquivo
    echo "Baixando: $fileName\n";
    Download::downloadFile($link, $savePath);

    // Analisa os metadados
    echo "Analisando metadados de $fileName...\n";
    $metaData = MetaDataAnalyzer::analyzeMetaData($savePath);

    // Exibe os metadados
    print_r($metaData);
    echo "\n";
}
