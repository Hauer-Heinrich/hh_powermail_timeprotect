<?php
defined('TYPO3') || die();

use \TYPO3\CMS\Core\Utility\GeneralUtility;

(static function() {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\In2code\Powermail\Domain\Model\Field::class] = [
        'className' => \HauerHeinrich\HhPowermailTimeprotect\Domain\Model\Field::class,
    ];

    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\Container\Container::class)
        ->registerImplementation(
            \In2code\Powermail\Domain\Model\Field::class,
            \HauerHeinrich\HhPowermailTimeprotect\Domain\Model\Field::class
        );
})();
