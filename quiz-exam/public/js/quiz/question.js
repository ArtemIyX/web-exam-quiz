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
        radioDiv.classList.add('option-container')
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
        div.classList.add('match-container')
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
        questionDiv.classList.add(`question_${questions[i].question_type}`);

        const questionText = document.createElement('p');
        const questionPoints = document.createElement('p');
        const hr = document.createElement('hr');
        questionPoints.textContent = `Points: ${questions[i].points}`;
        questionText.textContent = question.question;
        questionDiv.appendChild(questionText);
        questionDiv.appendChild(questionPoints);

        // Check if the question type is "Option"
        if (questions[i].question_type === "Option") {
            // If it is, load the options asynchronously
            const options = await loadOptions(questions[i].id);
            // Render the answers using the loaded options
            await renderAnswers(questionDiv, options);
        }
        // Check if the question type is "Match"
        else if (questions[i].question_type == "Match") {
            // If it is, load the matches asynchronously
            const matches = await loadMatches(questions[i].id);
            // Render the matches using the loaded matches
            await renderMatches(questionDiv, matches);
        }
        questionDiv.appendChild(hr);
        // Append the question div to the container
        container.appendChild(questionDiv);
    }
}

function getRadioOptions(radioButtons) {
    const res = [];
    for(let i = 0; i < radioButtons.length; ++i) {
        const radioInput = radioButtons[i].querySelector('input[type="radio"]');
        res.push(radioInput);
    }
    return res;
}
function getChecked(radioButtons) {
    for (let i = 0; i < radioButtons.length; ++i) {
        if (radioButtons[i].checked) {
            return radioButtons[i];
        }
    }
    return null;
}


async function grabAllOptionsQuestions() {
    const questionOptions = document.getElementsByClassName('question_Option');
    const result = [];
    for(let i = 0; i < questionOptions.length; ++i) {
        // Get all options for this question
        const optionContainers = questionOptions[i].querySelectorAll('.option-container');
        // Get all child input elements with type 'radio'
        const radioOptions = getRadioOptions(optionContainers);
        const checkedRadio = getChecked(radioOptions);

        const data = {
            question_id: radioOptions[0].name,
            selected_id: null
        };

        if (checkedRadio !== null) {
            data.selected_id = checkedRadio.value;
        }
        result.push(data);
    }
    return result;
}


