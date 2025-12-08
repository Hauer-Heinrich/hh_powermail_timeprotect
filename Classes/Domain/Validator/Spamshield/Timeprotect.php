<?php
declare(strict_types=1);

namespace HauerHeinrich\HhPowermailTimeprotect\Domain\Validator\Spamshield;

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \In2code\Powermail\Domain\Validator\SpamShield\AbstractMethod;

/**
* Class Timeprotect
*/
class Timeprotect extends AbstractMethod {

    protected \In2code\Powermail\Domain\Model\Mail $mail;
    protected array $arguments = [];

    public function initialize(): void {
    }

    public function initializeSpamCheck(): void {
    }

    /**
     * My spam check
     *
     * @return bool true if spam recognized
     */
    public function spamCheck(): bool {
        // get value from configuration
        $protectionTime = $this->configuration['protectionTime'];

        foreach($this->mail->getAnswers() as $answer) {
            if($answer->getField()->getType() === 'timeprotect') {
                if(!empty($answer->getField()->getTxHhpowermailtimeprotectProtectionTime())) {
                    $protectionTime = $answer->getField()->getTxHhpowermailtimeprotectProtectionTime();
                }

                $fieldValue = $answer->getValue();
                if(empty($fieldValue)) {
                    return true;
                }

                $pos = strripos($fieldValue, '_');
                if($pos <= 0) {
                    return true;
                }

                $timestampFormularWasGenerated = substr($fieldValue, $pos + 1);
                if(!is_numeric($timestampFormularWasGenerated)) {
                    return true;
                }

                $currentTime = new \DateTime();
                $currentTimeStamp = $currentTime->getTimestamp();
                $encryptedValue = substr_replace($fieldValue, '', $pos);

                if(!empty($encryptedValue)) {
                    $key = $answer->getField()->getTxHhpowermailtimeprotectRandstring(); // Previously used in encryption

                    $cipher = 'AES-128-CBC';
                    if (!in_array($cipher, openssl_get_cipher_methods())) {
                        if (in_array(strtolower($cipher), openssl_get_cipher_methods())) {
                            $cipher = strtolower('AES-128-CBC');
                        }
                    }

                    $c = base64_decode($encryptedValue);
                    $ivlen = openssl_cipher_iv_length($cipher);
                    $iv = substr($c, 0, $ivlen);
                    $hmac = substr($c, $ivlen, $sha2len = 32);
                    $ciphertext_raw = substr($c, $ivlen + $sha2len);
                    $decryptedText = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                    $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);

                    if(hash_equals($hmac, $calcmac)){ //PHP 5.6+ Timing attack safe string comparison
                        $decryptedTextArry = explode('<_>', $decryptedText);

                        if($timestampFormularWasGenerated === $decryptedTextArry[1]) {
                            if(($currentTimeStamp - $timestampFormularWasGenerated) > $decryptedTextArry[0]) {
                                return false;
                            }
                        }
                    }
                }
            }
        }

        // WORKAROUND, see https://github.com/in2code-de/powermail/issues/1252
        //$request = $GLOBALS['TYPO3_REQUEST'];

        $requestedUrl = 'https://'.$_SERVER['HTTP_HOST'].parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $responseFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            \Psr\Http\Message\ResponseFactoryInterface::class
        );
        $response = $responseFactory
            ->createResponse()
            ->withAddedHeader('location', $requestedUrl.'?timeprotect=spam');
        throw new \TYPO3\CMS\Core\Http\PropagateResponseException($response);

        return true;
    }
}
