<?php

namespace Illuminate\Database\Rethorical\DatabaseTypes\Redis;

enum RedisStorageType
{
    case Key;
    case Hash;
    case List;
    case SortedList;
}
