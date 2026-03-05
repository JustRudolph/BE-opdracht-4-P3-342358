<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Throwable;

class LeverancierService
{
    /**
     * Fetch leverancier details including contact via stored procedure.
     */
    public function getDetails(int $id): ?object
    {
        $rows = DB::select('CALL sp_get_leverancier_details(?)', [$id]);
        return $rows[0] ?? null;
    }

    /**
     * Update mobiel and straatnaam using stored procedure.
     * Returns array [success => bool, message => string]
     */
    public function updateContact(int $leverancierId, string $mobiel, string $straatnaam): array
    {
        try {
            DB::statement('CALL sp_update_leverancier_contact(?, ?, ?)', [
                $leverancierId,
                $mobiel,
                $straatnaam,
            ]);
            return ['success' => true, 'message' => 'De wijzigingen zijn doorgevoerd'];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => 'Door een technische storing is het niet mogelijk de wijziging door te voeren. Probeer het op een later moment nog eens',
            ];
        }
    }
}
