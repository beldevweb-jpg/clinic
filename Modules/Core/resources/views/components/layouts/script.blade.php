<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('form').forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (this.dataset.allowMultiple === 'true') {
                    return;
                }

                if (this.dataset.submitted === 'true') {
                    event.preventDefault();
                    return;
                }

                this.dataset.submitted = 'true';

                this.querySelectorAll('button[type="submit"], input[type="submit"]').forEach(function (control) {
                    if (control.disabled) {
                        return;
                    }

                    control.disabled = true;

                    if (control.tagName === 'BUTTON') {
                        if (!control.dataset.originalHtml) {
                            control.dataset.originalHtml = control.innerHTML;
                        }
                        control.innerHTML = control.dataset.originalHtml + ' (กำลังส่ง...)';
                    }

                    if (control.tagName === 'INPUT') {
                        if (!control.dataset.originalValue) {
                            control.dataset.originalValue = control.value;
                        }
                        control.value = control.dataset.originalValue + ' (กำลังส่ง...)';
                    }
                });
            });
        });
    });
</script>
