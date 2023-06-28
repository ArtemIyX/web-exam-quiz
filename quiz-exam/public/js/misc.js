// Fetch quizzes asynchronously
async function fetchQuizzes() {
    try {
        const response = await fetch('/api/quizzes');
        const data = await response.json();
        return data.result;
    } catch (error) {
        console.error('Error:', error);
        return null;
    }
}

async function getQuiz(id) {
    try {
        const response = await fetch(`/api/quiz/${id}`);
        const data = await response.json();
        return data.result;
    }
    catch(error) {
         console.error('Error:', error);
         return null;
    }
}

async function getUser(userId) {
    try {
        const response = await fetch(`/api/user/${userId}`);
        const data = await response.json();

        if (data.retCode === 0) {
            const user = data.result;
            return user;
        } else {
            console.error('Error:', data.retMsg);
            return null;
        }
    } catch (error) {
        console.error('Fetch Error:', error);
    }
}

async function getQuizCount() {
    try {
        const response = await fetch('api//quiz/count');
        const data = await response.json();

        if (data.retCode === 0) {
            return data.result;
        } else {
            console.error('Error:', data.retMsg);
            return null;
        }
    } catch (error) {
        console.error('Fetch Error:', error);
    }
}
