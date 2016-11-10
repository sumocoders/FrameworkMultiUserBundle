« [back to overview](index.md)
***
# Installation

1. Before you do anything, check if you have [Composer](https://getcomposer.org/) installed. Chances are you already do!

2. Require the multi user bundle

		composer require sumocoders/framework-multi-user-bundle

3. Enable the bundle in the kernel.

	```php
	<?php
	// app/AppKernel.php
	
	public function registerBundles()
	{
	    // ...
	    $bundles = array(
	        // ...
	        new SumoCoders\FrameworkExampleBundle\SumoCodersFrameworkMultiUserBundle(),
	    );
	}
	```

4. That's it! You've successfully installed the multi user bundle. To make it work properly, you have a few more steps to go, though. Head on over to the next step, [Routing](routing.md).
***        
[Routing](routing.md) »