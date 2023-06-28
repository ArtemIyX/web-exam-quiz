// Fetch quizzes asynchronously
async function fetchQuizzes() {
    try {
        const response = await fetch('/api/quizzes');
        const data = await response.json();
        return data.result;
    } catch (error) {
        // Handle any errors
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
         // Handle any errors
         console.error('Error:', error);
         return null;
    }
}

async function fetchUserName(userId) {
    try {
        const response = await fetch(`/api/user/${userId}`);
        const data = await response.json();

        if (data.retCode === 0) {
            const userName = data.result;
            //console.log('User Name:', userName);
            return userName;
        } else {
            console.error('Error:', data.retMsg);
            return null;
        }
    } catch (error) {
        console.error('Fetch Error:', error);
    }
}

// Render quizzes on the page
async function renderQuizzes() {
    const quizContainer = document.getElementById('quizContainer');
    quizContainer.innerHTML = 'Loading quizzes...';

    try {
        const quizzes = await fetchQuizzes();
        let html = '';
        for (const quiz of quizzes) {
            const {id, title, description, author_id, created_at } = quiz;
            const userName = await fetchUserName(author_id);
            const date = new Date(created_at);
            const formattedDate = date.toLocaleDateString();
            html += `
                <div>
                    <h3>${title}</h3>
                    <p>${description}</p>
                    <p>Author: ${userName}</p>
                    <p>Created at: ${formattedDate}</p>
                    <a href=/quiz/${id}>Check</a>
                </div>
                <hr>
            `;
        }

        quizContainer.innerHTML = html;
    } catch (error) {
        quizContainer.innerHTML = 'Error loading quizzes.';
        console.error(error);
    }
}
