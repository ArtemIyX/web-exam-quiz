async function loadQuestions(quizId) {
    try {
        const response = await fetch(`/api/questions/${quizId}`);
        const data = await response.json();
        if (response.ok && data.retCode === 200) {
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
        if (response.ok && data.retCode === 200) {
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
        if (response.ok && data.retCode === 200) {
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

        radioDiv.addEventListener('click', (event) =>{
            if(!radioInput.disabled){
                radioInput.checked = true;
                radioDiv.classList.toggle('active');
            }
        })

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

    const promises = [];
    for (let i = 0; i < questions.length; i++) {
        const question = questions[i];

        const questionDiv = document.createElement('div');
        questionDiv.classList.add(`question_${questions[i].question_type}`);
        questionDiv.setAttribute('question_id', questions[i].id);
        const questionText = document.createElement('p');
        questionText.classList.add('text-question');
        const questionPoints = document.createElement('p');
        questionPoints.classList.add('text-points')
        const pointsValueSpan = document.createElement('span');
        pointsValueSpan.classList.add('points-value')
        //const hr = document.createElement('hr');
        questionPoints.textContent = `Points:`;
        questionPoints.appendChild(pointsValueSpan);
        pointsValueSpan.textContent = `${questions[i].points}`;
        questionText.textContent = question.question;
        questionDiv.appendChild(questionText);
        questionDiv.appendChild(questionPoints);

        // Check if the question type is "Option"
        if (questions[i].question_type === "Option") {

            promises.push(loadOptions(questions[i].id).then(options => {
                // Render the answers using the loaded options
                return renderAnswers(questionDiv, options);
            }));
        }
        // Check if the question type is "Match"
        else if (questions[i].question_type == "Match") {

            promises.push(loadMatches(questions[i].id).then(matches => {
                // Render the matches using the loaded matches
                return renderMatches(questionDiv, matches);
            }));
        }
        //questionDiv.appendChild(hr);
        // Append the question div to the container
        container.appendChild(questionDiv);
    }
    await Promise.all(promises);
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
        q_id = questionOptions[i].getAttribute('question_id');
        // Get all options for this question
        const optionContainers = questionOptions[i].querySelectorAll('.option-container');
        // Get all child input elements with type 'radio'
        const radioOptions = getRadioOptions(optionContainers);
        const checkedRadio = getChecked(radioOptions);

        const data = {
            question_id: q_id,
            selected_id: null
        };

        if (checkedRadio !== null) {
            data.selected_id = checkedRadio.value;
        }
        result.push(data);
    }
    return result;
}

async function grabAllMatchesQuestions() {
    const matchesOptions = document.getElementsByClassName('question_Match');
    const result = [];
    for(let i = 0; i < matchesOptions.length; ++i) {
        const q_id = matchesOptions[i].getAttribute('question_id');
        // Get all matches for this question
        const matchContainers = matchesOptions[i].querySelectorAll('.match-container');
        for(let j = 0; j < matchContainers.length; ++j) {
            const select = matchContainers[j].querySelector('select');
            const data = {
                question_id: q_id,
                left_id: select.name,
                right_id: select.value
            };
            result.push(data);
        }
    }
    return result;
}
