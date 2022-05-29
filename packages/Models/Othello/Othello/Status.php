<?php

namespace Packages\Models\Othello\Othello;

enum Status
{
    case PLAYING; // プレー中
    case RESULTED; // 決着(引き分け含む)
    case INTERRUPTED; // (強制終了)
}
