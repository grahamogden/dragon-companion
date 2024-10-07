<?php

namespace App\Interfaces;

interface FlashNotificationInterface
{
    public function addSuccessMsg(string $message): void;

    public function addErrorMsg(string $message): void;

    public function addWarningMsg(string $message): void;

    public function addInfoMsg(string $message): void;
}
