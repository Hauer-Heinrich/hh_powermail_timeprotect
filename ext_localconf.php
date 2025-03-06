<?php
defined('TYPO3') || die();

(static function() {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\In2code\Powermail\Domain\Model\Field::class] = [
        'className' => \HauerHeinrich\HhPowermailTimeprotect\Domain\Model\Field::class,
    ];
})();
