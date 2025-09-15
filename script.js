document.addEventListener('DOMContentLoaded', () => {
    const postRequestNav = document.querySelector('.nav-links a[href="#"]');
    const modal = document.getElementById('post-request-modal');
    const closeModalBtn = document.querySelector('.modal .close-btn');
    const cancelModalBtn = document.querySelector('.modal .cancel-btn');

    // Function to open the modal
    const openModal = () => {
        modal.style.display = 'flex';
    };

    // Function to close the modal
    const closeModal = () => {
        modal.style.display = 'none';
    };

    // Handle Idea Form Submission
    const ideaForm = document.getElementById('ideaForm');
    if (ideaForm) {
        ideaForm.addEventListener('submit', async (e) => {
            e.preventDefault(); // prevent default form action
            console.log("Submitting idea...");

            // Get form values
            const title = document.getElementById('title').value.trim();
            const details = document.getElementById('details').value.trim();
            const benefit = document.getElementById('benefit').value.trim();
            const name = document.getElementById('name').value.trim();

            // Basic validation
            if (!title || !details || !benefit || !name) {
                alert("Please fill out all fields.");
                return;
            }

            try {
                const response = await fetch('submit_request.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ title, details, benefit, name })
                });

                const result = await response.json();

                if (response.ok) {
                    alert(result.message || 'Idea submitted successfully!');
                    ideaForm.reset();
                    document.getElementById('post-request-modal').style.display = 'none';
                    // Optionally reload idea cards
                } else {
                    alert(result.error || 'Submission failed.');
                }
            } catch (error) {
                console.error('Submission error:', error);
                alert('An unexpected error occurred.');
            }
        });
    }

    // Event listeners
    if (postRequestNav) {
        // A bit of a hack to find the "Post a Request" button since there are multiple `a[href="#"]`
        document.querySelectorAll('.nav-links a').forEach(a => {
            if (a.textContent === 'Post a Request') {
                a.addEventListener('click', (e) => {
                    e.preventDefault();
                    openModal();
                });
            }
        });
    }

    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeModal);
    }

    if (cancelModalBtn) {
        cancelModalBtn.addEventListener('click', closeModal);
    }

    // Close modal if user clicks outside of the modal content
    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });

    // Handle upvote clicks (for demonstration)
    document.querySelectorAll('.upvote-btn').forEach(button => {
        button.addEventListener('click', () => {
            const voteCountSpan = button.nextElementSibling;
            let voteCount = parseInt(voteCountSpan.textContent);
            if (!button.classList.contains('voted')) {
                voteCount++;
                button.classList.add('voted');
                button.style.backgroundColor = 'var(--primary-color)';
                button.style.color = 'var(--white)';
            } else {
                voteCount--;
                button.classList.remove('voted');
                button.style.backgroundColor = '';
                button.style.color = '';
            }
            voteCountSpan.textContent = voteCount;
        });
    });

    // Handle claim button clicks (for demonstration)
    document.querySelectorAll('.claim-btn').forEach(button => {
        if (button.disabled) return;

        button.addEventListener('click', () => {
            button.textContent = 'Claimed';
            button.disabled = true;
            const card = button.closest('.request-card');
            const statusSpan = card.querySelector('.status');
            if (statusSpan) {
                statusSpan.textContent = 'Claimed';
                statusSpan.className = 'status'; // reset classes
                statusSpan.style.backgroundColor = 'var(--success-color)';
                statusSpan.style.color = 'var(--white)';
            }
        });
    });
});
