<div class="row">

    <div class="col-offset-10 col-md-offset-1">
        <h1>Known</h1>
	<?= $this->draw('admin/menu') ?>
    </div>

</div>
<div class="row">
    <div class="col-offset-10 col-md-offset-1">
        <form action="/admin/known/" class="form-horizontal" method="post">
            <div class="control-group">
                <div class="controls">
                    <p>
                        To begin using Known cross posting, install an OAuth2 client (e.g. https://github.com/mapkyca/KnownOAuth2) on your remote site, then create a new application.
                    </p>
                </div>
            </div>
	    <div class="control-group">
                <label class="control-label" for="name">Known site URL</label>
                <div class="controls">
                    <input type="url" id="name" placeholder="Site url" class="col-offset-4" name="site" value="<?= htmlspecialchars(\Idno\Core\site()->config()->known['site']) ?>" required >
                </div>

		<hr />
            </div>
            <div class="control-group">
		<div class="controls">
		    <p>
			If you plan to connect via <a href="https://github.com/mapkyca/KnownOAuth2" target="_blank">OAuth2</a>, enter the application details below.
		    </p>
		</div>
                <label class="control-label" for="name">Client ID</label>
                <div class="controls">
                    <input type="text" id="name" placeholder="App Key" class="col-offset-4" name="appId" value="<?= htmlspecialchars(\Idno\Core\site()->config()->known['appId']) ?>" >
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="name">Client Secret</label>
                <div class="controls">
                    <input type="text" id="name" placeholder="Secret Key" class="col-offset-4" name="secret" value="<?= htmlspecialchars(\Idno\Core\site()->config()->known['secret']) ?>" >
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
	    <?= \Idno\Core\site()->actions()->signForm('/admin/known/') ?>
        </form>
    </div>
</div>