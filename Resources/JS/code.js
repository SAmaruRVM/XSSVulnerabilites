"use strict";
const postsLikeButtons = document?.querySelectorAll(".user__post .user__post__action[data-action=like]");
const loginForm = document?.getElementById("login__form");
const errorText = document?.querySelector(".error__text");
const postInput = document?.getElementById("user__posting__input");
const postButton = document?.getElementById("user__posting__post__btn");
const main = document?.querySelector("main");
const logoutButton = document?.getElementById("logout__btn");
loginForm?.addEventListener("submit", (e) => {
    if (errorText.classList.contains("show__error__text")) {
        errorText.classList.remove("show__error__text");
    }
    let isFormValid = true;
    e.preventDefault();
    const formData = new FormData(loginForm);
    formData.forEach((data) => {
        if (data.trim().length <= 0) {
            errorText.classList.add("show__error__text");
            isFormValid = false;
        }
    });
    if ((isFormValid)) {
        formData.append("action", "login");
        fetch("Ajax/Login.php", {
            method: "POST",
            body: formData
        })
            .then((response) => response.text())
            .then((response) => {
                switch (response.toLowerCase()) {
                    case "success":
                        window.location.href = window.location.href;
                        break;
                    case "error":
                        errorText.classList.add("show__error__text");
                        break;
                }
            })
            .catch((error) => {

            });
    }
})
postsLikeButtons?.forEach((likeButton) => likeButton.addEventListener("click", () => {
    if ((likeButton.classList.contains("user__post__liked"))) {
        likeButton.classList.remove("user__post__liked");
        likeButton.innerHTML = `<i class="far fa-thumbs-up"></i> 
         ${+likeButton.textContent.trim() - 1}`;
    }
    else {
        likeButton.classList.add("user__post__liked");
        likeButton.innerHTML = `<i class="far fa-thumbs-up"></i> 
        ${+likeButton.textContent.trim() + 1}`;
    }
}));
postInput?.addEventListener("keyup", function () {
    if (this.value.trim() <= 0) {
        if ((postButton.classList.contains("show__user__posting__post__btn"))) {
            postButton.classList.remove("show__user__posting__post__btn");
        }
    }
    else {
        if (!(postButton.classList.contains("show__user__posting__post__btn"))) {
            postButton.classList.add("show__user__posting__post__btn");
        }
    }
})
logoutButton?.addEventListener("click", () => {
    const formData = new FormData();
    formData.append("action", "logout");
    fetch("Ajax/Logout.php", {
        method: "POST",
        body: formData
    })
        .then(() => window.location.href = window.location.href)
        .catch(() => window.location.href = window.location.href);
});
function inserirNovoPost(userID) {
    if (postInput.value.trim() <= 0) {

    }
    else {
        const formData = new FormData();
        formData.append("post__content__submit", postInput.value.trim());
        formData.append("post__userID__submit", userID);
        formData.append("action", "insert");
        fetch("Ajax/Post.php", {
            method: "POST",
            body: formData
        })
            .then((response) => response.json())
            .then((response) => {
                const postToInsert = `<section class="user__post flex-row-center flex-row-start">
                    <div class="flex-column-start">
                        <div class="flex-row-center">
                            <img class="full__circle" alt="User profile picture"
                                src="${response._user._image}" />
                            <p>
                                ${response._user._username}
                                <br />
                                <span>
                                ${response._createdDate}
                                </span>
                            </p>
                        </div>
                        <p class="post__content__text">
                        ${response._content}
                        </p>
                        <hr />
                        <div class="flex-row-center">
                            <button class="user__post__action" data-action="like">
                                <i class="far fa-thumbs-up">

                                </i>
                                ${response._numberOfLikes}
                            </button>
                        </div>
                    </div>
                </section>`;
                postButton.parentElement.insertAdjacentHTML("afterend", postToInsert);
                postInput.value = "";
            })
            .catch(() => {

            });
    }
}