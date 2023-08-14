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
        'LessCSS',
        $corePath . 'model/lesscss/',
        [
            'core_path' => $corePath
        ]
    );
} else {
    $lesscss = $modx->services->get('lesscss');
}
if (!isset($scriptProperties)) {
    $scriptProperties = [];
}
$path = $modx->getOption('path', $scriptProperties, $lesscss->config['assetsPath']);
$file = $modx->getOption('file', $scriptProperties, 'style.less');
$fixRelativePaths = $modx->getOption('fixRelativePaths', $scriptProperties, true);
$compress = $modx->getOption('compress', $scriptProperties, true);
$basePath = $modx->getOption('base_path', $scriptProperties, MODX_BASE_PATH);

$path = $basePath. ltrim($path, $basePath);

$file = $path.$file;


// run if not empty
if ($file && file_exists($file)) {

    // load the lessphp compiler
    try{
        // compile and return css
        $options = [
            'compress' => $compress,
            'relativeUrls' => $fixRelativePaths,
            'import_dirs' => [ $path ],
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
} else {
    return '// Error: finding file '.$file;
}