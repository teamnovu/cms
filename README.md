<p align="center"><img src="https://statamic.com/assets/branding/Statamic-Logo+Wordmark-Rad.svg" width="400" alt="Statamic Logo" /></p>

## Teamnovu's Fork

This is a fork of the [Statamic core](https://github.com/statamic/cms) with some additional features and bugfixes.
The goal is to keep the fork as close to the original as possible. This makes it easier to merge changes from the core to the fork.

To achieve this, changes should be made as an addon instead. If this is not possible, the changes should be documented in the [DIFF-TO-CORE.md](DIFF-TO-CORE.md) file.
Ideally, a PR to the core should be opened.

### Installation

To install the fork, add the following to your `composer.json` file:

```json
{
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/teamnovu/cms.git"
        }
    ]
}
```

Then run `composer update statamic/cms` to install the fork.

## About Statamic

Statamic is the flat-first, Laravel + Git powered CMS designed for building beautiful, easy to manage websites.

> [!NOTE]
> This repository contains the code for the core Statamic Composer package, to be installed into an existing Laravel application. 
> 
> The [application repository][app-repo] is where you can find a Laravel application preconfigured with Statamic, which is used when creating a new project via the Statamic CLI tool.

## Learning Statamic

Statamic has extensive [documentation][docs]. We dedicate a significant amount of time and energy every day to improving them, so if something is unclear, feel free to open issues for anything you find confusing or incomplete. We are happy to consider anything you feel will make the docs and CMS better.

## Support

We provide official developer support on [Statamic Pro](https://statamic.com/pricing) projects. Community-driven support is available on [GitHub Discussions](https://github.com/statamic/cms/discussions) and in [Discord][discord].


## Contributing

Thank you for considering contributing to Statamic! We simply ask that you review the [contribution guide][contribution] before you open issues or send pull requests.


## Code of Conduct

In order to ensure that the Statamic community is welcoming to all and generally a rad place to belong, please review and abide by the [Code of Conduct](https://github.com/statamic/cms/wiki/Code-of-Conduct).


## Important Links

- [Statamic Main Site](https://statamic.com)
- [Statamic Documentation][docs]
- [Statamic Application Repo][app-repo]
- [Statamic Migrator](https://github.com/statamic/migrator)
- [Statamic Discord][discord]

[docs]: https://statamic.dev/
[discord]: https://statamic.com/discord
[contribution]: https://github.com/statamic/cms/blob/master/CONTRIBUTING.md
[app-repo]: https://github.com/statamic/statamic
