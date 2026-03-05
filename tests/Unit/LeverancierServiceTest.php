<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\LeverancierService;
use Illuminate\Support\Facades\DB;
use Mockery;

class LeverancierServiceTest extends TestCase
{
    public function test_update_contact_success_for_astra_sweets(): void
    {
        DB::shouldReceive('statement')
            ->once()
            ->with('CALL sp_update_leverancier_contact(?, ?, ?)', [2, '06-39398825', 'Den Dolderlaan'])
            ->andReturn(true);

        $service = new LeverancierService();
        $result = $service->updateContact(2, '06-39398825', 'Den Dolderlaan');

        $this->assertTrue($result['success']);
        $this->assertStringContainsString('doorgevoerd', $result['message']);
    }

    public function test_update_contact_failure_for_de_bron(): void
    {
        DB::shouldReceive('statement')
            ->once()
            ->with('CALL sp_update_leverancier_contact(?, ?, ?)', [5, '06-39398825', 'Den Dolderlaan'])
            ->andThrow(new \Exception('Technical error'));

        $service = new LeverancierService();
        $result = $service->updateContact(5, '06-39398825', 'Den Dolderlaan');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('niet mogelijk', $result['message']);
    }
}
