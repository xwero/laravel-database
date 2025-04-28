<?php

namespace Illuminate\Database\Rethorical\DatabaseTypes\Redis;

enum RedisCommand
{
    case Set;
    case Get;
    case Mget;
    case Incr;
    case Keys;
    case Exists;
    case Expire;
    case Ttl;
    case Persist;
    case Scan;
    case Del;
    case Info;
    case Hset;
    case Hget;
    case Hgetall;
    case HmGet;
    case HmSet;
    case Hkeys;
    case Hdel;
    case Sadd;
    case Smembers;
    case Scard;
    case Sismembers;
    case Sdiff;
    case Sdiffstore;
    case Srem;
    case Zadd;
    case Zrange;
    case Lpush;
    case Rpush;
    case Lrange;
    case Llen;
    case Lpop;
    case Rpop;
    case Xadd;
    case Xread;
    case Xrange;
    case Xlen;
    case Xdel;
    case Xtrim;
    case JsonSet;
    case JsonGet;
    case JsonNumIncrBy;
    case JsonObjKeys;
    case JsonObjLen;
    case JsonArrAppend;
    case JsonArrInsert;
    case jsonArrIndex;
    case FtCreate;
    case FtSearch;
    case FtAggregate;
    case FtInfo;
    case FtDropIndex;

}
