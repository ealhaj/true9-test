<?php

namespace App\Tests\unit;

use App\Service\PayrollService;
use Carbon\Carbon;
use DateTimeZone;
use Generator;
use Override;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PayrollServiceTest extends KernelTestCase
{
    private PayrollService $service;

    #[Override]
    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $this->service = $container->get(PayrollService::class);
    }

    /**
     * @dataProvider dateProvider
     */
    public function testCalculatePaymentDate(int $year, int $month, int $diff): void
    {
        $date = Carbon::createFromDate($year, $month, 1)->endOfMonth();
        $result = $this->service->calculatePaymentDate($date);

        $this->assertEquals($diff, $date->diffInDays($result));
        $this->assertTrue(true);
    }

    public function testCalculatePayDate(): void
    {
        $date = Carbon::now();
        $result = $this->service->calculatePayDate($date);

        $this->assertEquals(4, $result->diffInDays($date));
        $this->assertTrue(true);
    }

    public function dateProvider(): Generator
    {
        $year = 2023;

        foreach ([3, 4, 5, 6, 8, 9, 11, 12] as $month) {
            yield [$year, $month, PayrollService::PAYMENT_DATE_SCHEDULE];
        }

        foreach ([1, 2, 10] as $month) {
            yield [$year, $month, 4];
        }

        yield [$year, 7, 3];
    }
}
