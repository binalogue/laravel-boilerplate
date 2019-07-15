This checklist is used whenever a project is going live.

## 1. Browserstack tests

- [ ] **Desktop**: test on latest versions of:
  - [ ] Chrome
  - [ ] Firefox
  - [ ] Safari
  - [ ] IE/Edge
- [ ] **Mobile**: test on latest versions of:
  - [ ] iOS Safari
  - [ ] Android Browser
  - [ ] Chrome for Android
  - [ ] Firefox for Android

## 2. Frontend checklist

### Assets

- [ ] **https**: search sources for `http://`; replace by `https://`.
- [ ] **Webfonts**: is the live domain configured?
  - [ ] [Google Fonts](https://fonts.google.com/)
  - [ ] [Adobe Fonts](https://fonts.adobe.com/)
  - [ ] [Fonts.com](https://www.fonts.com/)

### CSS

- [ ] **Linting**: lint CSS files:
  ```bash
  yarn lint:css
  ```
- [ ] **Browserslist**: Is the browserlist properly configured for _autoprefixer_?
- [ ] **PurgeCSS**: when using PurgeCSS, check if styles are preserved.

### JavaScript

- [ ] **Linting**: lint JavaScript files:
  ```bash
  yarn lint:js
  ```
- [ ] **Yarn**: is `yarn.lock` present?
- [ ] **Logs**: remove all `console.log` lines in scripts.
- [ ] **Errors**: check for console errors.

### _Inspector Network_

- [ ] **Total weight**: evaluate total weight of at least homepage.
- [ ] **Identify heavy assets**: open _Inspector Network_ tab to identify heavy assets.
  - [ ] Check if assets are cached. See [Google Cloud docs](https://cloud.google.com/appengine/docs/standard/python/config/appref#default_expiration).
- [ ] **Assets priority**: open _Inspector Network_ tab to check assets priority. Then make any changes in the _Preload_ section of the `app.blade.php` file.

### Audits

- [ ] **Chrome DevTools Audit: Mobile**: Use the Chrome DevTools (in incognito mode) and perform a mobile audit (with throttling) to fix common problems.
- [ ] **Chrome DevTools Audit: Desktop**: Repeat with a desktop audit.

## 3. Check content (with an open console)

- [ ] **Text and images**: Are all strings / images present (and translated)?
- [ ] **Menu**: Does menu/submenu have a correct active state on every page?
- [ ] **Error pages**: Are 404, 500 and 503 pages provided?
- [ ] **Mixed content**: Scan for mixed content with [spatie/mixed-content-scanner-cli](https://github.com/spatie/mixed-content-scanner-cli)
  ```bash
  mixed-content-scanner scan https://laravel.binalogue.dev
  ```

### Meta

- [ ] **Titles and descriptions**: Check page titles / descriptions. See `app/Services/AppService.php`.
- [ ] **Open Graph tags**: Are `og-tags` provided? See `resources/views/app.blade.php`.
- [ ] **Facebook sharing**: Test Facebook sharing: [Facebook Debugger](https://developers.facebook.com/tools/debug/).
- [ ] **Twitter sharing**: Test Twitter sharing: [Twitter Cards](https://cards-dev.twitter.com/validator).
- [ ] **Favicon and Home Screen Icons**: Generate new icons:
  ```bash
  yarn favicon:generate && yarn favicon:inject
  ```
  - [ ] Does Favicon and Home Screen Icons load?
  - [ ] Pin the tab in Safari to check pinned icon.

_Repeat the above checks for all languages._

### Components

#### Spot Video

- [ ] Check video with sound on.
- [ ] Are the progress bar and the skip button working properly?

#### Google Maps

- [ ] Is API key needed/configured?
- [ ] Check info windows.
- [ ] Prevent zoom out beyond 1x world.
- [ ] Try clicking on markers.

#### Forms

- [ ] Fill out forms with wrong/right values.

#### Emails

- [ ] Try subscribing to a newsletter with incorrect and correct email (use correct mail twice to get "already subscribed" message).
- [ ] Check layout of emails.

#### Other

- [ ] Check structured data for news, events, products,... [Structured Data Testing Tool](https://search.google.com/structured-data/testing-tool/)

## 4. Backend checklist

- [ ] **Error messages**: Error messages are handled and/or hidden.

<!--
### Admin

- [ ] Open up `/blender`.
- [ ] Remove unused modules from main menu.
- [ ] Configure Google Analytics dashboard.
- [ ] Create a new admin and try to log in.
- [ ] Try the password reset flow for existing user.
-->

### Database

- [ ] **Development/staging URLs**: Scan database for URLs to development/staging domain.

### Emails

- [ ] **E-mail recipients**: Verify all e-mail recipients are correct.

## 5. DNS, Server & Services

### DNS

- [ ] **Redirects**:
  - [ ] Add redirects from old to new pages if necessary.
  - [ ] Try out visiting `www` domain, should redirect to `non-www`.
  - [ ] Try out visiting `http`, should redirect to `https`.
- [ ] **DNS propagation**: Check DNS propagation with https://www.whatsmydns.net/

### HTTP

- [ ] **Robots**:
  - [ ] Verify that indexing is not prohibited with `x-robots-tag: none` by checking:
    ```bash
    curl -I https://laravel.binalogue.dev | grep 'x-robots-tag'
    ```
  - [ ] Allow robots in `app.yaml`.
- [ ] **HTTP status codes**: Verify that all http status codes are ok with [spatie/http-status-check](https://github.com/spatie/http-status-check):
  ```bash
  http-status-check scan https://laravel.binalogue.dev
  ```

#### SSL

- [ ] **SSL certificate health**: Check SSL certificate health: https://www.ssllabs.com/ssltest/

<!--
#### Backups

- [ ] Are Google Cloud backups enabled? https://cloud.google.com/sql/docs/mysql/backup-recovery/backing-up
- [ ] Is the output of artisan task `backup:run` ok? https://github.com/spatie/laravel-backup
-->

<!--
#### Monitoring

- [ ] Is the URL being monitored by [Oh Dear!](https://ohdearapp.com/)?
-->

### Security

- [ ] **Google Cloud Security Scanner**: https://cloud.google.com/security-scanner/docs/scanning-app-engine

### Services

#### Astral

- [ ] **Project packages**: Tag project packages with [Astral](https://app.astralapp.com).

#### Git

- [ ] **Remove stale branches**:
  ```bash
  git remote prune origin (--dry-run)
  ```

#### Google Analytics / Google Tag Manager

- [ ] **Verify Analytics / Tag Manager** have been correctly set up.

### Google App Engine

- [ ] **Scaling**: Update `min_instances` from `1` to `0` in `app.staging.yaml`

#### Google Search Console

- [ ] Add a new property for `laravel.binalogue.dev`: https://search.google.com
- [ ] Submit all www/non-www http/https variations.
- [ ] Set up non-www https as the preferred domain.
- [ ] _Crawl_ > _Fetch as Google_ > _Submit to index_ to kickstart index.
