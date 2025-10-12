<?php

function getFlashMessageObject(string $status, string $message, string $description = '')
{
    return [
        'flash' => compact('status', 'message', 'description')
    ];
}
