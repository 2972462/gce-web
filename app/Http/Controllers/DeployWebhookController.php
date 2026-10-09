<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class DeployWebhookController extends Controller
{
    public function handle(Request $request): JsonResponse
    {
        $secret = config('services.deploy_webhook.secret');

        if (! $secret) {
            abort(503, 'Webhook de deploy no configurado.');
        }

        $firma = (string) $request->header('X-Hub-Signature-256', '');
        $esperada = 'sha256='.hash_hmac('sha256', $request->getContent(), $secret);

        if (! hash_equals($esperada, $firma)) {
            abort(403, 'Firma invalida.');
        }

        $payload = $request->json()->all();

        if (($payload['ref'] ?? null) !== 'refs/heads/main') {
            return response()->json(['skipped' => true]);
        }

        $process = new Process(['bash', config('services.deploy_webhook.script')]);
        $process->setTimeout(300);
        $process->run();

        Log::info('Deploy webhook ejecutado', [
            'exitCode' => $process->getExitCode(),
            'output' => $process->getOutput(),
            'errorOutput' => $process->getErrorOutput(),
        ]);

        return response()->json(['ok' => $process->isSuccessful()]);
    }
}
