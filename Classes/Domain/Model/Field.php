<?php
namespace HauerHeinrich\HhPowermailTimeprotect\Domain\Model;

/**
 * Class Field
 * @package In2code\Powermailextended\Domain\Model
 */
class Field extends \In2code\Powermail\Domain\Model\Field {
    /**
     * New property protection time
     *
     * @var int $txHhpowermailtimeprotectProtectionTime
     */
    protected $txHhpowermailtimeprotectProtectionTime;

    /**
     * New property counter text
     *
     * @var string $txHhpowermailtimeprotectCountText
     */
    protected $txHhpowermailtimeprotectCountText;

    /**
     * New property random string
     *
     * @var string $txHhpowermailtimeprotectRandstring
     */
    protected $txHhpowermailtimeprotectRandstring;

    /**
     * @param string $txHhpowermailtimeprotectProtectionTime
     * @return void
     */
    public function setTxHhpowermailtimeprotectProtectionTime(int $txHhpowermailtimeprotectProtectionTime): void
    {
        $this->txHhpowermailtimeprotectProtectionTime = $txHhpowermailtimeprotectProtectionTime;
    }

    /**
     * @return string
     */
    public function getTxHhpowermailtimeprotectProtectionTime(): int
    {
        return $this->txHhpowermailtimeprotectProtectionTime;
    }

    /**
     * @param string $txHhpowermailtimeprotectCountText
     * @return void
     */
    public function setTxHhpowermailtimeprotectCountText(string $txHhpowermailtimeprotectRandstring): void
    {
        $this->txHhpowermailtimeprotectCountText = $txHhpowermailtimeprotectCountText;
    }

    /**
     * @return string
     */
    public function getTxHhpowermailtimeprotectCountText(): string
    {
        return $this->txHhpowermailtimeprotectCountText;
    }

    /**
     * @param string $txHhpowermailtimeprotectRandstring
     * @return void
     */
    public function setTxHhpowermailtimeprotectRandstring(string $txHhpowermailtimeprotectRandstring): void
    {
        $this->txHhpowermailtimeprotectRandstring = $txHhpowermailtimeprotectRandstring;
    }

    /**
     * @return string
     */
    public function getTxHhpowermailtimeprotectRandstring(): string
    {
        return $this->txHhpowermailtimeprotectRandstring;
    }
}
