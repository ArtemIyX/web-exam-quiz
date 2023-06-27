async function loadQuestions(quizId) {
    try {
        const response = await fetch(`/api/questions/${quizId}`);
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
async function loadOptions(questionId) {
    try {
        const response = await fetch(`/api/options/${questionId}`);
        const data = await response.json();
        // console.log("Answers: ");
        // console.log(data.result);
        if (response.ok) {
            return data.result;
        } else {
            throw new Error(data.retMsg);
        }
    } catch (error) {
        throw new Error('Failed to load answers');
    }
}
async function loadMatches(questionId) {
    try {
        const response = await fetch(`/api/matches/${questionId}`);
        const data = await response.json();
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
async function renderMatches(macthesContainer, matches) {
    for (const name of matches.left) {
        const div = document.createElement('div');
        const nameParagraph = document.createElement('p')
        nameParagraph.textContent = name.item;
        const select = document.createElement('select');
        select.name = name.id;
        for (const option of matches.right) {
            const optionElement = document.createElement('option');
            optionElement.value = option.id;
            optionElement.textContent = option.item;
            select.appendChild(optionElement);
        }
        div.appendChild(nameParagraph);
        div.appendChild(select);

        macthesContainer.appendChild(div);
    }
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

        if (questions[i].question_type === "Option") {
            const options = await loadOptions(questions[i].id);
            await renderAnswers(questionDiv, options);
        }
        else if (questions[i].question_type == "Match") {
            const matches = await loadMatches(questions[i].id);
            await renderMatches(questionDiv, matches)
        }

        container.appendChild(questionDiv);
    }
}
