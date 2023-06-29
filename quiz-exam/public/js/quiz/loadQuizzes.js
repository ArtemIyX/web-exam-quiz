// Render quizzes on the page
async function renderQuizzes() {
    const quizContainer = document.getElementById('quizContainer');
    const loadingDiv = document.getElementById('loading-div');

    try {
        const quizzes = await fetchQuizzes();
        let html_result = [];
        for (const quiz of quizzes) {
            const { id, title, description, author_id, created_at } = quiz;
            const user = await getUser(author_id);
            const userName = user.name;
            const date = new Date(created_at);
            const formattedDate = date.toLocaleDateString();

            const quizGrid = document.createElement('div');
            quizGrid.classList.add('quiz-grid');

            const information = document.createElement('div');
            information.classList.add('information');

            const btnCheck = document.createElement('div');
            btnCheck.classList.add('btn-check');


            const titleElement = document.createElement('h3');
            titleElement.textContent = title;
            information.appendChild(titleElement);

            const descriptionElement = document.createElement('p');
            descriptionElement.classList.add('description');
            descriptionElement.textContent = description;
            information.appendChild(descriptionElement);

            const authorElement = document.createElement('p');
            authorElement.classList.add('author');
            authorElement.textContent = `Author: ${userName}`;
            information.appendChild(authorElement);

            const createdAtElement = document.createElement('p');
            createdAtElement.classList.add('created-at');
            createdAtElement.textContent = `Created at: ${formattedDate}`;
            information.appendChild(createdAtElement);

            quizGrid.appendChild(information);

            const linkElement = document.createElement('p');
            linkElement.textContent = 'Check';
            btnCheck.appendChild(linkElement);

            quizGrid.appendChild(btnCheck);

            html_result.push({
                quiz_id: id,
                grid: quizGrid,
                button: btnCheck
            });
        }
        loadingDiv.remove();
        html_result.forEach(element => {
            quizContainer.appendChild(element.grid);
            element.button.addEventListener('click', (event) => {
                window.location.href = `/quiz/${element.quiz_id}`
                console.log(element.quiz_id);
            });
        });


    } catch (error) {
        quizContainer.innerHTML = 'Error loading quizzes.';
        console.error(error);
    }
}
