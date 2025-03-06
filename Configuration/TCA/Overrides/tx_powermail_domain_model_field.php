<?php
defined('TYPO3') || die();

/**
 * extend powermail fields tx_powermail_domain_model_field
 */
$tempColumns = [
    'tx_hhpowermailtimeprotect_protection_time' => [
        'label' => 'Time protection',
        'description' => 'The minimum time in seconds that must elapse before the form can be sent.',
        'config' => [
            'type' => 'input',
            'eval' => 'required,int',
            'default' => 30,
            'placeholder' => 30,
        ],
    ],
    'tx_hhpowermailtimeprotect_count_text' => [
        'label' => 'Counter text',
        'description' => 'Show this text instead of the submit field.',
        'config' => [
            'type' => 'input',
            'eval' => 'trim',
            'default' => 'Sending is possible in',
            'placeholder' => 'Sending is possible in',
        ],
    ],
    'tx_hhpowermailtimeprotect_randstring' => [
        'label' => 'Random string',
        'description' => '',
        'config' => [
            'type' => 'input',
            'eval' => 'required,trim',
            'default' => substr(md5(uniqid(mt_rand(), true)), 0, 22),
            'placeholder' => substr(md5(uniqid(mt_rand(), true)), 0, 22),
        ],
    ],
];
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_powermail_domain_model_field', $tempColumns);

$GLOBALS['TCA']['tx_powermail_domain_model_field']['types']['timeprotect'] = [
    'showitem' => '
        title,
        type,
        tx_hhpowermailtimeprotect_protection_time,
        tx_hhpowermailtimeprotect_count_text,
        tx_hhpowermailtimeprotect_randstring,
        --div--;LLL:EXT:powermail/Resources/Private/Language/locallang_db.xlf:tx_powermail_domain_model_field.sheet1,
            mandatory,
            --palette--;Layout;43,
            --palette--;LLL:EXT:powermail/Resources/Private/Language/locallang_db.xlf:tx_powermail_domain_model_field.marker_title;5,
        --div--;LLL:EXT:powermail/Resources/Private/Language/locallang_db.xlf:tabs.access,
            sys_language_uid,
            l10n_parent,
            l10n_diffsource,
            hidden,
            starttime,
            endtime
    ',
];
