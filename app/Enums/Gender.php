<?php

namespace App\Enums;

enum Gender: int
{
    case NOT_SET = 0;
    case FEMALE = 1;
    case MALE = 2;
    case NON_BINARY = 3;
}
