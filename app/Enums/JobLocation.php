<?php

namespace App\Enums;

enum JobLocation : string {
    case OnSite = 'onsite';
    case Remote = 'remote';
    case Hybrid = 'Hybrid';
}