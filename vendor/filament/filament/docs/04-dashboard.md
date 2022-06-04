---
title: Dashboard
---

Filament allows you to build dynamic custom dashboard widgets very easily.

## Getting started

To get started building a `BlogPostsOverview` widget:

```bash
php artisan make:filament-widget BlogPostsOverview
```

This command will create two files - a widget class in the `/Widgets` directory of the Filament directory, and a view in the `/widgets` directory of the Filament views directory.

Widgets are pure [Livewire](https://laravel-livewire.com) components, so may use any features of that package.

Widgets may also be used on [resource pages](resources#building-widgets) or other [custom pages](pages#building-widgets).

## Sorting widgets

Each widget class contains a `$sort` property that may be used to change its order on the page, relative to other widgets:

```php
protected static ?int $sort = 2;
```

## Conditionally hiding widgets

You may override the static `canView()` method on widgets to conditionally hide them:

```php
public static function canView(): bool
{
    return auth()->user()->isAdmin();
}
```

## Stats overview widgets

Filament comes with a "stats overview" widget template, which you can use to display a number of different stats in a single widget, without needing to write a custom view.

Start by creating a widget with the command:

```bash
php artisan make:filament-widget StatsOverview --stats-overview
```

Then return `Card` instances from the `getCards()` method:

```php
<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverviewWidget extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Unique views', '192.1k'),
            Card::make('Bounce rate', '21%'),
            Card::make('Average time on page', '3:12'),
        ];
    }
}
```

Now, check out your widget in the dashboard.

You may add a `description()` to provide additional information, along with a `descriptionIcon()`:

```php
protected function getCards(): array
{
    return [
        Card::make('Unique views', '192.1k')
            ->description('32k increase')
            ->descriptionIcon('heroicon-s-trending-up'),
        Card::make('Bounce rate', '21%')
            ->description('7% increase')
            ->descriptionIcon('heroicon-s-trending-down'),
        Card::make('Average time on page', '3:12')
            ->description('3% increase')
            ->descriptionIcon('heroicon-s-trending-up'),
    ];
}
```

You may also give cards a `color()` (`primary`, `success`, `warning` or `danger`):

```php
protected function getCards(): array
{
    return [
        Card::make('Unique views', '192.1k')
            ->description('32k increase')
            ->descriptionIcon('heroicon-s-trending-up')
            ->color('success'),
        Card::make('Bounce rate', '21%')
            ->description('7% increase')
            ->descriptionIcon('heroicon-s-trending-down')
            ->color('danger'),
        Card::make('Average time on page', '3:12')
            ->description('3% increase')
            ->descriptionIcon('heroicon-s-trending-up')
            ->color('success'),
    ];
}
```

You may also add or chain a `chart()` to each card to provide historical data. The `chart()` method accepts an array of data points to plot:

```php
protected function getCards(): array
{
    return [
        Card::make('Unique views', '192.1k')
            ->description('32k increase')
            ->descriptionIcon('heroicon-s-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),
        // ...
    ];
}
```

### Live updating (polling)

By default, stats overview widgets refresh their data every 5 seconds.

To customize this, you may override the `$pollingInterval` property on the class to a new interval:

```php
protected static ?string $pollingInterval = '10s';
```

Alternatively, you may disable polling altogether:

```php
protected static ?string $pollingInterval = null;
```

## Table widgets

Filament comes with a "table" widget template, which you can use to display a table of data without needing to write a custom view.

Start by creating a widget with the command:

```bash
php artisan make:filament-widget LatestOrders --table
```

Then update the `getTableQuery()` and `getTableColumns()` methods to return the data query and columns you want to display:

```php
<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestOrders extends BaseWidget
{
    protected function getTableQuery(): Builder
    {
        return Order::query()->latest()->limit(10);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id'),
            Tables\Columns\TextColumn::make('customer.name')
                ->label('Customer'),
        ];
    }
}
```

Now, check out your widget in the dashboard.

## Chart widgets

Filament comes with many "chart" widget template, which you can use to display real-time, interactive charts.

Start by creating a widget with the command:

```bash
php artisan make:filament-widget BlogPostsChart --chart
```

There are several chart classes available, but we'll use the `LineChartWidget` class for this example.

The `getHeading()` method is used to return a heading that describes the chart.

The `getData()` method is used to return an array of datasets and labels. Each dataset is a labelled array of points to plot on the chart, and each label is a string. This structure is identical with the [Chart.js](https://www.chartjs.org/docs) library, which Filament uses to render charts. You may use the [Chart.js documentation](https://www.chartjs.org/docs) to fully understand the possibilities to return from `getData()`, based on the chart type.

```php
<?php

namespace App\Filament\Widgets;

use Filament\Widgets\LineChartWidget;

class BlogPostsChart extends LineChartWidget
{
    protected function getHeading(): string
    {
        return 'Blog posts';
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }
}
```

Now, check out your widget in the dashboard.

### Available chart types

Below is a list of available chart widget classes which you may extend, and their corresponding [Chart.js](https://www.chartjs.org/docs) documentation page, for inspiration what to return from `getData()`:

- `Filament\Widgets\BarChartWidget` - [Chart.js documentation](https://www.chartjs.org/docs/latest/charts/bar)
- `Filament\Widgets\BubbleChartWidget` - [Chart.js documentation](https://www.chartjs.org/docs/latest/charts/bubble)
- `Filament\Widgets\DoughnutChartWidget` - [Chart.js documentation](https://www.chartjs.org/docs/latest/charts/doughnut)
- `Filament\Widgets\LineChartWidget` - [Chart.js documentation](https://www.chartjs.org/docs/latest/charts/line)
- `Filament\Widgets\PieChartWidget` - [Chart.js documentation](https://www.chartjs.org/docs/latest/charts/doughnut)
- `Filament\Widgets\PolarAreaChartWidget` - [Chart.js documentation](https://www.chartjs.org/docs/latest/charts/polar)
- `Filament\Widgets\RadarChartWidget` - [Chart.js documentation](https://www.chartjs.org/docs/latest/charts/radar)
- `Filament\Widgets\ScatterChartWidget` - [Chart.js documentation](https://www.chartjs.org/docs/latest/charts/scatter)

### Generating chart data from an Eloquent model

To generate chart data from an Eloquent model, Filament recommends that you install the `flowframe/laravel-trend` package. You can view the documentation on the [Flowframe website](https://docs.flowfra.me/docs/laravel-trend/installation-and-setup).

Here is an example of generating chart data from a model using the `laravel-trend` package:

```php
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

protected function getData(): array
{
    $data = Trend::model(BlogPost::class)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->count();

    return [
        'datasets' => [
            [
                'label' => 'Blog posts',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
            ],
        ],
        'labels' => $data->map(fn (TrendValue $value) => $value->date),
    ];
}
```

### Filtering chart data

You can set up chart filters to change the data shown on chart. Commonly, this is used to change the time period that chart data is rendered for.

To set a default filter value, set the `$filter` property:

```php
public ?string $filter = 'today';
```

Then, define the `getFilters()` method to return an array of values and labels for your filter:

```php
protected function getFilters(): ?array
{
    return [
        'today' => 'Today',
        'week' => 'Last week',
        'month' => 'Last month',
        'year' => 'This year',
    ];
}
```

You can use the active filter value within your `getData()` method:

```php
protected function getData(): array
{
    $activeFilter = $this->filter;
    
    // ...
}
```

### Live updating (polling)

By default, chart widgets refresh their data every 5 seconds.

To customize this, you may override the `$pollingInterval` property on the class to a new interval:

```php
protected static ?string $pollingInterval = '10s';
```

Alternatively, you may disable polling altogether:

```php
protected static ?string $pollingInterval = null;
```

## Disabling the default widgets

By default, two widgets are displayed on the dashboard. These widgets can be disabled by updating the `widgets.register` property of the [configuration](installation#publishing-the-configuration) file:

```php
'widgets' => [
    // ...
    'register' => [],
],
```

## Customizing widget width

You may customize the width of a widget using the `$columnSpan` property. You may use a number between 1 and 12 to indicate how many columns the widget should span, or `full` for all of them:

```php
protected int | string | array $columnSpan = 'full';
```
