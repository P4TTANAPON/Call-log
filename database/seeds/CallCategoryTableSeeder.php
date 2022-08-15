<?php

use Illuminate\Database\Seeder;

class CallCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $call_categories = array(
['id' => 1, 'created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'code' => '101', 'service_type' => 'Maintenance Service', 'problem_group' => 'โปรแกรมผิดพลาด (BUG)', 'description' => 'ปัญหาที่เกิดจากโปรแกรมทำงานผิดพลาดเนื่องจาก Error จากตัวโปรแกรมเอง เช่น เกิด Error Code, โปรแกรมแจ้งเกิดการผิดพลาด หรือไม่ได้เขียนดักข้อผิดพลาดไว้ ตัวอย่างเช่น ต้องป้อนวันที่ แต่ลูกค้าป้อนเป็นตัวเลข ทำให้เกิด Error ฯลฯ'],
['id' => 2, 'created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'code' => '102', 'service_type' => 'Maintenance Service', 'problem_group' => 'Network/Link', 'description' => 'ปัญหาที่เกิดจากระบบเครือข่ายเชื่อมโยง เช่น Router, Switch และปัญหาจาก Link ของ Provider'],
['id' => 3, 'created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'code' => '103', 'service_type' => 'Maintenance Service', 'problem_group' => 'System', 'description' => 'ปัญหาที่เกิดจากระบบ Server หรืออุปกรณ์ที่ส่วนกลาง'],
['id' => 4, 'created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'code' => '104', 'service_type' => 'Maintenance Service', 'problem_group' => 'ฐานข้อมูล (Database)', 'description' => 'ปัญหาที่เกิดจากฐานข้อมูล เช่นโครงสร้างฐานข้อมูลผิดพลาด, ระบบฐานข้อมูลผิดพลาด หรือมีความจำเป็นต้องยกเลิก Fields บางส่วนเพื่อให้ลูกค้าสามารถใช้งานได้ ทั้งแบบแก้ไขได้ชั่วคราวและแก้ไขได้ถาวร, ไม่สามารถแก้ไขได้ด้วยพนักงาน Tier1 และ Tier2 แต่ต้องทำด้วยผู้ดูแลระบบฐานข้อมูล'],
['id' => 5, 'created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'code' => '105', 'service_type' => 'Maintenance Service', 'problem_group' => 'On Site Service', 'description' => 'ปัญหาที่เกิดขึ้นและไม่สามารถแก้ไขปัญหาด้วยโทรศัพท์หรือการ Remote ไปแก้ไขได้ จำเป็นต้องให้เจ้าหน้าที่ Teleport เข้าไปแก้ไขปัญหาหน้างาน (เฉพาะปัญหาประเภท CM : Corrective Maintenance เท่านั้น) เช่น UPS ไม่เก็บไฟ, PC มีปัญหา, Scanner ใช้งานไม่ได้, ระบบเครือข่ายขัดข้องที่ตรวจสอบแล้วไม่ได้เป็นที่ Link จาก Provider'],
['id' => 6, 'created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'code' => '201', 'service_type' => 'Operation Service', 'problem_group' => 'แนะนำการใช้งาน', 'description' => 'ลูกค้ามีการโทรมาสอบถามการใช้งาน ไม่ได้เป็นปัญหาหรือใช้งานไม่ได้ และสามารถให้คำแนะนำได้ในเบื้องต้น'],
['id' => 7, 'created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'code' => '202', 'service_type' => 'Operation Service', 'problem_group' => 'การใช้งาน (User Error)', 'description' => 'ปัญหาที่เกิดจากการใช้งาน Application Software ของลูกค้า (User Error) เช่น ทำผิดขั้นตอนแล้วระบบ Lock, ไม่สามารถไปต่อได้เนื่องจากใส่ข้อมูลไม่ครบ, ไม่ได้ตั้งค่าที่จำเป็นในการทำงาน, ตั้งค่าในการพิมพ์/สแกนผิด ฯลฯ'],
['id' => 8, 'created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'code' => '203', 'service_type' => 'Operation Service', 'problem_group' => 'ข้อมูล (Data)', 'description' => 'ปัญหาที่เกิดจากข้อมูลตั้งต้นไม่ถูกต้อง, ข้อมูลในฐานข้อมูลไม่ถูกต้อง ต้องเข้าไปแก้ไขข้อมูลให้ถูกต้องก่อน จึงจะสามารถทำงานต่อได้'],
['id' => 9, 'created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'code' => '204', 'service_type' => 'Operation Service', 'problem_group' => 'สิทธิ์ในการใช้งาน', 'description' => 'ปัญหาที่เกิดจากการเข้าสู่ระบบ(Login)/กำหนดสิทธิ์ และความปลอดภัยของระบบ เช่น ลูกค้าลืม Password, ลูกค้ามีการย้ายหรือไปช่วยงานต่างสำนักงานเดิม, การเพิ่มสิทธิ์, การปลดล๊อคสิทธิ์, การเปลี่ยน Password ที่หมดอายุ, การลบสิทธิ์การใช้งาน ฯลฯ'],
['id' => 10, 'created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'code' => '205', 'service_type' => 'Operation Service', 'problem_group' => 'IT Support', 'description' => 'ปัญหาที่ไม่ได้เกิดจาก Application Software หรือ Hardware แต่ทำให้ไม่สามารถใช้งานได้ เช่น ไวรัสลงเครื่อง, ลูกค้าใช้รุ่นของโปรแกรมพื้นฐานที่สูงไปกว่า Application Software จะทำงานได้ ต้อง Down Grade ลงมา, การเปลี่ยน IP, การเปลี่ยนชื่อ Computer หรือต้องลงโปรแกรมที่จำเป็นในการใช้งานอื่นๆ'],
['id' => 11, 'created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'code' => '301', 'service_type' => 'Undefine', 'problem_group' => 'แนะนำ/ติชม (Comment)', 'description' => 'ลูกค้ามีการติหรือชม ระบบ ทีมงาน ฯลฯ หรือแนะนำเรื่องต่างๆ เพื่อพัฒนาให้มีประสิทธิภาพขึ้น'],
['id' => 12, 'created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'code' => '302', 'service_type' => 'Undefine', 'problem_group' => 'อื่นๆ', 'description' => 'ปัญหาอื่นๆ ที่นอกเหนือจากกลุ่มปัญหาที่กำหนดไว้ ไม่สามารถระบุกลุ่มปัญหาได้ (อาจพิจารณาแตกเป็นกลุ่มปัญหาใหม่ได้)'],

		);
		
        DB::table('call_categories')->insert($call_categories);
    }
}
