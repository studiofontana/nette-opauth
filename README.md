michalsvec/nette-opauth
============================

Requirements
------------

As it's an Opauth extension for Nette framework, it requires

- [Nette Framework 2.1.*](https://github.com/nette/nette)
- [Opauth](https://github.com/opauth/opauth)

Installation
------------

Update composer.json:
```json
"require": {
    "michalsvec/nette-opauth": "*"
}
```
and then

```sh
$ composer install
```

Update bootstrap.php:
```php
// add compiler extension
$configurator->onCompile[] = function (\Nette\Config\Configurator $config, \Nette\Config\Compiler $compiler) {
	$compiler->addExtension('opauth', new NetteOpauth\DI\Extension());
};

// register routers
\NetteOpauth\NetteOpauth::register($container->router);
```

Check if routes are in proper order (auth routes before the commons).
And update Auth presenter as shown in example.

Then you can use:
```html
{if Nette\Config\Configurator::detectDebugMode()}
	<a href="{plink Auth:callback, strategy => 'fake'}">Fake login</a><br/>
{/if}
<a href="{plink Auth:google}">Sign-in with Google</a><br/>
<a href="{plink Auth:facebook}">Sign-in with Facebook</a><br/>
<a href="{plink Auth:twitter}">Sign-in with Twitter</a><br/>
<a href="{plink Auth:linkedin}">Sign-in with LinkedIn</a><br/>
```

Configure in config.neon
------------
```
opauth:
	path: '/auth/'
	debug: false
	callback_url: '{path}callback'
	security_salt: '123abc456def'
	callback_transport: 'session'
	Strategy:
		Facebook:
			app_id: ''
			app_secret: ''
		Google:
			client_id: ''
			client_secret: ''
		Twitter:
			key: ''
			secret: ''
		LinkedIn:
			api_key: ''
			secret_key: ''
```

Tips and triks
--------------

 * opauth needs public callback url to proper redirect thus is impossible to use it at localhost (except the fake login).
 * facebook
    * registration of [app](https://developers.facebook.com/apps)
 * google
    * registration of [app](https://code.google.com/apis/console)
    * google ids are very long (more than unsigned int) be careful about that
 * twitter
    * registration of [app](https://dev.twitter.com/apps)
    * do not provide email
 * linkedin
    * registration of [app](https://www.linkedin.com/secure/developer)
    * provide OAuth 2.0 Redirect URLs in app registration: http://yourdomain.tld/auth/linkedin/oauth2callback
    * to obtain email, include r_emailaddress to scope, eg.: 'scope' => 'r_basicprofile r_emailaddress'.


Roadmap
-------
- [ ] add more identities for various providers

