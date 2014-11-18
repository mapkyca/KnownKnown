<div class="row">

    <div class="span10 offset1">
        <h3>Known</h3>
        <?=$this->draw('account/menu')?>
    </div>

</div>
<div class="row">
    <div class="span10 offset1">
        <form action="/account/known/" class="form-horizontal" method="post">
            <?php
                if (empty(\Idno\Core\site()->session()->currentUser()->known)) {
            ?>
                    <div class="control-group">
                        <div class="controls">
                            <p>
                                If you have a remote Known account, you may connect it here. Public content that you
                                post to this site will be automatically cross-posted to your Known wall.
                            </p>
                            <p>
                                <a href="<?=$vars['login_url']?>" class="btn btn-large btn-success">Click here to connect Known to your account</a>
                            </p>
                        </div>
                    </div>
                <?php

                } else {

                    ?>
                    <div class="control-group">
                        <div class="controls">
                            <p>
                                Your account is currently connected to a remote Known server. Public content that you post here
                                will be shared with your Known account.
                            </p>
                            <p>
                                <input type="hidden" name="remove" value="1" />
                                <button type="submit" class="btn btn-large btn-primary">Click here to remove Known from your account.</button>
                            </p>
                        </div>
                    </div>

                <?php

                }
            ?>
            <?= \Idno\Core\site()->actions()->signForm('/account/known/')?>
        </form>
    </div>
</div>