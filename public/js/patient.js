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

                    form.submit();

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


function fillPatient(card) {

    setField('cid', card.cid);

    setField('prefix', card.prefix);

    setField('firstname', card.firstname);

    setField('lastname', card.lastname);


    // English name
    setField('firstname_en', card.firstname_en);

    setField('lastname_en', card.lastname_en);


    setField('birthday', card.birthday);

    setField('nationality', card.nationality);

    setField(
        'gender',
        card.gender === 'M' ? 'ชาย' : 'หญิง'
    );


    // Address
    setField('address', card.address);

    setField('province', card.province);

    setField('district', card.district);

    setField('subdistrict', card.subdistrict);

    setField('zipcode', card.zipcode);


    // Card information
    setField('card_issue_date', card.card_issue_date);

    setField('card_expire_date', card.card_expire_date);



    // คำนวณอายุ
    if (card.birthday) {

        const birthDate = new Date(card.birthday);

        const today = new Date();

        let age =
            today.getFullYear()
            -
            birthDate.getFullYear();


        const month =
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


        setField('age', age);
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


        const response = await fetch('/ekyc/check-card');


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
            "ไม่สามารถเชื่อมต่อ Smart Card ได้",
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