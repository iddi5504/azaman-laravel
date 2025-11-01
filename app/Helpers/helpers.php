<?php

/**
 * This function creates a php array for our flash messages
 */
function getFlashMessageObject(string $status, string $message, string $description = '')
{
    return [
        'flash' => compact('status', 'message', 'description')
    ];
}
