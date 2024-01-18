<?php
declare(strict_types=1);

namespace HauerHeinrich\HhPowermailTimeprotect\ViewHelpers;

/***************************************************************
 * Copyright notice
 *
 * (c) 2024 Christian Hackl <web@hauer-heinrich.de>
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 * Example
 * <html xmlns:f="http://typo3.org/ns/TYPO3/CMS/Fluid/ViewHelpers"
 *   xmlns:timeprotect="http://typo3.org/ns/HauerHeinrich/HhPowermailTimeprotect/ViewHelpers"
 *   data-namespace-typo3-fluid="true">
 *
 *  <timeprotect:encrypt value="" />
 */

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class EncryptViewHelper extends AbstractViewHelper {
    public function initializeArguments() {
        $this->registerArgument('value', 'string', 'String to encrypt', true);
        $this->registerArgument('passphrase', 'string', 'key / passphrase for encrypt', false);
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext) {
        $text = $arguments['value'] ? $arguments['value'] : '';
        if(empty($text)) {
            return '';
        }

        $key = $arguments['passphrase'] ? $arguments['passphrase'] : '';

        $as = 'timeprotectData';
        $currentTime = new \DateTime();
        $currentTimeStamp = $currentTime->getTimestamp();

        $cipher = 'AES-128-CBC';
        $ciphertext = '';

        $dataToEncrpyt = $text.'<_>'.$currentTimeStamp;
        if (!in_array($cipher, openssl_get_cipher_methods())) {
            if (in_array(strtolower($cipher), openssl_get_cipher_methods())) {
                $cipher = strtolower('AES-128-CBC');
            }
        }

        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($dataToEncrpyt, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);

        // Encrypted string
        $ciphertext = base64_encode($iv.$hmac.$ciphertext_raw);

        $templateVariableContainer = $renderingContext->getVariableProvider();
        $templateVariableContainer->add($as, [
            'encryptText' => $ciphertext,
            'timestamp' => $currentTimeStamp
        ]);
    }
}
