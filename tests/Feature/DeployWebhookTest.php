<?php

namespace Tests\Feature;

use Tests\TestCase;

class DeployWebhookTest extends TestCase
{
    public function test_sin_secreto_configurado_responde_503(): void
    {
        config(['services.deploy_webhook.secret' => null]);

        $this->postJson('/deploy-webhook', ['ref' => 'refs/heads/main'])
            ->assertStatus(503);
    }

    public function test_firma_invalida_responde_403(): void
    {
        config(['services.deploy_webhook.secret' => 'el-secreto']);

        $this->postJson('/deploy-webhook', ['ref' => 'refs/heads/main'], [
            'X-Hub-Signature-256' => 'sha256=firma-incorrecta',
        ])->assertStatus(403);
    }

    public function test_firma_valida_pero_otra_rama_se_omite(): void
    {
        config(['services.deploy_webhook.secret' => 'el-secreto']);

        $body = json_encode(['ref' => 'refs/heads/otra-rama']);
        $firma = 'sha256='.hash_hmac('sha256', $body, 'el-secreto');

        $this->call('POST', '/deploy-webhook', [], [], [], [
            'HTTP_X-Hub-Signature-256' => $firma,
            'CONTENT_TYPE' => 'application/json',
        ], $body)
            ->assertOk()
            ->assertJson(['skipped' => true]);
    }

    public function test_firma_valida_y_rama_main_corre_el_script(): void
    {
        config(['services.deploy_webhook.secret' => 'el-secreto']);
        config(['services.deploy_webhook.script' => base_path('tests/Fixtures/deploy-noop.sh')]);

        $body = json_encode(['ref' => 'refs/heads/main']);
        $firma = 'sha256='.hash_hmac('sha256', $body, 'el-secreto');

        $this->call('POST', '/deploy-webhook', [], [], [], [
            'HTTP_X-Hub-Signature-256' => $firma,
            'CONTENT_TYPE' => 'application/json',
        ], $body)
            ->assertOk()
            ->assertJson(['ok' => true]);
    }
}
