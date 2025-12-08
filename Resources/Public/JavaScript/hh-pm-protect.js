(function () {
    const forms = document.querySelectorAll("form");

    if(forms) {
        // Spam Protection output TODO: WORKAROUND, see https://github.com/in2code-de/powermail/issues/1252
        const params = new URLSearchParams(window.location.search);
        const isSpam = params.get("timeprotect") === "spam";

        forms.forEach((form) => {
            const protectField = form.querySelector(".hh_powermail_tp");
            const submitField = form.querySelector("[type='submit']");

            // Spam Protection output TODO: WORKAROUND, see above!
            if (isSpam) {
                const message = document.createElement("div");
                message.classList.add("spam-warning");
                message.innerText = "Es wurde verdächtiges Verhalten erkannt. Das Formular konnte nicht abgeschickt werden.";
                submitField.parentElement.prepend(message);
            }

            if(protectField && submitField) {
                const protectTpT = protectField.dataset.tp;
                const protectTpCountText = protectField.dataset.countText;
                submitField.classList.add("hidden");
                submitField.style.display = "none";

                startCountdown(protectTpT, submitField.parentElement, protectTpCountText);

                setTimeout(function() {
                    submitField.classList.remove("hidden");
                    submitField.style.display = "block";
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
