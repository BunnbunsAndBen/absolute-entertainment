        <nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
            <div class="navbar-brand">
                <a class="navbar-item" href="<?= $rootUrl ?>">
                <img class="logo" src="<?= $rootAssetsUrl ?>/images/logo-wide-white.png" height="64">
                </a>

                <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="mainNavbar">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                </a>
            </div>

            <div id="mainNavbar" class="navbar-menu">
                <div class="navbar-start">
                <a href="<?= $rootUrl ?>" class="navbar-item <?php echo ($pageTitle == 'Home') ? 'is-active' : ''; ?>">
                    Home
                </a>
                <a href="<?= $rootUrl ?>reviews/" class="navbar-item <?php echo ($pageTitle == 'Reviews') ? 'is-active' : ''; ?>">
                    Reviews
                </a>
                <a href="<?= $rootUrl ?>about/" class="navbar-item <?php echo ($pageTitle == 'About Us') ? 'is-active' : ''; ?>">
                    About
                </a>

                </div>

                <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">
                    <a href="<?= $rootUrl ?>contact/" class="button is-primary">
                        <strong>Contact Us</strong>
                    </a>
                    <a href="<?= $rootUrl ?>login/" class="button is-light">
                        Sign in
                    </a>
                    </div>
                </div>
                </div>
            </div>
        </nav>