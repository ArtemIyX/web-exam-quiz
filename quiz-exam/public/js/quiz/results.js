

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
    const quizAuthorElement = document.getElementById("quiz_author");
    const quizQuestionNumberElement = document.getElementById("quiz_question_number");
    const quizTimesPassedElement = document.getElementById("quiz_times_passes")

    quizTitleElement.textContent = quiz.title;
    quizAuthorElement.textContent = quiz.description;
    quizTimesPassedElement.textContent = quiz.times_passed;
    quizQuestionNumberElement.textContent = quiz.questions.length;
}

function applyTotal(total) {
    const markElement = document.getElementById("mark");
    const maxMarkElement = document.getElementById("max_mark");

    markElement.textContent = total.points;
    maxMarkElement.textContent = total.max_point;
}
