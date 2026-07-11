document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('input[type="range"]').forEach((slider) => {
        const output = document.getElementById(`${slider.id}-output`);
        if (!output) return;

        const update = () => {
            output.textContent = parseFloat(slider.value).toFixed(2);
        };

        slider.addEventListener('input', update);
        update();
    });
});
