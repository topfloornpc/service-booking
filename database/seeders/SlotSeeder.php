<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Slot;

class SlotSeeder extends Seeder
{
    public function run(): void
    {
        $services = Service::where('is_active', true)->get();
        if ($services->isEmpty()) return;

        $startDay = now()->startOfDay()->addDay();

        foreach ($services as $service) {
            for ($d = 0; $d < 7; $d++) {
                $day = $startDay->copy()->addDays($d);

                foreach ([10, 12, 14] as $hour) {
                    $start = $day->copy()->setTime($hour, 0);
                    $end = $start->copy()->addMinutes($service->duration_minutes);

                    Slot::firstOrCreate([
                        'service_id' => $service->id,
                        'start_at' => $start,
                        'end_at' => $end,
                    ], [
                        'capacity' => 1,
                        'is_active' => true,
                    ]);
                }
            }
        }
    }
}
