document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("patientForm");

    if (!form) return;


    form.addEventListener("submit", function (e) {

        e.preventDefault();


        Swal.fire({
            title: "ยืนยันการบันทึก?",
            text: "ต้องการบันทึกข้อมูลใช่หรือไม่",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "บันทึก",
            cancelButtonText: "ยกเลิก"
        })
            .then((result) => {


                if (result.isConfirmed) {


                    const btn = form.querySelector('.btn-save');


                    if (btn) {

                        btn.disabled = true;
                        btn.innerHTML = "⏳ กำลังบันทึก...";

                    }


                    // ส่งฟอร์มจริง
                    form.submit();


                } else {


                    const btn = form.querySelector('.btn-save');


                    if (btn) {

                        btn.disabled = false;
                        btn.innerHTML = "💾 บันทึกข้อมูล";

                    }


                }


            });


    });


});

function setField(name, value) {

    const field = document.querySelector(`[name="${name}"]`);

    if (field) {

        field.value = value ?? '';

    }

}

function translateNationality(nationality) {

    const map = {

        'TH': 'ไทย',
        'Thai': 'ไทย',
        'THAI': 'ไทย',
        'Thailand': 'ไทย',

        'MM': 'เมียนมา',
        'Myanmar': 'เมียนมา',
        'MYANMAR': 'เมียนมา',

        'LA': 'ลาว',
        'Laos': 'ลาว',
        'LAO': 'ลาว',

        'KH': 'กัมพูชา',
        'Cambodia': 'กัมพูชา',
        'CAMBODIA': 'กัมพูชา',

        'CN': 'จีน',
        'China': 'จีน',
        'CHINESE': 'จีน',

        'JP': 'ญี่ปุ่น',
        'Japan': 'ญี่ปุ่น',

        'KR': 'เกาหลี',
        'Korea': 'เกาหลี',

        'US': 'สหรัฐอเมริกา',
        'USA': 'สหรัฐอเมริกา',
        'American': 'อเมริกัน'

    };


    return map[nationality] ?? nationality ?? '';
}


function fillPatient(card) {


    // รองรับทั้ง Laravel DTO และ .NET API
    card.prefix = card.prefix ?? card.title;


    setField('cid', card.cid);

    setField('prefix', card.prefix);

    setField('firstname', card.firstname);

    setField('lastname', card.lastname);


    // English name
    setField('firstname_en', card.firstname_en);

    setField('lastname_en', card.lastname_en);


    setField('birthday', card.birthday);


    setField(
        'nationality',
        translateNationality(card.nationality)
    );


    let gender = '';

    if (card.gender == 'M' || card.gender == 'ชาย') {
        gender = 'ชาย';
    }
    else if (card.gender == 'F' || card.gender == 'หญิง') {
        gender = 'หญิง';
    }


    setField('gender', gender);


    // Address
    setField('address', card.address);

    setField('province', card.province);

    setField('district', card.district);

    setField('subdistrict', card.subdistrict);

    setField('zipcode', card.zipcode);



    if (card.birthday) {

        setField(
            'age',
            calculateAge(card.birthday)
        );

    }

}


window.readCard = async function () {

    try {

        Swal.fire({
            title: "กำลังอ่านบัตร",
            text: "กรุณารอสักครู่",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });


        const response = await fetch(
            'http://localhost:5000/api/card/read'
        );

        const data = await response.json();


        Swal.close();


        console.log(data);


        if (!data.success) {

            Swal.fire(
                "ผิดพลาด",
                data.message ?? "อ่านบัตรไม่สำเร็จ",
                "error"
            );

            return;
        }


        // ตรวจสอบ CID กับ Laravel

        const check = await fetch(
            `/patient/check-cid/${data.card.cid}`
        );


        const patientCheck = await check.json();



        if (patientCheck.exists) {

            Swal.fire({
                title: "มีข้อมูลบัตรนี้แล้ว",
                text: "ต้องการดูข้อมูลผู้ป่วยหรือไม่",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "ดูข้อมูล"
            }).then((result) => {

                if (result.isConfirmed) {

                    window.location.href =
                        `/patient/${patientCheck.patient.id}`;

                }

            });


            return;
        }


        fillPatient(data.card);


        Swal.fire(
            "สำเร็จ",
            "เติมข้อมูลจากบัตรแล้ว",
            "success"
        );


    } catch (e) {

        Swal.close();

        console.error(e);


        Swal.fire(
            "Error",
            "ไม่พบโปรแกรมอ่านบัตร กรุณาเปิด ThaiSmartCardService",
            "error"
        );

    }

};

function calculateAge(birthday) {

    let birthDate = new Date(birthday);

    let today = new Date();


    let age =
        today.getFullYear()
        -
        birthDate.getFullYear();


    let month =
        today.getMonth()
        -
        birthDate.getMonth();


    if (
        month < 0 ||
        (
            month === 0 &&
            today.getDate() < birthDate.getDate()
        )
    ) {

        age--;

    }


    return age;

}