

async function loadResults(sub_id) {
    try {
        const response = await fetch(`/api/result/${sub_id}`);
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


function applyUserDetails(submitter) {
    const userNameElement = document.getElementById("user_name");
    userNameElement.textContent = submitter.name;
}

function applyQuizDetails(quiz) {
    const quizTitleElement = document.getElementById("quiz_title");
    const quizDescElement = document.getElementById("quiz_desc");
    const quizQuestionNumberElement = document.getElementById("quiz_question_number");
    const quizTimesPassedElement = document.getElementById("quiz_times_passes")

    quizTitleElement.textContent = quiz.title;
    quizDescElement.textContent = quiz.description;
    quizTimesPassedElement.textContent = quiz.times_passed;
    quizQuestionNumberElement.textContent = quiz.questions.length;
}

function applyTotal(total) {
    const markElement = document.getElementById("mark");
    const maxMarkElement = document.getElementById("max_mark");

    markElement.textContent = total.points;
    maxMarkElement.textContent = total.max_point;
}

function applyOptions(correct_options) {
    const questions = Array.from(document.getElementsByClassName("question_Option"));
    // console.log(questions);
    questions.forEach((question) => {
        const q_id = question.getAttribute('question_id');
        const question_answer = correct_options.find(item => item.question_id == q_id);
        // console.log("Correct answer for q_id:" + q_id + " is:");
        // console.log(question_answer);
        const options = Array.from(question.querySelectorAll('.option-container'));
        let correctLabel = null;
        options.forEach((option) => {
            const radioButton = option.querySelector('input[type="radio"]');
            radioButton.readOnly = true;
            radioButton.disabled = true;
            if(radioButton.value == question_answer.selected_option_id) {
                radioButton.checked = true;
            }
            if(radioButton.value == question_answer.correct_option_id) {
                correctLabel = option.querySelector('label');
            }
        });

        if(!question_answer.correct) {
            const paragraph = document.createElement('p');
            paragraph.textContent = `X Correct: ${correctLabel.textContent}`;
            question.appendChild(paragraph);
        }

        applyPoints(question, question_answer.points);
    });
}

function applyPoints(question, value) {
    const points = question.querySelector('.text-points');
    const points_value = points.querySelector('.points-value');
    points_value.textContent = parseFloat(value);
}

function applyMatches(correct_matches) {
    const questions = Array.from(document.getElementsByClassName("question_Match"));
    questions.forEach((question) => {
        const q_id = question.getAttribute('question_id');
        const question_answers = correct_matches.filter((item) => item.question_id == q_id);

        const matches = Array.from(question.querySelectorAll('.match-container'));

        matches.forEach((match) => {
            const select = match.querySelector('select');
            const left_select_id = select.getAttribute('name');
            const answer = question_answers.find((item) => item.left_id == left_select_id);
            select.value = answer.selected_right_id;
            select.readOnly = true;
            select.disabled = true;
            if(!answer.correct) {
                const select_options = Array.from(select.options);
                const correct_option = select_options.find((item) => item.value == answer.correct_right_id);
                const paragraph = document.createElement('p');
                paragraph.textContent = `X Correct: ${correct_option.textContent}`;
                match.appendChild(paragraph);
            }
        });
        const sumOfPoints = question_answers.reduce((sum, match) => sum + match.points, 0);
        applyPoints(question, sumOfPoints);
    });


}
