// Initialize an empty array to store the questions
var questions = [];

function addQuestion() {
    // Create a new question object
    var question = {
        questionText: '',
        answerOptions: [],
        correctAnswer: null
    };

    // Add the question to the array
    questions.push(question);

    // Render the question in the HTML
    renderQuestion(question);
}

function renderQuestion(question) {

    function renderAnswerOption(answerOption, answerOptionsContainer) {
        // Create a new answer option container
        var answerOptionContainer = document.createElement('div');

        // Create a text input for the answer option text
        var answerOptionText = document.createElement('input');
        answerOptionText.type = 'text';
        answerOptionText.placeholder = 'Enter answer option text';
        answerOptionText.addEventListener('input', function () {
            answerOption.text = answerOptionText.value;
        });

        // Create a checkbox to specify the correct answer
        var correctAnswerCheckbox = document.createElement('input');
        correctAnswerCheckbox.type = 'checkbox';
        correctAnswerCheckbox.addEventListener('change', function () {
            answerOption.isCorrect = correctAnswerCheckbox.checked;
            // Uncheck all other checkboxes in the answer options
            if (correctAnswerCheckbox.checked) {
                for (var i = 0; i < answerOptionsContainer.children.length; i++) {
                    var optionContainer = answerOptionsContainer.children[i];
                    var checkbox = optionContainer.querySelector('input[type="checkbox"]');
                    if (checkbox !== correctAnswerCheckbox) {
                        checkbox.checked = false;
                        questions[i].answerOptions.forEach(function (option) {
                            option.isCorrect = false;
                        });
                    }
                }
            }
        });

        // Create a button to remove the answer option
        var removeOptionButton = document.createElement('button');
        removeOptionButton.textContent = 'Remove';
        removeOptionButton.addEventListener('click', function () {
            // Remove the answer option from the question
            var index = question.answerOptions.indexOf(answerOption);
            if (index !== -1) {
                question.answerOptions.splice(index, 1);
            }

            // Remove the answer option container from the HTML
            answerOptionContainer.remove();
        });

        // Append the answer option elements to the answer option container
        answerOptionContainer.appendChild(answerOptionText);
        answerOptionContainer.appendChild(correctAnswerCheckbox);
        answerOptionContainer.appendChild(removeOptionButton);

        // Append the answer option container to the answer options container
        answerOptionsContainer.appendChild(answerOptionContainer);
    }
    
    // Create a new question container
    var questionContainer = document.createElement('div');

    // Create a text input for the question text
    var questionText = document.createElement('input');
    questionText.type = 'text';
    questionText.placeholder = 'Enter question text';
    questionText.addEventListener('input', function () {
        question.questionText = questionText.value;
    });

    // Create a button to delete the question
    var deleteButton = document.createElement('button');
    deleteButton.textContent = 'Delete';
    deleteButton.addEventListener('click', function () {
        // Remove the question from the array
        var index = questions.indexOf(question);
        if (index !== -1) {
            questions.splice(index, 1);
        }

        // Remove the question container from the HTML
        questionContainer.remove();
    });

    // Create a button to add answer options
    var addOptionButton = document.createElement('button');
    addOptionButton.textContent = 'Add Option';
    addOptionButton.addEventListener('click', function () {
        // Create a new answer option object
        var answerOption = {
            text: '',
            isCorrect: false
        };

        // Add the answer option to the question
        question.answerOptions.push(answerOption);

        // Render the answer option in the HTML
        renderAnswerOption(answerOption, answerOptionsContainer);
    });

    // Create a container for answer options
    var answerOptionsContainer = document.createElement('div');

    // Append the question elements to the question container
    questionContainer.appendChild(questionText);
    questionContainer.appendChild(deleteButton);
    questionContainer.appendChild(addOptionButton);
    questionContainer.appendChild(answerOptionsContainer);

    // Append the question container to the quiz container
    quizContainer.appendChild(questionContainer);
}

