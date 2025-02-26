<?php

namespace App\Observers;

use App\Models\Report;
use App\Notifications\CheckFailed;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class ReportObserver
{
    public function created(Report $report): void
    {
        if (! Arr::has([
            Response::HTTP_OK,
            Response::HTTP_FOUND,
            Response::HTTP_SEE_OTHER,
        ], $report->status_code)
        ) {
            $report->check->service->user->notify(new CheckFailed($report->check));
        }
    }
}
