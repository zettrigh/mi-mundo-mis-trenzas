<?php

use Illuminate\Support\Facades\File;

test('las vistas no contienen emojis y usan iconos en su lugar', function () {
    $viewsPath = resource_path('views');

    $emojiPattern = '/[\x{1F000}-\x{1FAFF}\x{2600}-\x{27BF}\x{2B00}-\x{2BFF}\x{2300}-\x{23FF}\x{FE0F}]/u';

    $violations = [];

    foreach (File::allFiles($viewsPath) as $file) {
        if (! str_ends_with($file->getFilename(), '.blade.php')) {
            continue;
        }

        $contents = File::get($file->getPathname());

        // Los comentarios Blade no se renderizan, así que quedan fuera del análisis.
        $contents = preg_replace('/\{\{--.*?--\}\}/s', '', $contents);

        if (preg_match_all($emojiPattern, $contents, $matches)) {
            $violations[] = sprintf(
                '%s: %s',
                str_replace($viewsPath.DIRECTORY_SEPARATOR, '', $file->getPathname()),
                implode(' ', array_unique($matches[0])),
            );
        }
    }

    $this->assertSame(
        [],
        $violations,
        'Se encontraron emojis en las vistas (usa iconos de Lucide en su lugar): '.implode('; ', $violations),
    );
});
