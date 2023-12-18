<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\InvalidPayrollRequestException;
use App\Service\PayrollService;
use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PayrollController extends AbstractController
{
    public function __construct(private readonly PayrollService $service)
    {
    }

    #[Route(path: '/payrolls/dates', name: 'payrolls.dates', methods: [Request::METHOD_GET])]
    public function getPayDay(Request $request): JsonResponse
    {
        if (!$request->query->has('year') || !$request->query->has('month')) {
            throw new InvalidPayrollRequestException();
        }

        $payrollDate = Carbon::createFromDate(
            year: $request->query->get('year'),
            month: $request->query->get('month'),
        )->endOfMonth();

        $paymentDate = $this->service->calculatePaymentDate($payrollDate);
        $payDate = $this->service->calculatePayDate($paymentDate);

        // Recommended date format ISO8601
        return $this->json([
            'payment_date' => $paymentDate->format('c'),
            'pay_date' => $payDate->format('c')
        ]);
    }
}
