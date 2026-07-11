document.addEventListener("DOMContentLoaded", function () {

    console.log('PT33 JS Loaded');


    /* =========================
        Medic Select
    ========================= */

    const medicSelect = new TomSelect("#medicSelect", {

        create: false,

        placeholder: "ค้นหาหรือเลือกแพทย์",

        maxOptions: 50

    });


    document
    .querySelector("#medicSelect")
    .addEventListener("change", function () {


        const option = this.options[this.selectedIndex];


        document.getElementById('medic_id').value =
            option.value;


        document.getElementById('doctorLicense').value =
            option.dataset.license || '';



        // reset profession

        document
        .querySelectorAll('input[name="profession[]"]')
        .forEach(function(item){

            item.checked = false;

            item.disabled = true;

        });



        let professions =
            option.dataset.professions || "[]";



        professions = JSON.parse(professions);



        professions.forEach(function(profession){


            let checkbox =
                document.querySelector(
                    'input[name="profession[]"][value="' + profession + '"]'
                );


            if(checkbox){

                checkbox.checked = true;

                checkbox.disabled = false;

            }


        });


    });





    /* =========================
        Patient Select
    ========================= */


    const patientSelect = new TomSelect("#patientSelect", {


        create:false,

        placeholder:"ค้นหา HN / ชื่อ / เลขบัตร",

        maxOptions:50


    });



    document
    .querySelector("#patientSelect")
    .addEventListener("change", function(){


        const option = this.options[this.selectedIndex];


        document.getElementById('patient_id').value =
            option.value;



        document.getElementById('patient_name').value =
            option.dataset.name || '';



        document.getElementById('age').value =
            option.dataset.age || '';



        document.getElementById('nationality').value =
            option.dataset.nationality || '';



        document.getElementById('idcard').value =
            option.dataset.cid || '';



    });







    /* =========================
        Calculate Total
    ========================= */


    const gram =
        document.getElementById('gram');


    const days =
        document.getElementById('days');


    const total =
        document.getElementById('total');



    function calculateTotal(){


        let g =
            parseFloat(gram.value) || 0;


        let d =
            parseInt(days.value) || 0;



        total.value =
            (g * d).toFixed(2);


    }



    gram.addEventListener(
        'input',
        calculateTotal
    );


    days.addEventListener(
        'input',
        calculateTotal
    );


    calculateTotal();





    /* =========================
        Submit
    ========================= */


    document
    .getElementById('pt33Form')
    .addEventListener('submit', function(){


        document
        .querySelectorAll('input[name="profession[]"]')
        .forEach(function(item){


            item.disabled = false;


        });


    });



});