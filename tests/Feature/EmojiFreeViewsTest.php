<?php

use Illuminate\Support\Facades\File;

test('los recursos no contienen emojis ni flechas y usan iconos en su lugar', function () {
    $resourcesPath = resource_path();

    $symbolPattern = '/[\x{1F000}-\x{1FAFF}\x{2600}-\x{27BF}\x{2B00}-\x{2BFF}\x{2300}-\x{23FF}\x{FE0F}]|&(?:darr|uarr|rarr|larr|harr|crarr);/u';

    $violations = [];

    foreach (File::allFiles($resourcesPath) as $file) {
        $contents = File::get($file->getPathname());

        // Solo se analizan archivos de texto con codificación válida en UTF-8.
        if (! preg_match('//u', $contents)) {
            continue;
        }

        // Los comentarios Blade no se renderizan, así que quedan fuera del análisis.
        $contents = preg_replace('/\{\{--.*?--\}\}/s', '', $contents);

        if (preg_match_all($symbolPattern, $contents, $matches)) {
            $violations[] = sprintf(
                '%s: %s',
                str_replace($resourcesPath.DIRECTORY_SEPARATOR, '', $file->getPathname()),
                implode(' ', array_unique($matches[0])),
            );
        }
    }

    $this->assertSame(
        [],
        $violations,
        'Se encontraron emojis o entidades de flecha en resources (usa iconos de Lucide en su lugar): '.implode('; ', $violations),
    );
});
