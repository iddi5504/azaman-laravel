<?php

/**
 * This function creates a php array for our flash messages
 * @param string $status The status of the message . Eg. success, error, warning
 * @param string $message The message 
 * @param string $description Additional description to add
 * @return array The flash message object to be stored in session
 * 
 */
function getFlashMessageObject(string $status, string $message, string $description = '')
{
    return [
        'flash' => compact('status', 'message', 'description')
    ];
}
