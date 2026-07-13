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

    document.querySelectorAll('[data-custom-select]').forEach(wrapper => {
        const hiddenInput = wrapper.querySelector('input[type="hidden"]');
        const searchInput = wrapper.querySelector('[data-search-input]');
        const dropdown = wrapper.querySelector('[data-dropdown]');
        const options = dropdown.querySelectorAll('[data-value]');

        if (hiddenInput.value) {
            const selectedOpt = Array.from(options).find(o => o.dataset.value === hiddenInput.value);
            if (selectedOpt) searchInput.value = selectedOpt.dataset.label;
        }

        const filterOptions = (term) => {
            let visibleCount = 0;
            const maxVisible = 5;

            options.forEach(opt => {
                const isMatch = opt.dataset.label.toLowerCase().includes(term);
                if (isMatch && visibleCount < maxVisible) {
                    opt.style.display = 'block';
                    visibleCount++;
                } else {
                    opt.style.display = 'none';
                }
            });
        };

        const closeDropdown = () => dropdown.classList.add('hidden');

        searchInput.addEventListener('focus', () => {
            searchInput.select();
            filterOptions('');
            dropdown.classList.remove('hidden');
        });

        searchInput.addEventListener('input', (e) => {
            filterOptions(e.target.value.toLowerCase());
            dropdown.classList.remove('hidden');
            hiddenInput.value = '';
        });

        options.forEach(opt => {
            opt.addEventListener('mousedown', (e) => {
                e.preventDefault();
                hiddenInput.value = opt.dataset.value;
                searchInput.value = opt.dataset.label;
                closeDropdown();
                filterOptions('');
            });
        });

        searchInput.addEventListener('blur', () => {
            closeDropdown();
            if (!hiddenInput.value) {
                searchInput.value = '';
            } else {
                const selectedOpt = Array.from(options).find(o => o.dataset.value === hiddenInput.value);
                if (selectedOpt) searchInput.value = selectedOpt.dataset.label;
            }
        });
    });
});
