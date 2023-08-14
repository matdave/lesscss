<?php

class LessCSS
{
    public $modx;
    
    public $namespace = 'lesscss';
    
    public $config = [];
    
    function __construct(modX &$modx, array $config = [])
    {
        $this->modx =& $modx;

        $corePath = $this->getOption('core_path', $config, $this->modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/lesscss/');
        $assetsPath = $this->getOption('assets_path', $config, $this->modx->getOption('assets_path', null, MODX_ASSETS_PATH) . 'components/lesscss/');
        $this->config = array_merge(
            [
                'corePath'  => $corePath,
                'srcPath'   => $corePath . 'src/',
                'cachePath' => 'lesscss',
                'assetsPath' => $assetsPath,
            ],
            $config
        );
        $this->modx->addPackage('lesscss', $this->getOption('modelPath'));
        $this->modx->lexicon->load('lesscss:default');
        $this->autoload();
    }


    /**
     * Get a local configuration option or a namespaced system setting by key.
     *
     * @param  string  $key  The option key to search for.
     * @param  array  $options  An array of options that override local options.
     * @param  mixed  $default  The default value returned if the option is not found locally or as a
     * namespaced system setting; by default this value is null.
     *
     * @return mixed The option value or the default value specified.
     */
    public function getOption(string $key, $options = [], $default = null)
    {
        $option = $default;
        if (!empty($key) && is_string($key)) {
            if ($options != null && array_key_exists($key, $options)) {
                $option = $options[$key];
            } elseif (array_key_exists($key, $this->config)) {
                $option = $this->config[$key];
            } elseif (array_key_exists("{$this->namespace}.{$key}", $this->modx->config)) {
                $option = $this->modx->getOption("{$this->namespace}.{$key}");
            }
        }
        return $option;
    }

    public function clearCache()
    {
        $cacheDir = $this->modx->getOption('core_path', null, MODX_CORE_PATH) . 'cache/'. $this->getOption('cachePath');
        if (is_dir($cacheDir)) {
            $this->modx->cacheManager->deleteTree($cacheDir);
        }
    }

    protected function autoload()
    {
        require_once $this->getOption('corePath') . 'vendor/autoload.php';
    }
}