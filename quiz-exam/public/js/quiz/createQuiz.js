var questionCount = 0;


function findQuestionDiv(questionNumber) {
    const questionDivs = document.getElementsByClassName('question');

    for (let i = 0; i < questionDivs.length; i++) {
        const questionDiv = questionDivs[i];
        const questionValue = questionDiv.getAttribute('question');

        if (questionValue == questionNumber) {
            return questionDiv;
        }
    }

    return null;
}

function findOptionButton(questionNumber) {
    const div = findQuestionDiv(questionNumber);
    const btn = div.querySelector('.btn_add_option');
    return btn;
}

function findMatchButton(questionNumber) {
    const div = findQuestionDiv(questionNumber);
    const btn = div.querySelector('.btn_add_match');
    return btn;
}

function addQuestion() {
    questionCount++;

    var questionsContainer = document.getElementById('questionsContainer');

    var questionDiv = document.createElement('div');
    questionDiv.classList.add('question');
    questionDiv.setAttribute('question', questionCount);
    questionDiv.innerHTML = '<h3>Question ' + questionCount + '</h3>';

    var optionsDiv = document.createElement('div');
    optionsDiv.id = 'options' + questionCount;

    var matchDiv = document.createElement('div');
    matchDiv.id = 'match' + questionCount;

    var addOptionButton = document.createElement('button');
    addOptionButton.type = 'button';
    addOptionButton.innerText = 'Add Option';
    addOptionButton.setAttribute('question', questionCount);
    addOptionButton.classList.add('btn_add_option');
    addOptionButton.addEventListener('click', function (event) {
        const clickedButton = event.target;
        const number = clickedButton.getAttribute('question');
        addOption(number);
    });

    var addMatchButton = document.createElement('button');
    addMatchButton.type = 'button';
    addMatchButton.innerText = 'Add Match';
    addMatchButton.setAttribute('question', questionCount);
    addMatchButton.classList.add('btn_add_match');
    addMatchButton.addEventListener('click', function (event) {
        const clickedButton = event.target;
        const number = clickedButton.getAttribute('question');
        addMatch(number);
    });

    questionDiv.appendChild(optionsDiv);
    questionDiv.appendChild(matchDiv);
    questionDiv.appendChild(addOptionButton);
    questionDiv.appendChild(addMatchButton);


    questionsContainer.appendChild(questionDiv);
}

function addOption(questionNumber) {
    const optionsDiv = document.getElementById('options' + questionNumber);
    const matchDiv = document.getElementById('match' + questionNumber);

    if (matchDiv) {
        matchDiv.remove();
    }

    const matchBtn = findMatchButton(questionNumber);
    if(matchBtn) {
        matchBtn.remove();
    }

    const optionLabel = document.createElement('label');
    optionLabel.innerHTML = 'Option: ';

    const optionInput = document.createElement('input');
    optionInput.type = 'text';

    const isCorrectLabel = document.createElement('label');
    isCorrectLabel.innerHTML = 'Correct: ';

    const isCorrectInput = document.createElement('input');
    isCorrectInput.type = 'radio';
    isCorrectInput.name = 'correctOption' + questionNumber;

    optionsDiv.appendChild(optionLabel);
    optionsDiv.appendChild(optionInput);
    optionsDiv.appendChild(isCorrectLabel);
    optionsDiv.appendChild(isCorrectInput);
    optionsDiv.appendChild(document.createElement('br'));
}

function addMatch(questionNumber) {
    var optionsDiv = document.getElementById('options' + questionNumber);
    var matchDiv = document.getElementById('match' + questionNumber);

    if (optionsDiv) {
        optionsDiv.remove();
    }

    const optionButton = findOptionButton(questionNumber);
    if(optionButton) {
        optionButton.remove();
    }

    var matchLabel = document.createElement('label');
    matchLabel.innerHTML = 'Match: ';

    var matchInput = document.createElement('input');
    matchInput.type = 'text';

    matchDiv.appendChild(matchLabel);
    matchDiv.appendChild(matchInput);
    matchDiv.appendChild(document.createElement('br'));
}
