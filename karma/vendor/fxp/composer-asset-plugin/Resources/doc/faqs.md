FAQs
====

What version required of Composer?
----------------------------------

See the documentation: [Installation](index.md#installation).

How does work the plugin?
-------------------------

For add dependencies of asset in Composer, The plugin uses the VCS repositories to add
each repository of a required asset.

However, to retrieve automatically the repository of an asset, the plugin needs to add
a Composer 'Repository' operating in the same way that the registry 'Packagist', but
dedicated to the NPM registry and the Bower registry. Of course, it’s still possible to
add manually an VCS repository of asset.

Once the VCS repository is selected, Composer downloads the package definition of the
main branch, together with the list of branches and tags. Of course, a conversion of
package definitions of NPM or Bower is made. Note the definitions of each package will
be got at the time when Composer will need it (in the Solver).

In this way, the plugin allows add a VCS repository by simulating the presence of the
`composer.json` file, and there is no need to add this file manually if the package is
registered in the registry of NPM or Bower, and if the file `bower.json` or
`package.json` is present in the repository.

Why does the plugin use the VCS repository?
-------------------------------------------

There are already several possibilities for managing assets in a PHP project:

1. Install Node.js and use NPM or Bower command line in addition to Composer command line
2. Do #1, but add Composer scripts to automate the process
3. Include assets directly in the project (not recommended)
4. Create a repository with all assets and include the `composer.json` file (and use
Packagist or an VCS repository)
5. Add a package repository in `composer.json` with a direct download link
6. Create a Satis or Packagist server
7. Other?

In the case of a complete project in PHP, it shouldn't be necessary to use several tools
(PHP, Nodejs, Composer, NPM, Bower, Grunt, etc.) to simply install these assets in your
project. This eliminates the possibilities 1, 2 and 3.

And the solution 6 is unfortunately not feasible, because it would regularly collect all
packages in the registries of NPM and Bower, then analyze each and every branch and
every tag of each package. The packages would not be updated immediately, and the
requests limit of API would be reached very quickly.

The solutions 4 and 5 are standard in Composer, but tyey are very onerous to manage. The
plugin allows exactly opting for this solution, while sorely simplifying these solutions.

Why is Composer slow when the plugin retrieves the package definitions?
-----------------------------------------------------------------------

For the VCS repositories, The native system of Composer retrieves the package definitions
for all branches and all tags. Once there are numerous, it may become very slow. However,
the plugin uses a caching system, allowing to not make new requests for retrieve the
definitions of packages. The next commands install/update will be much faster.

The performance to get the new package definitions could be even higher, but this requires
a change directly into Composer ([see composer/composer#3282]
(https://github.com/composer/composer/issues/3282)).

Why are the definitions from multiple versions of package retrieved to install?
-------------------------------------------------------------------------------

For the `install`, The Solver must verify that each version available answer all project
constraints.

Therefore, if constraints of version are 'flexible', then the Solver must retrieve the
definitions of package for each version who answer the constraint.

So, more you specify the version, less Composer will try to retrieve the definitions
of package.

Why are retrieved from all the version definitions of all packages to update?
-----------------------------------------------------------------------------

For the `update`, The Solver must obtain all of the definitions for each package and for
all available versions.

The plugin uses the system of VCS repository, and this can significantly slow the
retrieving of the definitions of packages. Fortunately, a caching system avoids to
download every time all versions.

With the version `>1.0.0-beta3` of the plugin, a new import filter lets you import only
package definitions greater than or equal to the installed versions. In this way, the
performances are dramatically improved.

Composer throws an exception stating that the version does not exist
--------------------------------------------------------------------

If Composer throws an exception stating that the version does not exist, whereas the
version exists, but it isn't imported: is that this new package version is lesser than
the installed version.

Of course, 3 solutions can work around the problem:

1. delete the `vendor` directory, do the `update`
2. disable temporarily the import filter in the `extra` section
3. add the dependency in the root Composer package:
  - add the dependency in the root Composer package with the required version (the version not found)
  - put the option `extra.asset-optimize-with-conjunctive` to `false`,
  - do the `update`,
  - remove the dependency in the root Composer package
  - remove the option `extra.asset-optimize-with-conjunctive`
  - do the `update` for sync the lock file,

> The solution 1 is the easiest and fastest.

See the documentation: [Disable the import filter using the installed packages]
(index.md#disable-the-import-filter-using-the-installed-packages)

How to reduce the number of requests for getting the package definitions?
-------------------------------------------------------------------------

For the `install`, more you specify the versions in your dependencies, less Composer will
try to retrieve the definitions of the packages.

For the `update`, in contrast, this is unfortunately not the case, because Composer must
retrieve all the definitions of the packages.

But a trick allows to filter the import of package definitions to the `install`, but also
for the `update`:

Add directly to your root Composer package, the dependencies that you want to filter. Of
course, all constraints of versions are functional (exact version, range, wildcard, tilde
operator). In this way, all versions are not accepted by the constraint of version and
they will be skipped to the importation, and will not be injected in the `Pool`.

See the documentation: [Reduce the number of requests for getting the package definitions]
(index.md#reduce-the-number-of-requests-for-getting-the-package-definitions)

How to increase the PHP memory limit?
-------------------------------------

See the official documentation of Composer: [Memory limits errors]
(https://getcomposer.org/doc/articles/troubleshooting.md#memory-limit-errors).

Why should I create a token for Github?
---------------------------------------

It's a rate limit of Github API. In anonymous access, Github at a greatly reduced limit
(60/hr), and you must be logged with a token for have a much higher limit (5 000/hr).

The problem also exists using Nodejs NPM and Bower.

If you want more details: [Github Personal API Tokens]
(https://github.com/blog/1509-personal-api-tokens)

See the official documentation of Composer: [API rate limit and OAuth tokens]
(https://getcomposer.org/doc/articles/troubleshooting.md#api-rate-limit-and-oauth-tokens).

How to add a Github token in the configuration?
-----------------------------------------------

See the official documentation of Composer: [API rate limit and OAuth tokens]
(https://getcomposer.org/doc/articles/troubleshooting.md#api-rate-limit-and-oauth-tokens).

Why the asset VCS repositories are placed in the 'extra' section?
-----------------------------------------------------------------

Because it's impossible to create the custom VCS repositories: Composer checks the type
of VCS repository before the loading of plugins, so, an exception is thrown.

The only way, is to put the config in `extra` section (see the [doc]
(https://github.com/francoispluchino/composer-asset-plugin/blob/master/Resources/doc/schema.md#extraasset-repositories-root-only)).
