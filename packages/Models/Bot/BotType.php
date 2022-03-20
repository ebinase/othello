<?php
namespace Packages\Models\Bot;

enum BotType: string
{
    case RANDOM = '01';
    case SELF_OPENNESS = '02';
}
