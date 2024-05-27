<?php

declare(strict_types=1);

use App\Models\System\Approval;
use App\Models\System\Disapproval;
use App\Models\System\Modification;

return [
    'models' => [
        'modification' => Modification::class,
        'approval' => Approval::class,
        'disapproval' => Disapproval::class,
    ],
];
