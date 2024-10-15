// Login/Signup Toggle
const showSignup = document.getElementById('showSignup');
const showLogin = document.getElementById('showLogin');
const loginBox = document.getElementById('loginBox');
const signupBox = document.getElementById('signupBox');

if (showSignup && showLogin) {
    showSignup.addEventListener('click', () => {
        loginBox.classList.add('hidden');
        signupBox.classList.remove('hidden');
    });

    showLogin.addEventListener('click', () => {
        signupBox.classList.add('hidden');
        loginBox.classList.remove('hidden');
    });
}

// Mobile Menu Toggle
const toggleButton = document.querySelector('.mobile-menu-toggle');
const header = document.querySelector('header');

if (toggleButton && header) {
    toggleButton.addEventListener('click', () => {
        header.classList.toggle('open');
    });
}

// Like Button Toggle
document.querySelectorAll('.like-button').forEach(button => {
    button.addEventListener('click', () => {
        const icon = button.querySelector('i');
        icon.classList.toggle('liked');
    });
});

// Comment Buttons Toggle
const commentButtons = document.querySelectorAll('.comment-button');
const commentSections = document.querySelectorAll('.comment-section');

if (commentButtons.length && commentSections.length) {
    commentSections.forEach(section => (section.style.display = 'none'));

    commentButtons.forEach((button, index) => {
        button.addEventListener('click', () => {
            const section = commentSections[index];
            section.style.display = section.style.display === 'none' ? 'block' : 'none';
        });
    });
}

// Share Button Copy to Clipboard
document.querySelectorAll('.share-button').forEach(button => {
    button.addEventListener('click', () => {
        const link = button.getAttribute('data-link');
        navigator.clipboard.writeText(link).then(() => {
            alert('Link copied to clipboard!');
        }).catch(err => {
            console.error('Failed to copy link: ', err);
        });
    });
});

// Submit Comment Functionality
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

// Search Functionality
const searchInput = document.querySelector('.search-input');
const searchButton = document.querySelector('.search-button');
const newsCards = document.querySelectorAll('.news-card');

function searchNews() {
    const query = searchInput.value.toLowerCase().trim();
    newsCards.forEach(card => {
        const heading = card.querySelector('.news-heading').textContent.toLowerCase();
        const description = card.querySelector('.news-description').textContent.toLowerCase();
        const meta = card.querySelector('.news-date').textContent.toLowerCase();
        card.style.display = heading.includes(query) || description.includes(query) || meta.includes(query) ? 'block' : 'none';
    });
}

if (searchInput && searchButton) {
    searchInput.addEventListener('input', searchNews);
    searchButton.addEventListener('click', searchNews);
}
