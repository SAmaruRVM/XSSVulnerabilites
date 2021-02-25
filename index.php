<?php include_once 'Includes/head.php'; ?>
<?php if ((($user = $cookie->IsLoggedIN())) === null): ?>
<main class="flex-column-center">
    <form action="Ajax/Login.php" method="POST" id="login__form" class="flex-column-center">
        <h1>
            Login
        </h1>
        <label>
            Username
            <input type="text" name="login_username_submit" placeholder="Your username" autofocus />
        </label>
        <label>
            Password
            <input type="password" name="login_password_submit" placeholder="Your password" />
        </label>
        <button type="submit">
            Login
            <i class="fas fa-sign-in-alt">
            </i>
        </button>
        <p class="error__text">
            Your credentials are not correct. Please try again.
        </p>
    </form>
</main>
<?php else: ?>
<?php
    $session = new Session();
    $session->setSession(SESSION::USER_ID_SESSION, $user->getID());
?>
<main>
    <section class="user__posting flex-row-center flex-row-start">
        <img class="full__circle" alt="User profile picture"
            src="<?= ROOT_PATH . "/Admin/Images/{$user->getImage()}" ?>" />
        <input id="user__posting__input" type="text" placeholder="<?= "What's new, {$user->getUsername()}?" ?>"
            autofocus />
        <button id="user__posting__post__btn" class="user__posting__post__btn"
            onclick="inserirNovoPost(<?= $session->getSession(SESSION::USER_ID_SESSION) ?>)">
            Post
        </button>
    </section>
    <?php foreach (Post::getAll() as $post): ?>
    <section class="user__post flex-row-center flex-row-start">
        <div class="flex-column-start">
            <div class="flex-row-center">
                <img class="full__circle" alt="User profile picture"
                    src="<?= ROOT_PATH . "/Admin/Images/$post->userImage" ?>" />
                <p>
                    <?= $post->username ?>
                    <br />
                    <span>
                        <?= $post->date ?>
                    </span>
                </p>
            </div>
            <p class="post__content__text">
                <?= $post->content ?>
            </p>
            <hr />
            <div class="flex-row-center">
                <button class="user__post__action" data-action="like">
                    <i class="far fa-thumbs-up">

                    </i>
                    <?= $post->likes ?>
                </button>
            </div>
        </div>
    </section>
    <?php endforeach ?>
    <button id="logout__btn">
        <i class="fas fa-arrow-circle-left"></i>
    </button>
</main>
<?php endif; ?>
<?php include_once "Includes/footer.php"; ?>