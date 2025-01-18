# Contributing to CompressMyPhotos Image

First off, thank you for considering contributing to CompressMyPhotos Image. It's people like you that make CompressMyPhotos Image such a great tool.

## Where do I go from here?

If you've noticed a bug or have a feature request, make one! It's generally best if you get confirmation of your bug or approval for your feature request this way before starting to code.

## Fork & create a branch

If this is something you think you can fix, then fork CompressMyPhotos Image and create a branch with a descriptive name.

A good branch name would be (where issue #325 is the ticket you're working on):

git checkout -b 325-add-japanese-localization

## Get the test suite running

Make sure you're using the latest version of PHP and Composer. Then, install the dependencies and run the tests:

```bash
composer install
composer test
```
## Implement your fix or feature
At this point, you're ready to make your changes! Feel free to ask for help; everyone is a beginner at first.

## Make a Pull Request
At this point, you should switch back to your master branch and make sure it's up to date with CompressMyPhotos Image's master branch:

```bash
git remote add upstream git@github.com:compressmyphotos/image.git
git checkout master
git pull upstream master
```

Then update your feature branch from your local copy of master, and push it!

```bash
git checkout 325-add-japanese-localization
git rebase master
git push --set-upstream origin 325-add-japanese-localization
```
Go to the CompressMyPhotos Image repo and press the "Compare & pull request" button.

## Keeping your Pull Request updated
If a maintainer asks you to "rebase" your PR, they're saying that a lot of code has changed, and that you need to update your branch so it's easier to merge.

To learn more about rebasing in Git, there are a lot of good resources but here's the suggested workflow:

``` bash
git checkout 325-add-japanese-localization
git pull --rebase upstream master
git push --force-with-lease 325-add-japanese-localization
```

## Code review
A team member will review your pull request and provide feedback. Please be patient as pull requests are often reviewed in batches.

## Merging a PR (maintainers only)

A PR can only be merged into master by a maintainer if:

- It is passing CI.
- It has been approved by at least two maintainers. If it was a maintainer who opened the PR, only one extra approval is needed.
- It has no requested changes.
- It is up to date with current master.

Any maintainer is allowed to merge a PR if all of these conditions are met.

##  Shipping a release (maintainers only)
Maintainers need to do the following to push out a release:

- Make sure all pull requests are in and that changelog is current
- Update version number in composer.json
- Create a tag in git
- Push the tag to GitHub
- Draft a new release on GitHub

Thank you for your contributions!

