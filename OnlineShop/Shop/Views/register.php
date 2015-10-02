<div class="main">
    <div class="content">
        <div class="login_panel">
            <h3>Register</h3>
            <?= \Framework\ViewHelpers\FormViewHelper::init()
                ->setAttribute("id", "member")
                ->setMethod("post")
                ->setAction("/users/registerpost")
                ->initTextField()
                ->setName("Username")
                ->setAttribute("placeholder", "Username")
                ->setClasses("field")
                ->create()
                ->initPasswordField()
                ->setName("Password")
                ->setAttribute("placeholder", "Password")
                ->setClasses("field")
                ->create()
                ->initSubmit()
                ->setClasses("grey")
                ->setValue("Register")
                ->create()
                ->render()?>
        </div>
        <div class="clear"></div>
    </div>
</div>