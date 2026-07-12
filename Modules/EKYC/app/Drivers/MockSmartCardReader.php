<?php

namespace Modules\EKYC\Drivers;

use Modules\EKYC\Contracts\SmartCardReaderInterface;
use Modules\EKYC\DTO\CardData;


class MockSmartCardReader implements SmartCardReaderInterface
{

    public function connected(): bool
    {
        return true;
    }


    public function read(): ?CardData
    {
        return new CardData(

            cid: '1101700201234',

            prefix: 'นาย',

            firstname: 'สมชาย',

            lastname: 'ทดสอบ',


            firstname_en: 'SOMCHAI',

            lastname_en: 'TEST',


            birthday: '1995-01-01',

            gender: 'ชาย',

            nationality: 'ไทย',


            address: '99 ถนนสุขุมวิท',

            province: 'กรุงเทพมหานคร',

            district: 'วัฒนา',

            subdistrict: 'คลองตัน',

            zipcode: '10110',


            card_issue_date: '2024-01-01',

            card_expire_date: '2034-01-01',


            card_photo: null

        );
    }


    public function connect(): bool
    {
        return true;
    }


    public function disconnect(): bool
    {
        return true;
    }
}
