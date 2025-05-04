@props(['form' => null])

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById('{{ $form }}');
        if (!form) return;

        const submitButton = form.querySelector('input[type="submit"]');
        submitButton.disabled = true

        const inputs = form.querySelectorAll("input, select, textarea");

        const originalValues = Array.from(inputs).map(input => input.value);
        const checkForChanges = () => {
            const hasChanges = Array.from(inputs).some((input, i) => input.value !== originalValues[i]);
            submitButton.disabled = !hasChanges;
        };

        const events = ["input", "change"];
        inputs.forEach(input => {
            events.forEach(e => {
                input.addEventListener(e, checkForChanges);
            });
        });
    });
</script>
