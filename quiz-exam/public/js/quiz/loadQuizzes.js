

// Render quizzes on the page
async function renderQuizzes() {
    const quizContainer = document.getElementById('quizContainer');
    quizContainer.innerHTML = 'Loading quizzes...';

    try {
        const quizzes = await fetchQuizzes();
        let html = '';
        for (const quiz of quizzes) {
            const {id, title, description, author_id, created_at } = quiz;
            const user = await getUser(author_id);
            const userName = user.name;
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
