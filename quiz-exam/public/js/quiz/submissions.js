const resultsContainer = document.getElementById('results');
const paginationContainer = document.getElementById('pagination');

const resultsPerPage = 8; // Number of results per page
let currentPage = 1; // Current page

var savedData = [];

// Function to display results for the current page
function displayResults() {
    // Clear the results container
    resultsContainer.innerHTML = '';

    // Determine the start and end index for the current page
    const startIndex = (currentPage - 1) * resultsPerPage;
    const endIndex = startIndex + resultsPerPage;

    // Get the results to display for the current page
    const resultsToDisplay = savedData.slice(startIndex, endIndex);

    // Display the results
    resultsToDisplay.forEach(x => {
        const resultElement = document.createElement('div');
        resultElement.innerHTML = x;
        resultsContainer.appendChild(resultElement);
    });

    // Update the pagination
    updatePagination();
}

// Function to update the pagination links
function updatePagination() {
    // Clear the pagination container
    paginationContainer.innerHTML = '';

    // Calculate the total number of pages
    const totalPages = Math.ceil(savedData.length / resultsPerPage);


    // Create pagination links
    for (let page = 1; page <= totalPages; page++) {
        const link = document.createElement('a');
        link.href = '#';
        link.textContent = page;

        // Highlight the current page
        if (page === currentPage) {
            link.classList.add('active');
        }

        // Add event listener to handle page click
        link.addEventListener('click', () => {
            currentPage = page;
            displayResults();
        });

        paginationContainer.appendChild(link);
    }
}

async function getSubmissions(user_id) {
    try {
        const response = await fetch(`/api/user/${user_id}/submissions`);
        const data = await response.json();
        return data.result;
    } catch (error) {
        // Handle any errors
        console.error('Error:', error);
        return null;
    }
}
