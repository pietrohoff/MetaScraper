<?php
// src/MetaDataAnalyzer.php

class MetaDataAnalyzer {
    // Função para analisar os metadados de uma imagem
    public static function analyzeMetaData($filePath) {
        // Verifica se o arquivo existe
        if (!file_exists($filePath)) {
            return null;
        }

        // Tenta extrair dados EXIF da imagem
        $metaData = @exif_read_data($filePath, 0, true);

        if (!$metaData) {
            return "Nenhum dado EXIF encontrado.";
        }

        // Retorna os metadados extraídos
        return $metaData;
    }
}
