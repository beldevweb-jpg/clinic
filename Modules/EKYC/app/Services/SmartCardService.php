<?php

namespace Modules\EKYC\Services;

use Modules\EKYC\Contracts\SmartCardReaderInterface;


class SmartCardService
{

    public function __construct(
        protected SmartCardReaderInterface $reader
    ) {}



    public function status(): array
    {
        return [

            'success' => true,

            'reader' => $this->reader->connected(),

            'card' => false,

            'message' => 'Smart Card Reader พร้อมใช้งาน'

        ];
    }



    public function read(): array
    {

        if (!$this->reader->connected()) {

            return [

                'success' => false,

                'message' => 'ไม่พบเครื่องอ่านบัตร'

            ];

        }


        $card = $this->reader->read();



        return [

            'success' => true,

            'card' => $card

        ];

    }

}