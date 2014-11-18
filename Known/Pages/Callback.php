<?php

/**
 * Known pages
 */

namespace IdnoPlugins\Known\Pages {

    /**
     * Default class to serve the Known callback
     */
    class Callback extends \Idno\Common\Page {

	function getContent() {
	    $this->gatekeeper(); // Logged-in users only

	    try {
		if ($known = \Idno\Core\site()->plugins()->get('Known')) {
		    if ($knownAPI = $known->connect()) {

			if ($response = $knownAPI->getAccessToken('authorization_code', [
			    'code' => $this->getInput('code'), 
			    'redirect_uri' => \IdnoPlugins\Known\Main::getRedirectUrl(), 
			    'state' => \IdnoPlugins\Known\Main::getState()])) {

			    $response = json_decode($response['content']);
			    
			    $user = \Idno\Core\site()->session()->currentUser();
			    $user->known = ['access_token' => $response->access_token];
			    
			    $user->save();
			    \Idno\Core\site()->session()->addMessage('Your Known account was connected.');
			}
		    }
		}
	    } catch (\Exception $e) {
		\Idno\Core\site()->session()->addErrorMessage($e->getMessage());
	    }
	    
	    $this->forward('/account/known/');
	}

    }

}