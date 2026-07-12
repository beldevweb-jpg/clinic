<?php

namespace Modules\EKYC\DTO;


class CardData
{
    public function __construct(

        // ข้อมูลหลัก
        public string $cid,

        public string $prefix,

        public string $firstname,

        public string $lastname,


        // ข้อมูลภาษาอังกฤษจากบัตร
        public ?string $firstname_en = null,

        public ?string $lastname_en = null,


        // วันเกิด
        public ?string $birthday = null,


        // ข้อมูลทั่วไป
        public ?string $gender = null,

        public ?string $nationality = null,


        // ที่อยู่
        public ?string $address = null,

        public ?string $province = null,

        public ?string $district = null,

        public ?string $subdistrict = null,

        public ?string $zipcode = null,


        // ข้อมูลบัตร
        public ?string $card_issue_date = null,

        public ?string $card_expire_date = null,


        // รูปจากบัตร
        public ?string $card_photo = null,

    ) {}

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
