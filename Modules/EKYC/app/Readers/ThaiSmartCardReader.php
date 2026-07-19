<?php

namespace Modules\EKYC\Readers;

use Illuminate\Support\Facades\Http;
use Modules\EKYC\Contracts\SmartCardReaderInterface;
use Modules\EKYC\DTO\CardData;

class ThaiSmartCardReader implements SmartCardReaderInterface
{

    private string $url = 'http://localhost:5000/api/card';

    public function connected(): bool
    {
        try {

            $response = Http::timeout(3)
                ->get($this->url . '/status');

            return $response->successful();
        } catch (\Exception $e) {

            \Log::error('SMARTCARD STATUS ERROR', [
                'message' => $e->getMessage()
            ]);

            return false;
        }
    }



    public function read(): ?CardData
    {
        try {

            $response = Http::timeout(10)
                ->get($this->url . '/read');


            \Log::info('SMARTCARD RESPONSE', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);


            if (!$response->successful()) {

                return null;
            }


            $data = $response->json();

            \Log::info('SMARTCARD JSON', $data);

            $card = $data['card'] ?? null;

            $cardData = new CardData(

                cid: $card['cid'] ?? '',

                prefix: $card['title'] ?? '',

                firstname: $card['firstname'] ?? '',

                lastname: $card['lastname'] ?? '',


                // English
                firstname_en: $card['firstname_en'] ?? '',

                lastname_en: $card['lastname_en'] ?? '',


                // Personal
                birthday: $card['birthday'] ?? null,

                gender: $card['gender'] ?? '',

                nationality: $card['nationality'] ?? '',


                // Address
                address: $card['address'] ?? '',

                province: $card['province'] ?? '',

                district: $card['district'] ?? '',

                subdistrict: $card['subdistrict'] ?? '',

                zipcode: $card['zipcode'] ?? '',


                // Card
                card_issue_date: $card['card_issue_date'] ?? null,

                card_expire_date: $card['card_expire_date'] ?? null,

                card_photo: $card['card_photo'] ?? null,

            );


            \Log::info('CARD DTO', $cardData->toArray());


            return $cardData;
        } catch (\Exception $e) {

            \Log::error('SMARTCARD READ ERROR', [
                'message' => $e->getMessage()
            ]);

            return null;
        }
    }
}
