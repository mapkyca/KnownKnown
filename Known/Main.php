<?php

namespace IdnoPlugins\Known {

    class Main extends \Idno\Common\Plugin {

	public static function getRedirectUrl() {
	    return \Idno\Core\site()->config()->url . 'known/callback';
	}

	public static function getState() {
	    return md5(\Idno\Core\site()->config()->site_secret . \Idno\Core\site()->config()->url . dirname(__FILE__));
	}

	function registerPages() {
	    // Register the callback URL
	    \Idno\Core\site()->addPageHandler('known/callback', '\IdnoPlugins\Known\Pages\Callback');
	    // Register admin settings
	    \Idno\Core\site()->addPageHandler('admin/known', '\IdnoPlugins\Known\Pages\Admin');
	    // Register settings page
	    \Idno\Core\site()->addPageHandler('account/known', '\IdnoPlugins\Known\Pages\Account');

	    /** Template extensions */
	    // Add menu items to account & administration screens
	    \Idno\Core\site()->template()->extendTemplate('admin/menu/items', 'admin/known/menu');
	    \Idno\Core\site()->template()->extendTemplate('account/menu/items', 'account/known/menu');
	}

    }

}
