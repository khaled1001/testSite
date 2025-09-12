document.addEventListener("DOMContentLoaded", function () {
  const requestList = document.getElementById("request-list");
  const loading = document.getElementById("loading");

  fetch("get_requests.php")
    .then(res => res.json())
    .then(data => {
      loading.style.display = "none";
      data.forEach(req => {
        const card = document.createElement("div");
        card.className = "request-card";
        card.innerHTML = `
          <div class="vote-section">
            <button class="upvote-btn" data-id="${req.id}">
              <i class="fas fa-chevron-up"></i>
            </button>
            <span class="vote-count">${req.vote_count}</span>
          </div>
          <div class="card-content">
            <h3>${req.title}</h3>
            <p>${req.details}</p>
            <div class="card-footer">
              <span>by ${req.submitted_name}</span>
              <span class="status ${req.status.toLowerCase()}">${req.status}</span>
            </div>
          </div>
        `;
        card.querySelector(".upvote-btn").onclick = function () {
          const requestId = this.getAttribute("data-id");
          fetch("upvote.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `request_id=${requestId}`
          })
            .then(res => res.json())
            .then(res => {
              if (res.status === "success") {
                const count = card.querySelector(".vote-count");
                count.textContent = parseInt(count.textContent) + 1;
                this.disabled = true;
              } else {
                alert(res.message);
              }
            });
        };
        requestList.appendChild(card);
      });
    });

  // Modal
  const modal = document.getElementById("post-request-modal");
  const openBtn = document.getElementById("open-post-modal");
  const closeBtn = modal.querySelector(".close-btn");
  const cancelBtn = modal.querySelector(".cancel-btn");

  openBtn.onclick = () => modal.style.display = "block";
  closeBtn.onclick = cancelBtn.onclick = () => modal.style.display = "none";

  document.getElementById("submit-request-form").addEventListener("submit", function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch("submit_request.php", {
      method: "POST",
      body: new URLSearchParams(formData)
    })
      .then(res => res.text())
      .then(msg => {
        alert(msg);
        modal.style.display = "none";
        location.reload();
      });
  });
});
