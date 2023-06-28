let questionCount = 0;

function addQuestion() {
  const questionsDiv = document.getElementById('questions');
  const questionDiv = document.createElement('div');
  questionDiv.id = `question-${questionCount}`;
  questionDiv.innerHTML = `
    <h3>Question ${questionCount + 1}</h3>
    <label for="question-${questionCount}-text">Question:</label>
    <input type="text" id="question-${questionCount}-text"><br>
    <label for="question-${questionCount}-options">Answer Options:</label>
    <div id="question-${questionCount}-options"></div><br>
    <button onclick="addOption(${questionCount})">Add Option</button>
    <button onclick="deleteQuestion(${questionCount})">Delete Question</button>
  `;
  questionsDiv.appendChild(questionDiv);
  questionCount++;
}

function addOption(questionIndex) {
  const optionsDiv = document.getElementById(`question-${questionIndex}-options`);
  const optionDiv = document.createElement('div');
  optionDiv.classList.add('option');
  optionDiv.innerHTML = `
    <input type="text" placeholder="Option">
    <input type="radio" name="question-${questionIndex}-correct" value="${optionsDiv.childElementCount}">
    <button onclick="removeOption(${questionIndex}, ${optionsDiv.childElementCount})">Remove</button>
  `;
  optionsDiv.appendChild(optionDiv);
}

function removeOption(questionIndex, optionIndex) {
  const optionsDiv = document.getElementById(`question-${questionIndex}-options`);
  optionsDiv.removeChild(optionsDiv.children[optionIndex]);
  // Update the value attribute of radio buttons after removing an option
  const optionInputs = optionsDiv.getElementsByTagName('input');
  for (let i = 0; i < optionInputs.length; i++) {
    optionInputs[i].value = i;
  }
}

function deleteQuestion(questionIndex) {
  const questionDiv = document.getElementById(`question-${questionIndex}`);
  questionDiv.parentNode.removeChild(questionDiv);
}
