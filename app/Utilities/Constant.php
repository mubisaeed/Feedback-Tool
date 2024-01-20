<?php

namespace App\Utilities;

class Constant
{
    const ServerError = 500;
    const Forbidden = 403;
    const NotFound = 404;
    const Success = 200;
    const Unauthorized = 401;
    const ErrorCode = 409;

    const type = [
        'user' => 'user'
    ];

    const status = [
        'upcoming' => 'upcoming',
        'draft' => 'draft',
        'published' => 'published',
    ];

	const CaseStatus = [
		'flag' => 'flag',
		'approve' => 'approve',
		'discuss' => 'discuss',
	];
}
