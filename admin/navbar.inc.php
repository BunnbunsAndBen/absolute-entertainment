<nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
                <div class="navbar-brand">
                    <a class="navbar-item" href="<?= $rootUrl ?>">
                    <img class="logo" src="<?= $rootAssetsUrl ?>images/logo-wide-white.png" height="64">
                    </a>

                    <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="mainNavbar">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    </a>
                </div>

                <div id="mainNavbar" class="navbar-menu">
                    <div class="navbar-start">
                        <a href="<?= $rootUrl ?>admin/" class="navbar-item <?php echo ($pageTitle == 'Admin Portal') ? 'is-active' : ''; ?>">
                            Home
                        </a>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link has-text-weight-semibold">
                                Users
                            </a>
                            <div class="navbar-dropdown is-boxed">
                                <a class="navbar-item <?php echo ($pageTitle == 'Users') ? 'is-active' : ''; ?>" href="<?= $rootUrl ?>admin/users/">
                                    User accounts
                                </a>
                                <a class="navbar-item <?php echo ($pageTitle == 'Register User') ? 'is-active' : ''; ?>" href="<?= $rootUrl ?>admin/register/">
                                    Register
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="navbar-end">
                        <div class="navbar-item">
                            <div class="buttons">
<?php if($loggedIn) { ?>
                            </div>
                        </div>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link has-text-weight-semibold">
                                <?= escape($_SESSION['name']); ?>
                            </a>
                            <div class="navbar-dropdown is-boxed is-right">
                                <a class="navbar-item" href="<?= $rootUrl ?>">
                                    Website Home
                                </a>
                                <a class="navbar-item" href="<?= $rootUrl ?>login/?action=logout">
                                    Sign out
                                </a>
                            </div>
                        </div>
<?php }else { ?>
                                <a href="<?= $rootUrl ?>login/" class="button is-light">
                                    Sign in
                                </a>
                            </div>
                        </div>
<?php } ?>
                    </div>
                </div>
            </nav>
