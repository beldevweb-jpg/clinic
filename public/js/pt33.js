$(document).ready(function () {

    console.log('PT33 JS Loaded');

    $('#medicSelect').select2({
        placeholder: 'ค้นหาหรือเลือกแพทย์',
        allowClear: true,
        width: '350px'
    });


    $('#medicSelect').on('change', function () {

        const option = $(this).find(':selected');

        $('#medic_id').val(option.val());

        $('#doctorLicense').text(option.data('license') || '');


        // ล้าง checkbox
        $('input[name="profession[]"]')
            .prop('checked', false)
            .prop('disabled', true);


        let professions = option.attr('data-professions') || [];

        if (typeof professions === 'string') {
            professions = JSON.parse(professions);
        }


        professions.forEach(function (profession) {

            $('input[name="profession[]"][value="' + profession + '"]')
                .prop('checked', true);

        });

    });


});


// เอาส่วนนี้ออก ❌
// $('#pt33Form').on('submit', function () {
//     $('input[name="profession[]"]').prop('disabled', false);
// });
$('#pt33Form').on('submit', function () {

    $('input[name="profession[]"]').prop('disabled', false);

});

$('#patientSelect').select2({
    placeholder: 'ค้นหาหรือเลือกผู้ป่วย',
    allowClear: true,
    width: '350px'
});

$('#patientSelect').on('change', function () {

    const option = $(this).find(':selected');

    $('#patient_id').val(option.val());

    $('#patient_name').val(option.data('name') || '');

    $('#age').val(option.data('age') || '');

    $('#nationality').val(option.data('nationality') || '');

    $('#idcard').val(option.data('cid') || '');

});

function calculateTotal() {

    const gram = parseFloat($('#gram').val()) || 0;
    const days = parseInt($('#days').val()) || 0;

    const total = gram * days;

    $('#total').val(total.toFixed(2));

}

$('#gram, #days').on('input', calculateTotal);