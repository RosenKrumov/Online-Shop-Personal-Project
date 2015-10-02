<div class="main">
    <div class="content">
        <div class="login_panel">
            <h3>Existing Customers</h3>
            <p>Sign in with the form below.</p>
            <?= \Framework\ViewHelpers\FormViewHelper::init()
                ->setAttribute("id", "member")
                ->setMethod("post")
                ->setAction('/users/loginpost')
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
                ->setValue("Sign in")
                ->create()
                ->render()?>
        </div>
        <div class="clear"></div>
    </div>
</div>