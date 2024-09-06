<?php
// src/Main.php
require_once 'Download.php';
require_once 'Extractor.php';
require_once 'MetaDataAnalyzer.php';

class Main {
    public static function execute($url) {
        $saveDirectory = __DIR__ . '/../downloads/';

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

            // Verifica se o arquivo baixado está vazio
            if (filesize($savePath) === 0) {
                echo "O arquivo $fileName está vazio. Excluindo...\n";
                unlink($savePath);  // Deleta o arquivo vazio
                continue;
            }

            // Analisa os metadados
            $metaData = MetaDataAnalyzer::analyzeMetaData($savePath);

            // Se o arquivo não tiver metadados relevantes, exclui o arquivo
            if (empty($metaData) || $metaData === "Nenhum dado EXIF encontrado.") {
                echo "O arquivo $fileName não possui metadados relevantes. Excluindo...\n";
                unlink($savePath);  // Deleta o arquivo sem metadados
                continue;
            }

            // Exibe os metadados apenas dos arquivos que têm algum dado
            echo "Metadados do arquivo $fileName:\n";
            print_r($metaData);
            echo "\n";
        }
    }
}
