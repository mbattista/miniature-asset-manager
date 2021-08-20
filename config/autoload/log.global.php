<?php
declare(strict_types=1);

use Laminas\Log\Logger;
use Laminas\Log\Processor\RequestId;

return [
    'log' => [
        'FileLogger' => [
            'writers' => [
                'stream' => [
                    'name' => 'stream',
                    'priority' => Logger::ALERT,
                    'options' => [
                        'stream' => 'log/error.log',
                    ],
                ],
            ],
            'processors' => [
                'requestid' => [
                    'name' => RequestId::class,
                ],
            ],
        ],
    ],
];
