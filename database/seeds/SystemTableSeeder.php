<?php

use Illuminate\Database\Seeder;

class SystemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $systems = array(
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานจดทะเบียนสิทธิและนิติกรรม', 'flag' => 'REG', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบบริหารงานช่างในสำนักงานที่ดิน', 'flag' => 'SVA', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานคำนวณรังวัด', 'flag' => 'SVC', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานสารบรรณ', 'flag' => 'CTN', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานงบประมาณ', 'flag' => 'BPM', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานบุคลากร', 'flag' => 'HRM', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'กลุ่มงานวิชาการ', 'flag' => 'EXP', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานตรวจสอบภายใน', 'flag' => 'INA', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานวัสดุ-ครุภัณฑ์', 'flag' => 'INV', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานการเงินและบัญชีในสำนักงานที่ดิน', 'flag' => 'FIN', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานให้บริการข้อมูลสอบถามข้อมูลที่ดินในสำนักงานที่ดิน และผ่านเครือข่าย Internet', 'flag' => 'LIS', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานให้บริการข้อมูลภูมิสารสนเทศ', 'flag' => 'GSS', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานให้บริการข้อมูล Meta Data', 'flag' => 'MTD', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบนำเข้าและส่งออกข้อมูลภูมิสารสนเทศ', 'flag' => 'IES', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบจัดการสิทธิของผู้ใช้ระบบ', 'flag' => 'ADM', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบสำรองจัดเก็บข้อมูล', 'flag' => 'BCK', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานสนับสนุนการปฏิบัติงานของศูนยฺสารสนเทศที่ดิน และหน่วยงานส่วนกลาง', 'flag' => 'SPC', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบแลกเปลี่ยนข้อมูลผ่านเครือข่าย Intranet/Internet กับหน่วยงานภายในและภายนอก กรมที่ดิน', 'flag' => 'ECH', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานควบคุมและจัดเก็บหลักฐานที่ดิน', 'flag' => 'EVD', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบปรับปรุงราคาประเมิน', 'flag' => 'APS', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานจดทะเบียนสิทธิและนิติกรรมต่างสำนักงานที่ดินแบบ Online', 'flag' => 'ONL', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบรับชำระเงินค่าใช้จ่ายในการจดทะเบียนสิทธิ และนิติกรรมผ่านช่องทาง e-Payment', 'flag' => 'EPA', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบการรักษาความปลอดภัยให้เป็นไปตามพระราชบัญญัติว่าด้วยธุรกรรมทางอิเล็กทรอนิกส์ พ.ศ.2544', 'flag' => 'ESP', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานสนับสนุนการปฏิบัติงานด้านการบริหารของหน่วยงานส่วนกลาง (สำนัก/กอง)', 'flag' => 'MSS', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานกองพัสดุ', 'flag' => 'USP', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานจัดหา', 'flag' => 'PRC', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานคลังพัสดุ', 'flag' => 'WAH', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานยานพาหนะ', 'flag' => 'VEH', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานตรวจสอบและซ่อมแซม', 'flag' => 'MTN', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานแบบแผน', 'flag' => 'BLD', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบสนับสนุนการปฏิบัติงานด้านการบริหารของหน่วยงานส่วนกลาง (สำนัก/กอง)', 'flag' => 'MIS', 'phase' => '1'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'โปรแกรมปรับปรุงรูปแผนที่ลงระวางดิจิทัล', 'flag' => 'SDM', 'phase' => '2'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'โปรแกรมเชื่อมโยงข้อมูลรูปแปลงที่ดินกับโปรแกรมจดทะเบียนสิทธิและนิติกรรม', 'flag' => 'MRI', 'phase' => '2'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'โปรแกรมนำเข้าข้อมูลภาพลักษณ์เอกสารสิทธิที่ดิน', 'flag' => 'EDM', 'phase' => '2'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'โปรแกรมนาเข้า/ส่งออกข้อมูลเชิงพื้นที่', 'flag' => 'SDX', 'phase' => '2'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'โปรแกรมให้บริการข้อมูลที่ดินและแผนที่', 'flag' => 'LMS', 'phase' => '2'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'โปรแกรมการใช้ประโยชน์ที่ดิน(LUS)และระบบเชื่อมโยงข้อมูลแผนที่บน QGIS Desktop', 'flag' => 'LUS', 'phase' => '2'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบคลังภาพออร์โท', 'flag' => 'OMW', 'phase' => '2'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'โปรแกรมจัดการข้อมูลให้บริการข้อมูลที่ดินและแผนที่', 'flag' => 'DMS', 'phase' => '2'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบการสำรองข้อมูล', 'flag' => 'BCK', 'phase' => '2'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบจัดการสิทธิ', 'flag' => 'ADM', 'phase' => '2'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานจดทะเบียนสิทธิและนิติกรรม', 'flag' => 'REG', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบบริหารงานช่างในสำนักงานที่ดิน', 'flag' => 'SVA', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานคำนวณรังวัด', 'flag' => 'SVC', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานสารบรรณ', 'flag' => 'CTN', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานงบประมาณ', 'flag' => 'BPM', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานบุคลากร', 'flag' => 'HRM', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'กลุ่มงานวิชาการ', 'flag' => 'EXP', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานตรวจสอบภายใน', 'flag' => 'INA', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานวัสดุ-ครุภัณฑ์', 'flag' => 'INV', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานการเงินและบัญชีในสำนักงานที่ดิน', 'flag' => 'FIN', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานให้บริการข้อมูลสอบถามข้อมูลที่ดินในสำนักงานที่ดิน และผ่านเครือข่าย Internet', 'flag' => 'LIS', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานให้บริการข้อมูลภูมิสารสนเทศ', 'flag' => 'GSS', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานให้บริการข้อมูล Meta Data', 'flag' => 'MTD', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบนำเข้าและส่งออกข้อมูลภูมิสารสนเทศ', 'flag' => 'IES', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบจัดการสิทธิของผู้ใช้ระบบ', 'flag' => 'ADM', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบสำรองจัดเก็บข้อมูล', 'flag' => 'BCK', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานสนับสนุนการปฏิบัติงานของศูนยฺสารสนเทศที่ดิน และหน่วยงานส่วนกลาง', 'flag' => 'SPC', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบแลกเปลี่ยนข้อมูลผ่านเครือข่าย Intranet/Internet กับหน่วยงานภายในและภายนอก กรมที่ดิน', 'flag' => 'ECH', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานควบคุมและจัดเก็บหลักฐานที่ดิน', 'flag' => 'EVD', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบปรับปรุงราคาประเมิน', 'flag' => 'APS', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานจดทะเบียนสิทธิและนิติกรรมต่างสำนักงานที่ดินแบบ Online', 'flag' => 'ONL', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบรับชำระเงินค่าใช้จ่ายในการจดทะเบียนสิทธิ และนิติกรรมผ่านช่องทาง e-Payment', 'flag' => 'EPA', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบการรักษาความปลอดภัยให้เป็นไปตามพระราชบัญญัติว่าด้วยธุรกรรมทางอิเล็กทรอนิกส์ พ.ศ.2544', 'flag' => 'ESP', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานสนับสนุนการปฏิบัติงานด้านการบริหารของหน่วยงานส่วนกลาง (สำนัก/กอง)', 'flag' => 'MSS', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานกองพัสดุ', 'flag' => 'USP', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานจัดหา', 'flag' => 'PRC', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานคลังพัสดุ', 'flag' => 'WAH', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานยานพาหนะ', 'flag' => 'VEH', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานตรวจสอบและซ่อมแซม', 'flag' => 'MTN', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบงานแบบแผน', 'flag' => 'BLD', 'phase' => '4'],
['created_at' => new DateTime, 'updated_at' => new DateTime, 'create_user_id' => 1, 'name' => 'ระบบสนับสนุนการปฏิบัติงานด้านการบริหารของหน่วยงานส่วนกลาง (สำนัก/กอง)', 'flag' => 'MIS', 'phase' => '4'],

        );
		
        DB::table('systems')->insert($systems);
    }
}
