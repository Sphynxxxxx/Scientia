// Mobile Menu Toggle
const toggleButton = document.querySelector('.mobile-menu-toggle');
const header = document.querySelector('header');

if (toggleButton && header) {
    toggleButton.addEventListener('click', () => {
        header.classList.toggle('open'); 
    });
}

// Like Button Toggle
const likeButtons = document.querySelectorAll('.like-button');

likeButtons.forEach(button => {
    button.addEventListener('click', () => {
        const icon = button.querySelector('i');
        icon.classList.toggle('liked'); // Toggle 'liked' class on the icon
    });
});


// Comment buttons Toggle
const commentButtons = document.querySelectorAll('.comment-button');
const commentSections = document.querySelectorAll('.comment-section');


commentSections.forEach(section => (section.style.display = 'none'));


commentButtons.forEach((button, index) => {
    button.addEventListener('click', () => {
        const section = commentSections[index];
        section.style.display = section.style.display === 'none' ? 'block' : 'none';
    });
});

const shareButtons = document.querySelectorAll('.share-button');

shareButtons.forEach(button => {
    button.addEventListener('click', () => {
        const link = button.getAttribute('data-link'); // Get the link from data attribute

        // Copy the link to clipboard
        navigator.clipboard.writeText(link).then(() => {
            alert('Link copied to clipboard!');
        }).catch(err => {
            console.error('Failed to copy link: ', err);
        });
    });
});

document.querySelectorAll('.submit-comment').forEach((submitButton, index) => {
    const commentSection = commentSections[index];
    const commentInput = commentSection.querySelector('.comment-input');
    const commentsDisplay = commentSection.querySelector('.comments-display');

    submitButton.addEventListener('click', () => {
        const commentText = commentInput.value.trim(); 

        if (commentText) {
            
            const newComment = document.createElement('div');
            newComment.classList.add('comment');
            newComment.textContent = commentText;

            
            commentsDisplay.appendChild(newComment);

           
            commentInput.value = '';
        }
    });
});


// Submit Comment Functionality
const submitCommentButton = document.querySelector('.submit-comment');
const commentInput = document.querySelector('.comment-input');
const commentsDisplay = document.querySelector('.comments-display');

if (submitCommentButton && commentInput && commentsDisplay) {
    submitCommentButton.addEventListener('click', () => {
        const commentText = commentInput.value.trim(); 

        if (commentText) {
            const newComment = document.createElement('div');
            newComment.classList.add('comment');
            newComment.textContent = commentText;

            commentsDisplay.appendChild(newComment); 
            commentInput.value = ''; 
        }
    });
}

// Get search input and button elements
const searchInput = document.querySelector('.search-input');
const searchButton = document.querySelector('.search-button');
const newsCards = document.querySelectorAll('.news-card'); // Select all news cards

// Search function to filter news cards
function searchNews() {
    const query = searchInput.value.toLowerCase().trim(); // Get input value and trim spaces

    newsCards.forEach(card => {
        const heading = card.querySelector('.news-heading').textContent.toLowerCase();
        const description = card.querySelector('.news-description').textContent.toLowerCase();
        const meta = card.querySelector('.news-date').textContent.toLowerCase();

        // Check if query matches heading, description, or metadata
        if (heading.includes(query) || description.includes(query) || meta.includes(query)) {
            card.style.display = 'block'; // Show matching cards
        } else {
            card.style.display = 'none'; // Hide non-matching cards
        }
    });
}

// Add event listeners for search input and button click
searchInput.addEventListener('input', searchNews); // Live search on typing
searchButton.addEventListener('click', searchNews); // Search on button click


