<?php

namespace App\Models\Enums;

enum ProductActions: string
{
    case DraftToActive = 'DraftToActive';
    case ActiveToDelete = 'ActiveToDelete';
    case ActiveToDraft = 'ActiveToDraft';
}
