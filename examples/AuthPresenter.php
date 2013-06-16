<?php

/**
 * Presenter that is handling all oauth requests and callbacks
 *
 * @author Michal Svec <pan.svec@gmail.com>
 */
class AuthPresenter extends \Nette\Application\UI\Presenter
{
	/** @var NetteOpauth\NetteOpauth */
	protected $opauth;

	/**
	 * @param NetteOpauth\NetteOpauth
	 */
	public function injectOpauth(NetteOpauth\NetteOpauth $opauth)
	{
		$this->opauth = $opauth;
	}

	/**
	 * Redirection method to oauth provider
	 *
	 * @param string|NULL $strategy strategy used depends on selected provider - 'fake' for localhost testing
	 */
	public function actionAuth($strategy = NULL)
	{
		$this->opauth->auth($strategy);
		$this->terminate();
	}

	public function actionCallback()
	{
		$identity = $this->opauth->callback();
		
		$this->context->user->login($identity);
		$this->redirect("Homepage:default");
	}

	/**
	 * Basic logout action - feel free to use your own in different presenter
	 */
	public function actionLogout()
	{
		$this->getUser()->logout(TRUE);
		$this->redirect("Homepage:default");
	}
}
