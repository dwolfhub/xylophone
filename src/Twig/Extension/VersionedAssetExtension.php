<?php
namespace Xylophone\Twig\Extension;

use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Class VersionedAssetExtension
 * @package Xylophone\Twig\Extension
 */
class VersionedAssetExtension extends Twig_Extension
{
    /**
     * @var array
     */
    protected $versionedAssets;

    /**
     * VersionedAssetExtension constructor.
     * @param string $assetsJSONFileName
     */
    public function __construct($assetsJSONFileName)
    {
        if (!file_exists($assetsJSONFileName)) {
            trigger_error('Assets JSON file does not exist', E_USER_ERROR);
        }

        $versionedAssets = json_decode(file_get_contents($assetsJSONFileName));

        if ($versionedAssets === null) {
            trigger_error('Assets JSON file could not be decoded', E_USER_ERROR);
        }

        $this->versionedAssets = $versionedAssets;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'punchkick_assets';
    }

    /**
     * @return Twig_SimpleFunction[]
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('versioned_asset', function ($entryPoint, $type) {
                if (!isset($this->versionedAssets->$entryPoint->$type)) {
                    trigger_error(
                        'Version asset "' . $entryPoint . '->' . $type . '" does not exist in the assets JSON file',
                        E_USER_ERROR
                    );
                }

                return $this->versionedAssets->$entryPoint->$type;
            }),
        ];
    }

}