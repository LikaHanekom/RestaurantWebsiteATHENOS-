
    document.addEventListener("DOMContentLoaded", function () {
        const num1 = Math.floor(Math.random() * 10) + 1;
        const num2 = Math.floor(Math.random() * 10) + 1;
        const correctAnswer = num1 + num2;

        const captchaQuestion = document.getElementById("captcha-question");
        if (captchaQuestion) {
            captchaQuestion.textContent = `Security Check: ${num1} + ${num2} =`;
        }

        const form = document.getElementById("contactForm");
        form.addEventListener("submit", function (event) {
            const userAnswer = document.getElementById("captcha-answer").value.trim();

            if (parseInt(userAnswer) !== correctAnswer) {
                event.preventDefault(); 
                alert("Incorrect security answer. Please try again!");
                document.getElementById("captcha-answer").focus();
            }
        });
    });