<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mask;
use App\Models\SmsStatus;

class StatusAndMaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $mask = new Mask();
        $mask->mask = 'PICMTI-HR';
        $mask->active = 1;
        $mask->save();


        $smsStatus = new SmsStatus();
        $smsStatus->description = 'failed';
        $smsStatus->active = 1;
        $smsStatus->save();


        $smsStatus2 = new SmsStatus();
        $smsStatus2->description = 'success';
        $smsStatus2->active = 1;
        $smsStatus2->save();





    }
}
