<?php

declare(strict_types=1);

namespace App\Http\Controllers\Payments;

use App\Enums\Reservation\Status;
use App\Events\Reservation\PaidEvent;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Log;
use YooKassa\Model\Notification\NotificationEventType;
use YooKassa\Model\Notification\NotificationSucceeded;
use YooKassa\Model\Notification\NotificationWaitingForCapture;

final class PaymentCallbackController extends Controller
{
    public function __invoke(Request $request): void
    {
        Log::info('PaymentCallbackController: '.json_encode($request->all()));
        $notification = ($request->input('event') === NotificationEventType::PAYMENT_SUCCEEDED)
            ? new NotificationSucceeded($request->all())
            : new NotificationWaitingForCapture($request->all());
        $payment = $notification->getObject();
        $metadata = $payment->getMetadata();
        $reservation_id = $metadata?->reservation_id;
        if (! $reservation_id) {
            Log::info('PaymentCallbackController: Not found reservation id!');

            return;
        }

        $reservation = Reservation::find($reservation_id);
        if (! $reservation) {
            Log::info('PaymentCallbackController: Not found reservation!');

            return;
        }
        $reservation->setStatus(Status::Paid);
        PaidEvent::dispatch($reservation);
    }
}
