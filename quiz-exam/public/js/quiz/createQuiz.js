// JavaScript functions for adding and removing questions and options
function addQuestion(questionType) {
    var questionContainer = document.createElement('div');
    questionContainer.className = 'question-container';

    var questionTitle = document.createElement('input');
    questionTitle.type = 'text';
    questionTitle.placeholder = 'Question Title';
    questionContainer.appendChild(questionTitle);

    var addOptionButton = document.createElement('button');
    addOptionButton.textContent = 'Add Option';
    addOptionButton.onclick = function () {
        addOption(questionContainer, questionType);
    };
    questionContainer.appendChild(addOptionButton);

    var removeQuestionButton = document.createElement('button');
    removeQuestionButton.textContent = 'Remove Question';
    removeQuestionButton.onclick = function () {
        questionContainer.parentNode.removeChild(questionContainer);
    };
    questionContainer.appendChild(removeQuestionButton);

    if (questionType === 'radio') {
        var questionTypeLabel = document.createElement('label');
        questionTypeLabel.textContent = 'Question Type: Radio Button';
        questionContainer.appendChild(questionTypeLabel);
    } else if (questionType === 'dropdown') {
        var questionTypeLabel = document.createElement('label');
        questionTypeLabel.textContent = 'Question Type: Dropdown Box';
        questionContainer.appendChild(questionTypeLabel);
    }

    document.getElementById('quiz-container').appendChild(questionContainer);
}

function addOption(questionContainer, questionType) {
    var optionContainer = document.createElement('div');
    optionContainer.className = 'option-container';

    var optionTitle = document.createElement('input');
    optionTitle.type = 'text';
    optionTitle.placeholder = 'Option Title';
    optionContainer.appendChild(optionTitle);

    if (questionType === 'radio') {
        var correctAnswerLabel = document.createElement('label');
        correctAnswerLabel.textContent = 'Correct Answer:';

        var correctAnswerCheckbox = document.createElement('input');
        correctAnswerCheckbox.type = 'checkbox';
        correctAnswerCheckbox.value = 'true';

        optionContainer.appendChild(correctAnswerLabel);
        optionContainer.appendChild(correctAnswerCheckbox);
    }

    if (questionType === 'dropdown') {
        var addAnswerButton = document.createElement('button');
        addAnswerButton.textContent = 'Add Answer';
        addAnswerButton.onclick = function () {
            addAnswer(optionContainer);
        };
        optionContainer.appendChild(addAnswerButton);
    }

    var removeOptionButton = document.createElement('button');
    removeOptionButton.textContent = 'Remove Option';
    removeOptionButton.onclick = function () {
        optionContainer.parentNode.removeChild(optionContainer);
    };
    optionContainer.appendChild(removeOptionButton);

    questionContainer.appendChild(optionContainer);
}

function addAnswer(optionContainer) {
    var answerContainer = document.createElement('div');
    answerContainer.className = 'answer-container';

    var answerTitle = document.createElement('input');
    answerTitle.type = 'text';
    answerTitle.placeholder = 'Answer';
    answerContainer.appendChild(answerTitle);

    var correctCheckbox = document.createElement('input');
    correctCheckbox.type = 'checkbox';
    correctCheckbox.value = 'true';
    answerContainer.appendChild(correctCheckbox);

    var correctLabel = document.createElement('label');
    correctLabel.textContent = 'Correct Answer';
    answerContainer.appendChild(correctLabel);

    var removeAnswerButton = document.createElement('button');
    removeAnswerButton.textContent = 'Remove Answer';
    removeAnswerButton.onclick = function () {
        answerContainer.parentNode.removeChild(answerContainer);
    };
    answerContainer.appendChild(removeAnswerButton);

    optionContainer.appendChild(answerContainer);
}

function getQuiz() {
    // Collect quiz data
    var quizName = document.getElementById('quiz-name').value;
    var quizDescription = document.getElementById('quiz-description').value;

    var quiz = {
        name: quizName,
        description: quizDescription,
        questions: []
    };

    var questionContainers = document.getElementsByClassName('question-container');
    for (var i = 0; i < questionContainers.length; i++) {
        var questionContainer = questionContainers[i];
        var questionTitle = questionContainer.querySelector('input[type="text"]').value;

        var options = questionContainer.getElementsByClassName('option-container');
        var questionOptions = [];
        for (var j = 0; j < options.length; j++) {
            var optionContainer = options[j];
            var optionTitle = optionContainer.querySelector('input[type="text"]').value;
            var correctAnswerCheckbox1 = optionContainer.querySelector('input[type="checkbox"]').checked;


            if (optionContainer.getElementsByClassName('answer-container').length > 0) {
                var answers = optionContainer.getElementsByClassName('answer-container');
                var optionAnswers = [];
                for (var k = 0; k < answers.length; k++) {
                    var answerContainer = answers[k];
                    var answerTitle = answerContainer.querySelector('input[type="text"]').value;
                    var correctAnswer = answerContainer.querySelector('input[type="checkbox"]').checked;

                    optionAnswers.push({
                        answer: answerTitle,
                        correct: correctAnswer
                    });
                }

                questionOptions.push({
                    title: optionTitle,
                    answers: optionAnswers
                });
            } else {
                questionOptions.push({
                    answer: optionTitle,
                    correct: correctAnswerCheckbox1
                });
            }
        }

        var questionType;
        var questionTypeLabel = questionContainer.querySelector('label');
        if (questionTypeLabel.textContent.includes('Radio')) {
            questionType = 'radio';
        } else if (questionTypeLabel.textContent.includes('Dropdown')) {
            questionType = 'dropdown';
        }

        quiz.questions.push({
            title: questionTitle,
            type: questionType,
            options: questionOptions
        });
    }

    return quiz;
}
