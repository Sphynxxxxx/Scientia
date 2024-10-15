
//for mobile menu
const toggleButton = document.querySelector('.mobile-menu-toggle');
const header = document.querySelector('header');

toggleButton.addEventListener('click', () => {
    header.classList.toggle('open');
});

// for the like button
const likeButton = document.querySelector('.like-button');


likeButton.addEventListener('click', () => {
    const icon = likeButton.querySelector('i');
    icon.classList.toggle('liked');
});

// Comment Button Functionality: Toggle Comment Section
const commentButton = document.querySelector('.comment-button');
const commentSection = document.querySelector('.comment-section');

commentButton.addEventListener('click', () => {
    
    commentSection.style.display = 
        commentSection.style.display === 'none' ? 'block' : 'none';
});

// Submit Comment Functionality
const submitCommentButton = document.querySelector('.submit-comment');
const commentInput = document.querySelector('.comment-input');
const commentsDisplay = document.querySelector('.comments-display');

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


