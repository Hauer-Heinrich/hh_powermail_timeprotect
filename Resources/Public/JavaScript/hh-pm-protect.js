(function () {
    const forms = document.querySelectorAll("form");

    if(forms) {
        forms.forEach((form) => {
            const protectField = form.querySelector(".hh_powermail_tp");
            const submitField = form.querySelector(".powermail_submit");
            if(protectField && submitField) {
                const protectTpT = protectField.dataset.tp;
                const protectTpCountText = protectField.dataset.countText;
                submitField.classList.add("hidden");

                startCountdown(protectTpT, submitField.parentElement, protectTpCountText);

                setTimeout(function() {
                    submitField.classList.remove("hidden");
                }, protectTpT * 1000);
            }
        });
    }

    function startCountdown(seconds, element, text = '') {
        let counter = parseInt(seconds);
        let div = document.createElement('div');
        div.classList.add('counter', 'submit-counter');
        element.appendChild(div);

        const interval = setInterval(() => {
            div.innerHTML = text + " " + counter;
            counter--;

            if (counter == 0 ) {
                clearInterval(interval);
                div.innerHTML = '';
                div.classList.add("hidden");
            }
        }, 1000);
    }
})();
