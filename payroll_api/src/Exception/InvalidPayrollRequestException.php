<?php

declare(strict_types=1);

namespace App\Exception;

use Override;
use RuntimeException;

class InvalidPayrollRequestException extends RuntimeException
{
    protected $message = 'Missing payroll request query parameters';
}
