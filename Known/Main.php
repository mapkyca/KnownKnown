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

	function registerEventHooks() {

	    $types = ['note', 'article', 'place', 'image'];

	    // Register syndication services
	    \Idno\Core\site()->syndication()->registerService('known', function() {
		return $this->hasKnown();
	    }, $types);

	    foreach ($types as $type) {
		\Idno\Core\site()->addEventHook("post/$type/known", function(\Idno\Core\Event $event) {
		    $object = $event->data()['object'];
		    if ($this->hasKnown()) {
			if ($knownAPI = $this->connect()) {
			    $knownAPI->setAccessToken(\Idno\Core\site()->session()->currentUser()->known['access_token']);

			    $parameters = $_POST;

			    // Work out action
			    $action = $parameters['__bTa'];

			    // Unset some vars that don't make sense in this context
			    foreach (['syndication', '__bTs', '__bTk', '__bTa'] as $verboten) {
				unset($parameters[$verboten]);
			    }

			    // Handle image
			    if (count($_FILES)) {
				foreach ($_FILES as $file => $data) {
				    $parameters[$file] = "@{$data['tmp_name']};filename={$data['name']};type={$data['type']}";
				}
			    }
			    
			    $result = \Idno\Core\Webservice::post(rtrim(\Idno\Core\site()->config()->known['site'], ' /') . $action . "?access_token={$knownAPI->access_token}", $parameters, ['Accept: application/json']);
			    $content = json_decode($result['content']);

			    if (($result['response'] == 200) && (isset($content->object->url))) {
				$object->setPosseLink('known', $content->object->url);
				$object->save();
			    } else if ($result['response'] == 404) {
				\Idno\Core\site()->session()->addErrorMessage('It doesn\'t look like the remote site has enabled support for this feature!');
			    } else {
				\Idno\Core\site()->session()->addErrorMessage('There was a problem cross posting to Known');
			    }
			    
			    // See if we have any messages
			    if (!empty($content->messages) && is_array($content->messages))
			    {
				foreach ($content->messages as $message) {
				    \Idno\Core\site()->session()->addMessage("Remote site says: " .$message->message, $message->message_type);
				}
			    }
			}
		    }
		});
	    }
	}

	/**
	 * Connect to Known
	 * @return bool|\IdnoPlugins\Known\Client
	 */
	function connect() {
	    if (!empty(\Idno\Core\site()->config()->known)) {
		$api = new Client(
			\Idno\Core\site()->config()->known['appId'], \Idno\Core\site()->config()->known['secret'], \Idno\Core\site()->config()->known['site']
		);
		return $api;
	    }
	    return false;
	}

	/**
	 * Can the current user use Known?
	 * @return bool
	 */
	function hasKnown() {
	    if (\Idno\Core\site()->session()->currentUser()->known) {
		return true;
	    }
	    return false;
	}

    }

}
