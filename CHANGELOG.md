# CHANGELOG

## [v5.1.0](https://github.com/softspring/components/releases/tag/v5.1.0)

### Upgrading

*Nothing to do on upgrading*

### Commits

- [61227ea](https://github.com/softspring/components/commit/61227ea54446ace06b3c3bde7704f36a20a2429c): Update dependabot
- [d039cd4](https://github.com/softspring/components/commit/d039cd4e1c29a8196ff678e68bfcd98e40c762e5): Configure dependabot and phpmd
- [d68e34f](https://github.com/softspring/components/commit/d68e34fbaca1093403d413bfb890c23ca162827c): Add admin assets
- [e6002df](https://github.com/softspring/components/commit/e6002dfdf7ae10136c98c423fbc250f6bbed1b7d): Update assets and prevent error when no user-bundle is present
- [fc21cbe](https://github.com/softspring/components/commit/fc21cbeb4151de2a72addf6d5ee6620687571753): Add route variables for pager
- [b2b4750](https://github.com/softspring/components/commit/b2b4750706b8df6716202ffa21397e3f984ca67f): Add manifest block
- [6f44170](https://github.com/softspring/components/commit/6f44170b561a4750a42fa7b0ef5e6767b2112748): Improve templates
- [13a2ea0](https://github.com/softspring/components/commit/13a2ea01c1b615c7f641b817c5282401b92b409c): Remove unneeded divs
- [e70526a](https://github.com/softspring/components/commit/e70526a7d2fc52436091f040f47de958ca8ccd0f): Add filters blocks to table templates
- [e59a21f](https://github.com/softspring/components/commit/e59a21fac263cecf2ed406511077d3e99b4260b6): Add some semantic-ui templates
- [9b7d52a](https://github.com/softspring/components/commit/9b7d52aed24fca17954bdcc7d4265c321d019eb4): Update changelog for v5.0.6
- [4175c60](https://github.com/softspring/components/commit/4175c60fe4fba255427e2f4b75205f97a3a0d5f4): Configure new 5.1 development version
- [4d933c1](https://github.com/softspring/components/commit/4d933c1bff6c9ad25b7b71a076d90099d1a7e27a): Add 5.1 branch alias to composer.json

### Changes

```
 .github/dependabot.yml                            |  12 +++
 .github/workflows/php.yml                         |   4 +-
 .github/workflows/phpmd.yml                       |  57 ++++++++++
 CHANGELOG.md                                      |   4 -
 README.md                                         |   2 +-
 assets/layout/_admin-page-content.bootstrap5.scss |  13 +++
 assets/layout/_page-sidebar.bootstrap5.scss       | 126 ++++++++++++++++++++++
 composer.json                                     |   3 +-
 docs/1_installation.md                            |   2 +-
 templates/base.bootstrap5.html.twig               |   6 +-
 templates/layout/admin.bootstrap5.html.twig       |  17 ++-
 templates/paginator/pager.bootstrap5.html.twig    |  11 +-
 templates/paginator/pager.semantic-ui.html.twig   |  33 ++++++
 templates/paginator/table.bootstrap5.html.twig    |  27 +++--
 templates/paginator/table.semantic-ui.html.twig   |  59 ++++++++++
 15 files changed, 349 insertions(+), 27 deletions(-)
```

## [v5.0.5](https://github.com/softspring/components/releases/tag/v5.0.5)

### Upgrading

*Nothing to do on upgrading*

### Commits

- [f7ff7b7](https://github.com/softspring/components/commit/f7ff7b76348e42c12592ab4e2e18879392963808): Update changelog

### Changes

```
 CHANGELOG.md | 21 +++++++++++++++++++++
 1 file changed, 21 insertions(+)
```

## [v5.0.4](https://github.com/softspring/components/releases/tag/v5.0.4)

*Nothing has changed since last v5.0.3 version*

## [v5.0.3](https://github.com/softspring/components/releases/tag/v5.0.3)

*Nothing has changed since last v5.0.2 version*

## [v5.0.2](https://github.com/softspring/components/releases/tag/v5.0.2)

*Nothing has changed since last v5.0.1 version*

## [v5.0.1](https://github.com/softspring/components/releases/tag/v5.0.1)

*Nothing has changed since last v5.0.0 version*

## [v5.0.0](https://github.com/softspring/components/releases/tag/v5.0.0)

*Previous versions are not in changelog*
