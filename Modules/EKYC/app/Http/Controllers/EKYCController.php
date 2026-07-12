<?php

namespace Modules\EKYC\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Patient\Models\patient;
use Modules\EKYC\Services\SmartCardService;

class EKYCController extends Controller
{
    public function lookup(Request $request)
    {
        $request->validate([
            'cid' => 'required|string|max:13'
        ]);


        $patient = patient::where(
            'cid',
            $request->cid
        )->first();


        if ($patient) {

            return response()->json([
                'success' => true,
                'found' => true,
                'patient' => $patient
            ]);
        }


        return response()->json([
            'success' => true,
            'found' => false,
            'message' => 'ไม่พบข้อมูลผู้ป่วย'
        ]);
    }

    public function checkCard(SmartCardService $smartCard)
    {
        $card = $smartCard->read();


        if (!$card['success']) {

            return response()->json([
                'success' => false,
                'message' => 'ไม่สามารถอ่านบัตรได้'
            ]);
        }


        $cardData = $card['card'] ?? null;


        if (!$cardData) {

            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูลจาก Smart Card'
            ]);
        }


        // CardData เป็น Object
        $cid = $cardData->cid;


        $patient = Patient::where(
            'cid',
            $cid
        )->first();



        return response()->json([

            'success' => true,

            'found' => $patient ? true : false,


            'card' => [

                'cid' => $cardData->cid,

                'prefix' => $cardData->prefix,

                'firstname' => $cardData->firstname,

                'lastname' => $cardData->lastname,


                'firstname_en' => $cardData->firstname_en,

                'lastname_en' => $cardData->lastname_en,


                'birthday' => $cardData->birthday,

                'nationality' => $cardData->nationality,

                'gender' => $cardData->gender,


                'address' => $cardData->address,

                'province' => $cardData->province,

                'district' => $cardData->district,

                'subdistrict' => $cardData->subdistrict,

                'zipcode' => $cardData->zipcode,


                'card_issue_date' => $cardData->card_issue_date,

                'card_expire_date' => $cardData->card_expire_date,

                'card_photo' => $cardData->card_photo,

            ],


            'patient' => $patient

        ]);
    }
}
