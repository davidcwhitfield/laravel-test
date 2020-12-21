<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $channels = [
            'GlobalCyclingNetwork',
            'globalmtb'
        ];

        foreach ($channels as $channel) {
            DB::table('channels')->insert([
                'channel_name' => $channel
            ]);
        }
    }
}
