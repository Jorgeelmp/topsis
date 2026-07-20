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

    const openModalButtons = document.querySelectorAll('[data-modal-open]');
    const closeModalButtons = document.querySelectorAll('[data-modal-close], [data-modal-backdrop]');

    openModalButtons.forEach(button => {
        button.addEventListener('click', () => {
            const modalId = button.dataset.modalOpen;
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');

                setTimeout(() => {
                    modal.querySelector('[data-modal-backdrop]').classList.remove('opacity-0');
                    const panel = modal.querySelector('[data-modal-panel]');
                    panel.classList.remove('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
                }, 10);
            }
        });
    });

    closeModalButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            const modal = e.target.closest('[data-modal]');
            if (modal) {
                modal.querySelector('[data-modal-backdrop]').classList.add('opacity-0');
                const panel = modal.querySelector('[data-modal-panel]');
                panel.classList.add('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');

                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }
        });
    });

    const criteriaWeightsModal = document.getElementById('criteria-weights-modal');
    if (criteriaWeightsModal) {
        const sliders = criteriaWeightsModal.querySelectorAll('input[type="range"]');
        const totalDisplay = document.getElementById('weights-total');
        const errorText = document.getElementById('weights-error');
        const applyBtn = document.getElementById('apply-weights-btn');
        const searchForm = document.getElementById('search-form');

        function updateWeightsTotal() {
            let sum = 0;
            sliders.forEach(slider => {
                sum += parseFloat(slider.value) || 0;
            });

            if (totalDisplay) totalDisplay.textContent = sum.toFixed(2);

            const isValid = Math.abs(sum - 1.0) < 0.001;

            if (isValid) {
                if (totalDisplay) {
                    totalDisplay.classList.remove('text-red-600');
                    totalDisplay.classList.add('text-slate-900');
                }
                if (errorText) errorText.classList.add('hidden');
                if (applyBtn) {
                    applyBtn.disabled = false;
                    applyBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            } else {
                if (totalDisplay) {
                    totalDisplay.classList.remove('text-slate-900');
                    totalDisplay.classList.add('text-red-600');
                }
                if (errorText) errorText.classList.remove('hidden');
                if (applyBtn) {
                    applyBtn.disabled = true;
                    applyBtn.classList.add('opacity-50', 'cursor-not-allowed');
                }
            }

            return isValid;
        }

        sliders.forEach(slider => {
            slider.addEventListener('input', updateWeightsTotal);
        });

        updateWeightsTotal();

        if (searchForm) {
            searchForm.addEventListener('submit', function (e) {
                if (!updateWeightsTotal()) {
                    e.preventDefault();
                    criteriaWeightsModal.classList.remove('hidden');
                    alert("A soma dos pesos dos critérios deve ser exatamente 1.00.");
                }
            });
        }
    }
});
