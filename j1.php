<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Quiz </title>
<link rel="stylesheet" href="s1.css">
<style>
/* Extra animation effect */
.fade-in {
  opacity: 0;
  transform: translateY(15px);
  animation: fadeIn 0.6s forwards;
}

@keyframes fadeIn {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
</head>
<body>
<div class="container">
    <h1 class="page-title">Quiz</h1>
    <h2 id="quiz-question"></h2>
    <div id="options-container" class="options-grid"></div>
    <p id="feedback"></p>
    <div class="button-group">
        <button id="submitBtn" class="action-btn" name="submit">Submit Answer</button>
        <button id="nextBtn" class="action-btn" name="next">Next</button>
        <button id="resetBtn" class="action-btn" name="cancel">Reset</button>
    </div>
</div>

<script>
let currentQuestionId = 1;
let correctAnswer = "";
let hasAnswered = false;

// Load question
function loadQuestion(id) {
    fetch('get_question.php?id=' + id)
    .then(res => res.json())
    .then(data => {
        const questionElem = document.getElementById("quiz-question");
        const container = document.getElementById("options-container");
        const feedback = document.getElementById("feedback");

        // Reset feedback
        feedback.innerText = "";

        // Reset animations
        questionElem.classList.remove("fade-in");
        container.classList.remove("fade-in");

        // Force reflow to restart animation
        void questionElem.offsetWidth;

        // Load new question text
        questionElem.innerText = data.question_text;
        questionElem.classList.add("fade-in");

        correctAnswer = data.correct_answer;
        hasAnswered = false;

        // Load new options
        container.innerHTML = "";
        for (let key in data.options) {
            const div = document.createElement("div");
            div.className = "option";
            div.innerHTML = `<input type="radio" name="answer" value="${key}" id="${key}">
                             <label for="${key}">${key}: ${data.options[key]}</label>`;
            container.appendChild(div);
        }

        // Animate options
        container.classList.add("fade-in");

        document.getElementById("submitBtn").disabled = false;
        document.getElementById("nextBtn").disabled = true;
    });
}

// Submit button: check answer
document.getElementById("submitBtn").addEventListener("click", () => {
    const selected = document.querySelector('input[name="answer"]:checked');
    if (!selected) {
        alert("Please select an answer!");
        return;
    }

    let feedbackText = "";
    if (selected.value === correctAnswer) {
        feedbackText = "✅ Correct!";
    } else {
        feedbackText = "❌ Incorrect! Correct answer: " + correctAnswer;
    }

    document.getElementById("feedback").innerText = feedbackText;

    // Disable radio buttons
    document.querySelectorAll('input[name="answer"]').forEach(input => input.disabled = true);
    hasAnswered = true;

    // Enable Next button
    document.getElementById("nextBtn").disabled = false;
    // Disable Submit button
    document.getElementById("submitBtn").disabled = true;
});

// Next button: move to next question
document.getElementById("nextBtn").addEventListener("click", () => {
    if (!hasAnswered) {
        alert("Please submit your answer first!");
        return;
    }
    currentQuestionId++;
    loadQuestion(currentQuestionId);
});

// Reset quiz
document.getElementById("resetBtn").addEventListener("click", () => {
    currentQuestionId = 1;
    loadQuestion(currentQuestionId);
});

// Load first question
loadQuestion(currentQuestionId);
</script>
</body>
</html>
