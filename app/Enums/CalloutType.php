<?php

namespace App\Enums;

enum CalloutType: string
{
    case INFO = 'info';
    case WARNING = 'warning';
    case ERROR = 'error';
}
