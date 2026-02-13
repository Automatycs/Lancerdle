<?php

namespace App\Enums;

enum GameStates: string
{
    case ONGOING = 'ongoing';
	case WON = 'won';
	case LOST = 'lost';
}
