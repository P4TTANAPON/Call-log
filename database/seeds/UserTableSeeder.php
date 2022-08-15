<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$root = array(
['id' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'root', 'email' => 'pkxiii@gmail.com', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'remember_token' => null, 'phone_number' => '0885392880', 'team' => 'ROOT', 'code_name' => 'X' ],
		);
		
        $test_user = array(
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'SCS ทดสอบ', 'email' => 'scs_test@calllog.samart.online', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'remember_token' => null, 'phone_number' => '02-9999999', 'team' => 'SCS', 'code_name' => '' ],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'คอลเซนเตอร์ ทดสอบ', 'email' => 'cc_test@calllog.samart.online', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'remember_token' => null, 'phone_number' => '02-9999999', 'team' => 'CC', 'code_name' => 'Z' ],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'ซัพพอร์ต ทดสอบ', 'email' => 'sp_test@calllog.samart.online', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'remember_token' => null, 'phone_number' => '02-9999999', 'team' => 'SP', 'code_name' => '' ],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'เอสเอ ทดสอบ', 'email' => 'sa_test@calllog.samart.online', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'remember_token' => null, 'phone_number' => '02-9999999', 'team' => 'SA', 'code_name' => '' ],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'เนตเวิร์ค ทดสอบ', 'email' => 'nw_test@calllog.samart.online', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'remember_token' => null, 'phone_number' => '02-9999999', 'team' => 'NW', 'code_name' => '' ],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'ซิสเต็ม ทดสอบ', 'email' => 'st_test@calllog.samart.online', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'remember_token' => null, 'phone_number' => '02-9999999', 'team' => 'ST', 'code_name' => '' ],
        );
		
		$user = array(
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'น.ส.ฌัชชา มนนามอญ', 'email' => 'Chatchar.I@samtel.samartcorp.com', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'phone_number' => '02-5033993', 'team' => 'CC', 'code_name' => 'A' ],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'น.ส.ปาริชาต กะรัมย์', 'email' => 'Parichat.K@samtel.samartcorp.com', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'phone_number' => '02-5034961', 'team' => 'CC', 'code_name' => 'B' ],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'น.ส.สุวรรณสา จันทร์กลิ่น', 'email' => 'Suwannasa.J@samtel.samartcorp.com', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'phone_number' => '02-5034962', 'team' => 'CC', 'code_name' => 'C' ],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'น.ส.จันทนี ดีล้อม', 'email' => 'Jantanee.D@samtel.samartcorp.com', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'phone_number' => '02-5034963', 'team' => 'CC', 'code_name' => 'D' ],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'น.ส.เนตรนภา ลำดับพงศ์', 'email' => 'Nednapa.L@samtel.samartcorp.com', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'phone_number' => '02-5034964', 'team' => 'CC', 'code_name' => 'E' ],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'นายปริญ นมัสศิลา', 'email' => 'Prin.N@samtel.samartcorp.com', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'phone_number' => '096-2265652', 'team' => 'SP', 'code_name' => '' ],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'นายนพดล สันตะโชติ', 'email' => 'Noppadol.S@samtel.samartcorp.com', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'phone_number' => '084-6860666', 'team' => 'SP', 'code_name' => '' ],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'นายธนภัทร์ จันทร์เกตุ', 'email' => 'Thanaphat.J@samtel.samartcorp.com', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'phone_number' => '083-0747574', 'team' => 'SP', 'code_name' => '' ],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'นายธงชัย ยินยอม', 'email' => 'Thongchai.Y@samtel.samartcorp.com', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'phone_number' => '099-5051369', 'team' => 'SP', 'code_name' => '' ],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'นายธนากร ทศราช', 'email' => 'Tanagonr.T@samtel.samartcorp.com', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'phone_number' => '091-8759371', 'team' => 'SP', 'code_name' => '' ],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'น.ส.เยาวลักษณ์ แสงแก้ว', 'email' => 'Yawalak.S@samtel.samartcorp.com', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'phone_number' => '087-8708174', 'team' => 'SP', 'code_name' => '' ],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'นายวัชระ เชื้อวณิชชากร', 'email' => 'Waschara.C@samtel.samartcorp.com', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'phone_number' => '082-0599360', 'team' => 'SP', 'code_name' => '' ],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'นายพิษณุพงศ์ ติลเชษฐ์', 'email' => 'Pissupong.T@samtel.samartcorp.com', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'phone_number' => '081-4416523', 'team' => 'SP', 'code_name' => '' ],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'นายอนรรฆ รามโกมุท', 'email' => 'Anak.R@samtel.samartcorp.com', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'phone_number' => '086-3601587', 'team' => 'SP', 'code_name' => '' ],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'นายปริญ นมัสศิลา (SA Test)', 'email' => 'prin.namas@gmail.com', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'phone_number' => '096-2265652', 'team' => 'SA', 'code_name' => '' ],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'นายนพดล สันตะโชติ (SA Test)', 'email' => 'suntachotpop@gmail.com', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'phone_number' => '084-6860666', 'team' => 'SA', 'code_name' => '' ],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'นายธนภัทร์ จันทร์เกตุ (SA Test)', 'email' => 'maxzi_za@hotmil.com', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'phone_number' => '083-0747574', 'team' => 'SA', 'code_name' => '' ],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'นายธงชัย ยินยอม (NW Test)', 'email' => 'babybuffalo@hotmail.com', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'phone_number' => '099-5051369', 'team' => 'NW', 'code_name' => '' ],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'นายธนากร ทศราช (NW Test)', 'email' => 'Pain6Witee@gmail.com', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'phone_number' => '091-8759371', 'team' => 'NW', 'code_name' => '' ],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'น.ส.เยาวลักษณ์ แสงแก้ว (NW Test)', 'email' => 'khao-1984@hotmail.com', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'phone_number' => '087-8708174', 'team' => 'NW', 'code_name' => '' ],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'นายวัชระ เชื้อวณิชชากร (ST Test)', 'email' => 'wiper_master@hotmail.com', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'phone_number' => '082-0599360', 'team' => 'ST', 'code_name' => '' ],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'นายพิษณุพงศ์ ติลเชษฐ์ (ST Test)', 'email' => 'art_kung99@hotmail.com', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'phone_number' => '081-4416523', 'team' => 'ST', 'code_name' => '' ],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'name' => 'นายอนรรฆ รามโกมุท (ST Test)', 'email' => 'anak.ramakomut@gmail.com', 'password' => '$2y$10$ohz7BaVmOXwXOz69A37mfulPHee9lx32Jozk8lBKtb7JK6mzsLLwW', 'phone_number' => '086-3601587', 'team' => 'ST', 'code_name' => '' ],

		);
		
		DB::table('users')->insert($root);
        DB::table('users')->insert($test_user);
        DB::table('users')->insert($user);
    }
}
