/**
 * Gestionnaire du Formulaire de Don Intelligent (Innovations 2 & 3)
 */

document.addEventListener('DOMContentLoaded', () => {
    const amountInput = document.getElementById('montant');
    const presetBtns = document.querySelectorAll('.preset-btn');
    const optionPonctuel = document.getElementById('option-ponctuel');
    const optionRecurrent = document.getElementById('option-recurrent');
    const frequencyGroup = document.getElementById('recurring-frequency-group');

    // 1. Boutons de montants prédéfinis
    if (presetBtns && amountInput) {
        presetBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                presetBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                amountInput.value = btn.dataset.amount;
            });
        });

        amountInput.addEventListener('input', () => {
            presetBtns.forEach(b => {
                if (b.dataset.amount === amountInput.value) {
                    b.classList.add('active');
                } else {
                    b.classList.remove('active');
                }
            });
        });
    }

    // 2. Bascule Don Ponctuel / Récurrent
    if (optionPonctuel && optionRecurrent && frequencyGroup) {
        optionPonctuel.addEventListener('click', () => {
            optionPonctuel.classList.add('active');
            optionRecurrent.classList.remove('active');
            frequencyGroup.classList.add('hidden');
        });

        optionRecurrent.addEventListener('click', () => {
            optionRecurrent.classList.add('active');
            optionPonctuel.classList.remove('active');
            frequencyGroup.classList.remove('hidden');
        });
    }

});
