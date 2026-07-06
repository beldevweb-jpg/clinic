@extends('core::components.layouts.master')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/pt33.css') }}">

    <div class="a4">

        <!-- HEADER -->
        <div class="header">

            <!-- ซ้าย -->
            <div class="left"></div>

            <!-- กลาง -->
            <div class="center">
                <h2>ใบส่งจ่ายสมุนไพรควบคุม (กัญชา)</h2>
                <div class="date-line">วันที่ ........................</div>
            </div>

            <!-- ขวาบน -->
            <div class="right-top">แบบ ภ.ท.๓๓</div>

        </div>

        <br>
        <br>

        <!-- ผู้ป่วย -->
        <div class="row">
            <label>ข้าพเจ้า</label>
            <span class="fill-line"></span>
        </div>

        <div class="row wrap">
            <label>ผู้ประกอบวิชาชีพ:</label>

            <label><input type="checkbox" value="medicine"> เวชกรรม</label>
            <label><input type="checkbox" value="TTM"> แพทย์แผนไทย</label>
            <label><input type="checkbox" value="ATTM"> แพทย์แผนไทยประยุกต์</label>
            <label><input type="checkbox" value="Dentist"> ทันตกรรม</label>
            <label><input type="checkbox" value="pharmacy"> เภสัชกรรม</label>
            <label><input type="checkbox" value="TCM"> แพทย์แผนจีน</label>
            <label><input type="checkbox" value="TMT"> หมอพื้นบ้าน</label>
        </div>

        <div class="row">
            <label>ใบอนุญาตเลขที่</label>
            <span class="fill-line"></span>
        </div>

        <div class="row">
            <label>ที่อยู่</label>
            <span class="fill-line"></span>
        </div>

        <div class="row">
            <label>อายุ</label>
            <span class="fill-line small-line"></span>

            <label>สัญชาติ</label>
            <span class="fill-line small-line"></span>
        </div>

        <div class="row">
            <label>เลขบัตรประชาชน/หนังสือเดินทาง</label>
            <span class="fill-line"></span>
        </div>

        <hr>

        <!-- DIAGNOSIS -->
        <h4>การวินิจฉัยกลุ่มโรค/อาหาร</h4>

        <div class="box">
            <div class="grid">
                <label><input value="chronic_pain" type="checkbox"> ปวดเรื้อรัง</label>
                <label><input value="cancer" type="checkbox"> โรคมะเร็ง</label>
                <label><input value="Insomnia" type="checkbox"> นอนไม่หลับ</label>
                <label><input value="chorea" type="checkbox"> กระดูก</label>
                <label><input value="nausea_vomiting" type="checkbox"> คลื่นไส้อาเจียน</label>
                <label><input value="anorexia" type="checkbox"> เบื่ออาหาร</label>
                <label><input value="cramp" type="checkbox"> ตะคริว</label>
                <label><input value="parkinson's" type="checkbox"> พาร์กินสัน</label>
                <label><input value="GAD" type="checkbox"> วิตกกังวล</label>
                <label><input value="mechanical" type="checkbox"> ปวดข้อ</label>
                <label><input value="epilepsy" type="checkbox"> ลมชัก</label>
                <label><input value="alzheimer's" type="checkbox"> อัลไซเมอร์</label>
                <label><input value="MPS" type="checkbox"> กล้ามเนื้อหดเกร็ง</label>
                <label><input value="asthma" type="checkbox"> หอบหืด</label>
                <label><input value="depression" type="checkbox"> ซึมเศร้า</label>
            </div>

            <div class="row">
                <label>อื่นๆ</label>
                <span class="fill-line"></span>
            </div>
        </div>

        <br>

        <!-- DOSAGE -->
        <div class="row">
            <label>สมควรได้รับกัญชา (ต่อวัน)</label>
        </div>

        <div class="row">
            <label>จำนวน (กรัม)</label>
            <span class="fill-line small-line"></span>

            <label>จำนวนวัน</label>
            <span class="fill-line small-line"></span>

            <label>รวมทั้งหมด</label>
            <span class="fill-line small-line"></span>
        </div>

        <p>หมายเหตุ: ให้ได้ไม่เกิน ๓๐ วันต่อ ๑ ครั้งการสั่งจ่าย</p>

        <br>

        <!-- SIGN -->
        <div class="sign">
            <div>ลงชื่อผู้สั่งจ่าย __________________________</div>
            <div>ลงชื่อผู้รับยา __________________________</div>
        </div>

        <br>

        <p class="note">
            แบบใบสั่งจ่ายนี้ให้เก็บไว้ ณ สถานที่จ่ายยาเป็นเวลา ๑ ปี
        </p>

    </div>
@endsection
