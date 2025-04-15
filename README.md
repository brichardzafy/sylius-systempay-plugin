<p align="center">
    <a href="https://sylius.com" target="_blank">
        <picture>
          <source media="(prefers-color-scheme: dark)" srcset="https://media.sylius.com/sylius-logo-800-dark.png">
          <source media="(prefers-color-scheme: light)" srcset="https://media.sylius.com/sylius-logo-800.png">
          <img alt="Sylius Logo." src="https://media.sylius.com/sylius-logo-800.png">
        </picture>
    </a>
</p>

<h1 align="center">Plugin Sytempay</h1>


## Documentation

The goal of this documentation is to show how to make it in a Sylius project.

## Quickstart Installation

Run `git clone https://github.com/brichardzafy/sylius-systempay-plugin ProjectDir/src/Plugins/sylius-systempay-plugin`.

### Traditional

1. In the composer.json of your project, add two lines :
   
    ```bash
      require : {..., "lyracom/rest-php-sdk": "4.0.0" },
      "autoload": {
        "psr-4": {
            ...,
            "Sylius\\SystempayPlugin\\": "src/Plugin/sylius-systempay-plugin/src/"
        }
      },
    ```

To enable support for these configurations in the project

2. Run :

      ```bash
      composer update
      ```

3. Now, copy the translation form that you can see here
      ```bash
       src/Plugin/sylius-systempay-plugin/src/Resources/translations/form.fr.yaml
      ```
4. As a final step, enable the plugin in the bundle.php file within the project:
      ```bash
        
        <?php

          return [
              ...,
              Sylius\SystempayPlugin\SyliusSystempayPlugin::class => ['all' => true]
          ];
      ```