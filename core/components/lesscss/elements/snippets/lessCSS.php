<?php
// -------------------------
// LESS CSS for MODX
// Written by Darren Doyle
// http://inventurous.net/
// -------------------------
// Updated by MatDave
// http://matdave.com/
// -------------------------
// uses Less.php
// https://github.com/wikimedia/less.php
// -------------------------

// get the contents of the less file

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
if (!isset($scriptProperties)) {
    $scriptProperties = [];
}
$path = $modx->getOption('path', $scriptProperties, 'assets/less/');
$file = $modx->getOption('file', $scriptProperties, 'style.less');
$fixRelativePaths = $modx->getOption('fixRelativePaths', $scriptProperties, true);
$compress = $modx->getOption('compress', $scriptProperties, true);

$file = $modx->getOption('base_path').$path.$file;


// run if not empty
if ($file && file_exists($file)) {

    // load the lessphp compiler
    try{
        // compile and return css
        $options = [
            'compress' => $compress,
            'relativeUrls' => $fixRelativePaths,
            'import_dirs' => [
                $modx->getOption(
                'base_path',
                null,
                MODX_BASE_PATH
                ) . $path
            ],
            'cache_dir' => $modx->getOption(
                'core_path',
                null,
                MODX_CORE_PATH
                ) . 'cache/' . $lesscss->config['cachePath'],
        ];

        $lessParser = new Less_Parser();
        $lessParser->SetOptions($options);
        $lessParser->parseFile($file, $path);
        $string = $lessParser->getCss();
    } catch (Exception $e) {
        $modx->log(1, $e->getMessage());
        return '// Error: parsing file '.$file;
    }

    // return the CSS
    return $string;
}