<?php

namespace App\Enums;

enum TransactionStatus: string
{
    case PENDING = "pending";
    case COMPELETED = "completed";
    case PROCESSING = "processing";
    case FAILED = "failed";
};
