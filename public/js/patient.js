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
        }).then((result) => {

            if (result.isConfirmed) {
                form.submit();
            }

        });

    });

});