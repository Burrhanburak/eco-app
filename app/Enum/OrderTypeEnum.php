<?php

namespace App\Enum;


enum OrderTypeEnum : string {
    case PENDİNG = 'pending';

    case PROCESSİNG = 'processing';

    case COMPLETED = 'completed';

    case DECLINED = 'declined';

}
