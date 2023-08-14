<?php

$version = 'v2';
if (empty($modx->version)) {
    $modx->getVersionData();
}
if ($modx->version['version'] < 3) {
    $corePath = $modx->getOption(
        'lesscss.core_path',
        null,
        $modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/lesscss/'
    );
    $lesscss = $modx->getService(
        'lesscss',
        'lesscss',
        $corePath . 'model/lesscss/',
        [
            'core_path' => $corePath
        ]
    );
} else {
    $version = 'v3';
    $lesscss = $modx->services->get('lesscss');
}

$lesscss->clearCache();