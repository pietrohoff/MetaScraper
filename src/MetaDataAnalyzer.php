<?php
// src/MetaDataAnalyzer.php

class MetaDataAnalyzer {
    public static function analyzeMetaData($filePath) {
        // Verifica se o arquivo existe e tem conteúdo
        if (!file_exists($filePath) || filesize($filePath) === 0) {
            return "O arquivo não foi baixado corretamente ou está vazio." . "\n";
        }

        // Verifica o tipo de arquivo
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = mime_content_type($filePath);

        if (!in_array($fileType, $allowedTypes)) {
            return "O arquivo não é uma imagem suportada. Tipo detectado: " . $fileType . "\n";
        }

        // Tenta ler os metadados EXIF
        if (exif_imagetype($filePath)) {
            $exif = @exif_read_data($filePath);  // @ para suprimir warnings de arquivos sem EXIF
            if ($exif) {
                return $exif;
            } else {
                return "Nenhum dado EXIF encontrado." . "\n";
            }
        } else {
            return "O arquivo não é uma imagem suportada.". "\n";
        }
    }
}
