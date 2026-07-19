<?php

namespace Modules\EKYC\Services;

use Illuminate\Support\Facades\Http;
use Modules\EKYC\Contracts\SmartCardReaderInterface;
use Modules\EKYC\DTO\CardData;


class ThaiSmartCardReader implements SmartCardReaderInterface
{

    protected string $url = 'http://localhost:5268';



    public function connected(): bool
    {
        try {

            $response = Http::get(
                $this->url . '/api/card/status'
            );


            return $response->json('connected') ?? false;


        } catch (\Exception $e) {

            return false;
        }
    }




    public function read(): ?CardData
    {

        try {

            $response = Http::get(
                $this->url . '/api/card/read'
            );


            if (!$response->successful()) {

                return null;

            }



            $card = $response->json('card');



            if (!$card) {

                return null;

            }



            return new CardData(

                cid: $card['cid'],

                prefix: $card['title'] ?? null,

                firstname: $card['firstname'] ?? null,

                lastname: $card['lastname'] ?? null,


                firstname_en: $card['firstname_en'] ?? null,

                lastname_en: $card['lastname_en'] ?? null,


                birthday: $card['birthday'] ?? null,


                gender: $card['gender'] ?? null,

                nationality: $card['nationality'] ?? null,


                address: $card['address'] ?? null,

                province: $card['province'] ?? null,

                district: $card['district'] ?? null,

                subdistrict: $card['subdistrict'] ?? null,

                zipcode: $card['zipcode'] ?? null,


                card_issue_date: $card['card_issue_date'] ?? null,

                card_expire_date: $card['card_expire_date'] ?? null,


                card_photo: $card['card_photo'] ?? null,

            );


        } catch (\Exception $e) {

            return null;

        }

    }

}