<?php

/**
 * Known pages
 */

namespace IdnoPlugins\Known\Pages {

    /**
     * Default class to serve Known-related account settings
     */
    class Account extends \Idno\Common\Page {

	function getContent() {
	    $this->gatekeeper(); // Logged-in users only

	    if ($known = \Idno\Core\site()->plugins()->get('Known')) {
		if (!$known->hasKnown()) {
		    if ($knownAPI = $known->connect()) {
			$login_url = $knownAPI->getAuthenticationUrl(
				\Idno\Core\site()->config()->known['site'] . 'oauth2/authorise', ['response_type' => 'code', 'state' => \IdnoPlugins\Known\Main::getState(), 'redirect_uri' => \IdnoPlugins\Known\Main::getRedirectUrl()]
			);
		    }
		} else {
		    $login_url = '';
		}
	    }
	    $t = \Idno\Core\site()->template();
	    $body = $t->__(['login_url' => $login_url])->draw('account/known');
	    $t->__(['title' => 'Known Crosspost', 'body' => $body])->drawPage();
	}

	function postContent() {
	    $this->gatekeeper(); // Logged-in users only
	    if (($this->getInput('remove'))) {
		$user = \Idno\Core\site()->session()->currentUser();
		$user->known = [];
		$user->save();
		\Idno\Core\site()->session()->addMessage('Your Known Crosspost settings have been removed from your account.');
	    } else {
		$user = \Idno\Core\site()->session()->currentUser();
		$user->known = [
		    'username' => $this->getInput('username'),
		    'known_api_key' => $this->getInput('known_api_key')
		];

		$user->save();
		\Idno\Core\site()->session()->addMessage('Your Known api details were saved.');
	    }
	    $this->forward('/account/known/');
	}

    }

}