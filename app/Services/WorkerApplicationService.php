<?php

namespace App\Services;

use App\Models\WorkerApplicationStatus;

class WorkerApplicationService
{
    const SERVICE_REGISTRATION = 1;
    const SERVICE_SUBSCRIPTION = 2;
    const SERVICE_RENEWAL = 3;

    public function getStatus(int $workerId, int $serviceId)
    {
        if (!$this->isValidService($serviceId)) {
            throw new \InvalidArgumentException("Invalid service ID provided.");
        }
        return WorkerApplicationStatus::where('worker_id', $workerId)
            ->where('service_id', $serviceId)
            ->get();
    }

    public function addServiceId(int $workerId, int $serviceId)
    {
        if (!$this->isValidService($serviceId)) {
            throw new \InvalidArgumentException("Invalid service ID provided.");
        }
        $workerStatus = WorkerApplicationStatus::updateOrCreate(
            ['worker_id' => $workerId],
            ['service_id' => $serviceId]
        );

        return $workerStatus;
    }

    protected function isValidService(int $serviceId)
    {
        return in_array($serviceId, [
            self::SERVICE_REGISTRATION,
            self::SERVICE_SUBSCRIPTION,
            self::SERVICE_RENEWAL,
        ]);
    }
}
