<?php
/**
 * @package admin
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id:$
 */
use Aura\Di\ContainerBuilder;
use Aura\Web\Request as WebRequest;

$diConfigFiles = array();
if ($dirContents = @dir(DIR_FS_CATALOG . 'app/diConfigs')) {
    while ($dirFile = $dirContents->read()) {
        if (preg_match('~^[^\._].*\.php$~i', $dirFile) > 0) {
            require(DIR_FS_CATALOG . 'app/diConfigs/' . $dirFile);
            $className = pathinfo($dirFile, PATHINFO_FILENAME);
            $config = new $className();
            $diConfigFiles[] = $config;
        }
    }
    $dirContents->close();
}

$builder = new ContainerBuilder();
$di = $builder->newConfiguredInstance($diConfigFiles);
$zcRequest = $di->get('zencart_request');
