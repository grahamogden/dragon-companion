<?php

namespace App\Services;

use App\Interfaces\FlashNotificationInterface;
use Illuminate\Http\Request;

class FlashNotificationService implements FlashNotificationInterface
{
    public const INERTIA_REQUEST_KEY = 'notifications';
    public const SESSION_KEY = 'flash.notifications';

    private const TYPE_SUCCESS = 'success';
    private const TYPE_ERROR = 'error';
    private const TYPE_WARNING = 'warning';
    private const TYPE_INFO = 'info';

    /**
     * Create a new class instance.
     */
    public function __construct(private readonly Request $request) {}

    private function appendMessage(array $flashMessage): void
    {
        $flashMessages = $this->request->session()
            ->get(
                key: self::SESSION_KEY,
                default: []
            );

        $this->request->session()
            ->flash(
                key: self::SESSION_KEY,
                value: array_merge($flashMessages, [$flashMessage])
            );
    }

    public function addSuccessMsg(string $message): void
    {
        $this->appendMessage(
            flashMessage: [
                'type' => self::TYPE_SUCCESS,
                'message' => $message,
            ]
        );
    }

    public function addErrorMsg(string $message): void
    {
        $this->appendMessage(
            flashMessage: [
                'type' => self::TYPE_ERROR,
                'message' => $message,
            ]
        );
    }

    public function addWarningMsg(string $message): void
    {
        $this->appendMessage(
            flashMessage: [
                'type' => self::TYPE_WARNING,
                'message' => $message,
            ]
        );
    }

    public function addInfoMsg(string $message): void
    {
        $this->appendMessage(
            flashMessage: [
                'type' => self::TYPE_INFO,
                'message' => $message,
            ]
        );
    }
}
