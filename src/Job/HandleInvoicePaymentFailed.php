<?php

namespace Corals\Modules\Payment\Stripe\Job;


use Corals\Modules\Payment\Common\Models\Invoice;
use Corals\Modules\Payment\Common\Models\WebhookCall;
use Corals\Modules\Payment\Stripe\Exception\StripeWebhookFailed;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HandleInvoicePaymentFailed implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \Corals\Modules\Payment\Common\Models\WebhookCall
     */
    public $webhookCall;

    /**
     * HandleInvoiceCreated constructor.
     * @param WebhookCall $webhookCall
     */
    public function __construct(WebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }

    public function handle()
    {
        logger('Invoice Payment Failed');

        try {
            if ($this->webhookCall->processed) {
                throw StripeWebhookFailed::processedCall($this->webhookCall);
            }

            $payload = $this->webhookCall->payload;

            if (is_array($payload) && isset($payload['data']['object'])) {
                $invoiceObject = $payload['data']['object'];

                $invoiceCode = $invoiceObject['id'];
                if (!$invoiceObject['paid']) {
                    $invoice = Invoice::whereCode($invoiceCode)->first();

                    $invoice->markAsFailed();
                } else {
                    throw StripeWebhookFailed::invalidStripePayload($this->webhookCall);
                }

                $this->webhookCall->markAsProcessed();
            } else {
                throw StripeWebhookFailed::invalidStripePayload($this->webhookCall);
            }
        } catch (\Exception $exception) {
            log_exception($exception);
            $this->webhookCall->saveException($exception);
            throw $exception;
        }

    }
}
