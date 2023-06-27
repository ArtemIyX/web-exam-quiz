async function loadQuestions(quizId) {
    try {
        const response = await fetch(`/api/quiz/${quizId}`);
        const data = await response.json();
        if (response.ok && data.retCode === 0) {
            return data.result;
        } else {
            // Error occurred during data retrieval
            console.error(data);
        }
    } catch (error) {
        // Exception occurred during the fetch request
        console.error(error);
        // Handle the exception appropriately
    }
}
async function loadAnswers(questionId) {
    try {
        const response = await fetch(`/api/question/${questionId}`);
        const data = await response.json();
        console.log("Answers: ");
        console.log(data.result);
        if (response.ok) {
            return data.result;
        } else {
            throw new Error(data.retMsg);
        }
    } catch (error) {
        throw new Error('Failed to load answers');
    }
}
async function renderAnswers(optionsContainer, options) {
    options.forEach((option) => {
        const radioDiv = document.createElement('div');
        const radioInput = document.createElement('input');
        const optionLabel = document.createElement('label');

        radioInput.type = 'radio';
        radioInput.name = option.question_id;
        radioInput.value = option.id;

        optionLabel.textContent = option.option;

        radioDiv.appendChild(radioInput);
        radioDiv.appendChild(optionLabel);

        optionsContainer.appendChild(radioDiv);
    });
}

async function renderQuestions(questions) {
    const container = document.getElementById('questions-container');

    for (let i = 0; i < questions.length; i++) {
        const question = questions[i];

        const questionDiv = document.createElement('div');
        questionDiv.classList.add('question');

        const questionText = document.createElement('p');
        questionText.textContent = question.question;
        questionDiv.appendChild(questionText);

        const answers = await loadAnswers(questions[i].id);
        await renderAnswers(questionDiv, answers);

        container.appendChild(questionDiv);
    }
}
