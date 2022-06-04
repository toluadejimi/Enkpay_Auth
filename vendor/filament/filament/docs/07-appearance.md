---
title: Appearance
---

## Changing the brand logo

By default, Filament will use your app's name as a brand logo in the admin panel.

You may create a `resources/views/vendor/filament/components/brand.blade.php` file to provide a custom logo:

```blade
<img src="{{ asset('/images/logo.svg') }}" alt="Logo" class="h-10">
```

If you enabled the [collapsible sidebar](#collapsible-sidebar), you may also provide a brand icon (`resources/views/vendor/filament/components/brand-icon.blade.php`) which is shown when the sidebar is collapsed:

```blade
<img src="{{ asset('/images/icon.svg') }}" alt="Icon" class="h-full w-full object-contain" />
```

## Dark mode

By default, Filament only includes a light theme. However, you may allow the user to switch to dark mode if they wish, using the `dark_mode` setting of the [configuration file](installation#publishing-the-configuration):

```php
'dark_mode' => true,
```

When dark mode is enabled, the admin panel will automatically obey your system's dark / light mode preference. You may switch to dark / light mode permanently through the button in the user dropdown menu.

If you're using a [custom theme](#building-themes), make sure that you have the `darkMode: 'class'` setting in your `tailwind.config.js` file.

> Please note: before enabling dark mode in production, please thoroughly test your admin panel - especially third party plugins, which may not be properly tested with dark mode.

When the user toggles between dark or light mode, a browser event called **dark-mode-toggled** is dispatched. You can listen to it:

```html
<div
    x-data="{ mode: 'light' }"
    x-on:dark-mode-toggled.window="mode = $event.detail"
>
    <span x-show="mode === 'light'">
        Light mode
    </span>

    <span x-show="mode === 'dark'">
        Dark mode
    </span>
</div>
```

## Collapsible sidebar

By default, the sidebar is only collapsible on mobile. You may make it collapsible on desktop as well.

You must [publish the configuration](installation#publishing-the-configuration) in order to access this feature.

In `config/filament.php`, set the `layouts.sidebar.is_collapsible_on_desktop` to `true`:

```php
'layout' => [
    'sidebar' => [
        'is_collapsible_on_desktop' => true,
    ],
],
```

## Building themes

Filament allows you to change the fonts and color scheme used in the UI, by compiling a custom stylesheet to replace the default one. This custom stylesheet is called a "theme".

Themes use [Tailwind CSS](https://tailwindcss.com), the Tailwind Forms plugin, and the Tailwind Typography plugin, and [Tippy.js](https://atomiks.github.io/tippyjs/). You may install these through NPM:

```bash
npm install tailwindcss @tailwindcss/forms @tailwindcss/typography tippy.js --save-dev
```

To finish installing Tailwind, you must create a new `tailwind.config.js` file in the root of your project. The easiest way to do this is by running `npx tailwindcss init`.

In `tailwind.config.js`, register the plugins you installed, and add custom colors used by the form builder:

```js
const colors = require('tailwindcss/colors')

module.exports = {
    content: [
        './resources/**/*.blade.php',
        './vendor/filament/**/*.blade.php', // [tl! focus]
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: { // [tl! focus:start]
                danger: colors.rose,
                primary: colors.blue,
                success: colors.green,
                warning: colors.yellow,
            }, // [tl! focus:end]
        },
    },
    plugins: [
        require('@tailwindcss/forms'), // [tl! focus:start]
        require('@tailwindcss/typography'), // [tl! focus:end]
    ],
}
```

You may specify your own colors, which will be used throughout the admin panel.

In your `webpack.mix.js` file, Register Tailwind CSS as a PostCSS plugin :

```js
const mix = require('laravel-mix')

mix.postCss('resources/css/filament.css', 'public/css', [
    require('tailwindcss'), // [tl! focus]
])
```

In `/resources/css/filament.css`, import Filament's vendor CSS:

```css
@import '../../vendor/filament/filament/resources/css/app.css';
```

Now, you may register the theme file in a service provider's `boot()` method:

```php
use Filament\Facades\Filament;

Filament::serving(function () {
    Filament::registerTheme(mix('css/filament.css'));
});
```

## Changing the maximum content width

Filament exposes a configuration option that allows you to change the maximum content width of all pages.

You must [publish the configuration](installation#publishing-the-configuration) in order to access this feature.

In `config/filament.php`, set the `layouts.max_content_width` to any value between `xl` and `7xl`, or `full` for no max width:

```php
'layout' => [
    'max_content_width' => 'full',
],
```

The default is `7xl`.

## Including frontend assets

You may register your own scripts and styles using the `registerScripts()` and `registerStyles()` methods in a service provider's `boot()` method:

```php
use Filament\Facades\Filament;

Filament::registerScripts([
    asset('js/my-script.js'),
]);

Filament::registerStyles([
    'https://unpkg.com/tippy.js@6/dist/tippy.css',
    asset('css/my-styles.css'),
]);
```

You may pass `true` as a parameter to `registerScripts()` to load it before Filament's core JavaScript. This is useful for registering Alpine.js plugins from a CDN:

```php
Filament::registerScripts([
    'https://cdn.jsdelivr.net/npm/@ryangjchandler/alpine-tooltip@0.x.x/dist/cdn.min.js',
], true);
```

## Custom meta tags

You can add custom tags to the header, such as `<meta>` and `<link>`, using the following:

```php
use Filament\Facades\Filament;
use Illuminate\Support\HtmlString;

Filament::pushMeta([
    new HtmlString('<link rel="manifest" href="/site.webmanifest" />'),
]);
```

## Notification position

Filament allows you to customize the position of notifications.

In `config/filament.php`, set the `layouts.notifications.alignment` to any value of `left`, `center` or `right` and `layouts.notifications.vertical_alignment` to any value of `top`, `center` or `bottom`:

```php
'layout' => [
    'notifications' => [
        'vertical_alignment' => 'top'
        'alignment' => 'center',
    ],
],
```

## Render hooks

Filament allows you to render Blade content at various points in the admin panel layout. This is useful for integrations with packages like [`wire-elements/modal`](https://github.com/wire-elements/modal) which require you to add a Livewire component to your app.

Here's an example, integrating [`wire-elements/modal`](https://github.com/wire-elements/modal) with Filament in a service provider:

```php
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Blade;

Filament::registerRenderHook(
    'body.start',
    fn (): string => Blade::render('@livewire(\'livewire-ui-modal\')'),
);
```

You could also render view content from a file:

```php
use Filament\Facades\Filament;
use Illuminate\Contracts\View\View;

Filament::registerRenderHook(
    'body.start',
    fn (): View => view('impersonation-banner'),
);
```

The available hooks are as follows:

- `body.start` - after `<body>`
- `body.end` - before `</body>`
- `global-search.start` - before [global search](resources#global-search) input
- `global-search.end` - after [global search](resources#global-search) input
- `head.start` - after `<head>`
- `head.end` - before `</head>`
- `sidebar.start` - before [sidebar](navigation) content
- `sidebar.end` - after [sidebar](navigation) content
