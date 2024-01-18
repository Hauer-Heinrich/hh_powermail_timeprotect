<?php
defined('TYPO3') || die();

call_user_func(function() {
    $extensionKey = 'hh_powermail_timeprotect';

    // make TypoScript selectable
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        $extensionKey,
        'Configuration/TypoScript',
        'EXT:'.$extensionKey.' :: Powermail time protect'
    );
});
