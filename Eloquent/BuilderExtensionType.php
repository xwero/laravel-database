<?php

namespace Illuminate\Database\Eloquent;

enum BuilderExtensionType : int
{
    case REGULAR = 0;
    case REQUIRED = 1;

    case LOCALE = 2;
}
