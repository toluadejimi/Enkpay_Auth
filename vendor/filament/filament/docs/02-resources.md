---
title: Resources
---

Resources are static classes that describe how administrators should be able to interact with data from your app. They are associated with Eloquent models from your app.

## Getting started

To create a resource for the `App\Models\Customer` model:

```bash
php artisan make:filament-resource Customer
```

This will create several files in the `app/Filament/Resources` directory:

```
.
+-- CustomerResource.php
+-- CustomerResource
|   +-- Pages
|   |   +-- CreateCustomer.php
|   |   +-- EditCustomer.php
|   |   +-- ListCustomers.php
```

Your new resource class lives in `CustomerResource.php`. Resource classes register [forms](#forms), [tables](#tables), [relations](#relations), and [pages](#pages) associated with that model.

The classes in the `Pages` directory are used to customize the pages in the admin panel that interact with your resource. They're all full-page [Livewire](https://laravel-livewire.com) components that you can customize in any way you wish.

### Setting a title attribute

A `$recordTitleAttribute` may be set for your resource, which is the name of a column on your model that can be used to identify it from others.

This is required for features like [global search](#global-search) to work.

For example, this could be a blog post's `title` or a customer's `name`.

```php
protected static ?string $recordTitleAttribute = 'name';
```

> You may specify the name of an [Eloquent accessor](https://laravel.com/docs/eloquent-mutators#defining-an-accessor) if just one column is unable to describe a record effectively.

## Forms

Resource classes contain a static `form()` method that is used to build the forms on the create and edit pages:

```php
use Filament\Forms;
use Filament\Resources\Form;

public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('email')->email()->required(),
            // ...
        ]);
}
```

### Available field types

The `schema()` method is used to define the structure of your form. It is an array of [fields](/docs/forms/fields), in the order they should appear in your form.

We have many fields available for your forms, including:

- [Text input](/docs/forms/fields#text-input)
- [Select](/docs/forms/fields#select)
- [Multi-select](/docs/forms/fields#multi-select)
- [Checkbox](/docs/forms/fields#checkbox)
- [Date-time picker](/docs/forms/fields#date-time-picker)
- [File upload](/docs/forms/fields#file-upload)
- [Rich editor](/docs/forms/fields#rich-editor)
- [Markdown editor](/docs/forms/fields#markdown-editor)
- [Repeater](/docs/forms/fields#repeater)

To view a full list of available form [fields](/docs/forms/fields) and [layout components](/docs/forms/layout), see the [Form Builder documentation](/docs/forms/fields).

You may also build your own completely [custom form fields](/docs/forms/fields#building-custom-fields) and [custom layout components](/docs/forms/layout#building-custom-layout-components).

### Automatically generating fields

If you'd like to save time, Filament can automatically generate some fields and [tables](#tables) for you, based on your model's database columns:

```bash
composer require doctrine/dbal
php artisan make:filament-resource Customer --generate
```

### Hiding components based on the page

The `hidden()` method of form components allows you to dynamically hide fields based on the current page.

To do this, you must pass a closure to the `hidden()` method which checks if the Livewire component is a certain page or not. In this example, we hide the `password` field on the `EditUser` resource page:

```php
use Livewire\Component;

Forms\Components\TextInput::make('password')
    ->password()
    ->required()
    ->hidden(fn (Component $livewire): bool => $livewire instanceof Pages\EditUser),
```

Alternatively, we have a `hiddenOn()` shortcut method for this case:

```php
use Livewire\Component;

Forms\Components\TextInput::make('password')
    ->password()
    ->required()
    ->hiddenOn(Pages\EditUser::class),
```

You may instead use the `visible` to check if a component should be visible or not:

```php
use Livewire\Component;

Forms\Components\TextInput::make('password')
    ->password()
    ->required()
    ->visible(fn (Component $livewire): bool => $livewire instanceof Pages\CreateUser),
```

Alternatively, we have a `visibleOn()` shortcut method for this case:

```php
use Livewire\Component;

Forms\Components\TextInput::make('password')
    ->password()
    ->required()
    ->visibleOn(Pages\CreateUser::class),
```

For more information about closure customization, see the [form builder documentation](/docs/forms/advanced#using-closure-customisation).

## Tables

Resource classes contain a static `table()` method that is used to build the table on the list page:

```php
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('email'),
            // ...
        ])
        ->filters([
            Tables\Filters\Filter::make('verified')
                ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')),
            // ...
        ]);
}
```

### Available column types

The `columns()` method is used to define the [columns](/docs/tables/columns) in your table. It is an array of column objects, in the order they should appear in your table.

We have many fields available for your forms, including:

- [Text column](/docs/tables/columns#text-column)
- [Boolean column](/docs/tables/columns#boolean-column)
- [Image column](/docs/tables/columns#image-column)
- [Icon column](/docs/tables/columns#icon-column)
- [Badge column](/docs/tables/columns#badge-column)

To view a full list of available table [columns](/docs/tables/columns), see the [Table Builder documentation](/docs/tables/columns).

You may also build your own completely [custom table columns](/docs/tables/columns#building-custom-columns).

### Filtering table data

[Filters](/docs/tables/filters) are predefined scopes that administrators can use to filter records in your table. The `filters()` method is used to register these.

### Automatically generating columns

If you'd like to save time, Filament can automatically generate some columns and [form fields](#forms) for you, based on your model's database columns:

```bash
composer require doctrine/dbal
php artisan make:filament-resource Customer --generate
```

### Sorting a column by default

If a column is `sortable()`, you may choose to sort it by default using the `defaultSort()` method:

```php
use Filament\Resources\Table;
use Filament\Tables;

public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('name')->sortable(),
            // ...
        ])
        ->defaultSort('name');
}
```

### Adding more actions

You may add more [actions](/docs/tables/actions#single-actions) to each table row.

To add actions before the default actions, use the `prependActions()` method:

```php
use Filament\Resources\Table;
use Filament\Tables;

public static function table(Table $table): Table
{
    return $table
        ->columns([
            // ...
        ])
        ->prependActions([
            Tables\Actions\Action::make('delete')
                ->action(fn (Post $record) => $record->delete())
                ->requiresConfirmation()
                ->color('danger'),
        ]);
}
```

To add actions after the default actions, use the `pushActions()` method:

```php
use Filament\Resources\Table;
use Filament\Tables;

public static function table(Table $table): Table
{
    return $table
        ->columns([
            // ...
        ])
        ->pushActions([
            Tables\Actions\Action::make('delete')
                ->action(fn (Post $record) => $record->delete())
                ->requiresConfirmation()
                ->color('danger'),
        ]);
}
```

To replace the default actions, use the `actions()` method:

```php
use Filament\Resources\Table;
use Filament\Tables;

public static function table(Table $table): Table
{
    return $table
        ->columns([
            // ...
        ])
        ->actions([
            Tables\Actions\Action::make('delete')
                ->action(fn (Post $record) => $record->delete())
                ->requiresConfirmation()
                ->color('danger'),
        ]);
}
```

### Adding more bulk actions

You may add more [bulk actions](/docs/tables/actions#bulk-actions) to the table.

To add bulk actions before the default actions, use the `prependBulkActions()` method:

```php
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Collection;

public static function table(Table $table): Table
{
    return $table
        ->columns([
            // ...
        ])
        ->prependBulkActions([
            Tables\Actions\BulkAction::make('activate')
                ->action(fn (Collection $records) => $records->each->activate())
                ->requiresConfirmation()
                ->color('success')
                ->icon('heroicon-o-check'),
        ]);
}
```

To add bulk actions after the default actions, use the `pushBulkActions()` method:

```php
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Collection;

public static function table(Table $table): Table
{
    return $table
        ->columns([
            // ...
        ])
        ->pushBulkActions([
            Tables\Actions\BulkAction::make('activate')
                ->action(fn (Collection $records) => $records->each->activate())
                ->requiresConfirmation()
                ->color('success')
                ->icon('heroicon-o-check'),
        ]);
}
```

To replace the default actions, use the `bulkActions()` method:

```php
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Collection;

public static function table(Table $table): Table
{
    return $table
        ->columns([
            // ...
        ])
        ->bulkActions([
            Tables\Actions\BulkAction::make('activate')
                ->action(fn (Collection $records) => $records->each->activate())
                ->requiresConfirmation()
                ->color('success')
                ->icon('heroicon-o-check'),
        ]);
}
```

## Relations

"Relation managers" in Filament allow administrators to list, create, attach, edit, detach and delete related many records without leaving the resource's edit page. Resource classes contain a static `getRelations()` method that is used to register relation managers for your resource.

### `HasMany`, `HasManyThrough` and `MorphMany`

To create a relation manager for a `HasMany`, `HasManyThrough` or `MorphMany` relationship, you can use:

```bash
php artisan make:filament-has-many CategoryResource posts title
php artisan make:filament-has-many-through ProjectResource deployments title
php artisan make:filament-morph-many PostResource replies title
```

- `CategoryResource` is the name of the resource class for the parent model.
- `posts` is the name of the relationship you want to manage.
- `title` is the name of the attribute that will be used to identify posts.

This will create a `CategoryResource/RelationManagers/PostsRelationManager.php` file. This contains a class where you are able to define a [form](/docs/forms/fields) and [table](/docs/tables/columns) for your relation manager:

```php
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Tables;

public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('title')->required(),
            Forms\Components\MarkdownEditor::make('content'),
            // ...
        ]);
}

public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('title'),
            // ...
        ]);
}
```

You must register the new relation manager in your resource's `getRelations()` method:

```php
public static function getRelations(): array
{
    return [
        RelationManagers\PostsRelationManager::class,
    ];
}
```

Once a table and form have been defined for the relation manager, visit the edit page of your resource to see it in action.

### Associating and dissociating records

Filament is able to associate and dissociate records for the inverse `BelongsTo` relationship. To enable this functionality, you may add the following properties to the relation manager:

```php
protected static bool $hasAssociateAction = true;
protected static bool $hasDissociateAction = true;
protected static bool $hasDissociateBulkAction = true;
```

Each property represents a different action that you are able to enable for the relation manager:

- `$hasAssociateAction` enables an "Associate" button in the header of the table.
- `$hasDissociateAction` enables a "Dissociate" button on each row of the table.
- `$hasDissociateBulkAction` enables a "Dissociate" bulk action, which is available when you select one or more records.

Since associating and dissociating requires access to the inverse relationship, Filament needs to guess its name. For relationships with unconventional naming conventions, you may wish to override the `$inverseRelationship` property on the relation manager:

```php
protected static ?string $inverseRelationship = 'author'; // Since the inverse related model is `User`, this is normally `user`, not `author`.
```

### `BelongsToMany` and `MorphToMany`

To create a relation manager for a `BelongsToMany` or `MorphMany` relationship, you can use:

```bash
php artisan make:filament-belongs-to-many UserResource teams name
php artisan make:filament-morph-to-many TagResource posts title
```

- `UserResource` is the name of the resource class for the parent model.
- `teams` is the name of the relationship you want to manage.
- `name` is the name of the attribute that will be used to identify teams.

This will create a `UserResource/RelationManagers/TeamsRelationManager.php` file. This contains a class where you are able to define a [form](/docs/forms/fields) and [table](/docs/tables/columns) for your relation manager:

```php
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Tables;

public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('name')->required(),
            // ...
        ]);
}

public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('name'),
            // ...
        ]);
}
```

You must register the new relation manager in your resource's `getRelations()` method:

```php
public static function getRelations(): array
{
    return [
        RelationManagers\TeamsRelationManager::class,
    ];
}
```

Once a table and form have been defined for the relation manager, visit the edit page of your resource to see it in action.

For relationships with unconventional naming conventions, you may wish to override the `$inverseRelationship` property on the relation manager:

```php
protected static ?string $inverseRelationship = 'members'; // Since the inverse related model is `User`, this is normally `users`, not `members`.
```

#### Pivot attributes

Relation managers may also be used to edit pivot table attributes. For example, if you have a `TeamsRelationManager` for your `UserResource`, and you want to add the `role` pivot attribute to the relation manager table and form, you can use:

```php
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Tables;

public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('role')->required(),
            // ...
        ]);
}

public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('role'),
            // ...
        ]);
}
```

When you attach record with the `Attach` button, you may wish to define a custom form to add pivot attributes to the relationship:

```php
use Filament\Forms;
use Filament\Resources\Form;

public static function attachForm(Form $form): Form
{
    return $form
        ->schema([
            static::getAttachFormRecordSelect(),
            Forms\Components\TextInput::make('role')->required(),
            // ...
        ]);
}
```

As included in the above example, you may use `getAttachFormRecordSelect()` to create a select field for the record to attach.

### `HasOne`, `BelongsTo` and `MorphOne`

If you'd like to save data in a form to a singular relationship, you may use the [`relationship()` method for layout components](/docs/forms/layout#saving-data-to-relationships):

```php
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

Fieldset::make('Metadata')
    ->relationship('metadata')
    ->schema([
        TextInput::make('title'),
        Textarea::make('description'),
        FileUpload::make('image'),
    ])
```

## Global search

"Global search" is a feature that allows you to search across all of your resources.

To enable global search on your model, you must [set a title attribute](#setting-a-title-attribute) for your resource:

```php
protected static ?string $recordTitleAttribute = 'title';
```

If you would like to search across multiple columns of your resource, you may override the `getGloballySearchableAttributes()` method. "Dot-syntax" allows you to search inside of relationships:

```php
public static function getGloballySearchableAttributes(): array
{
    return ['title', 'slug', 'author.name', 'category.name'];
}
```

Search results can display "details" below their title, which gives the user more information about the record. To enable this feature, you must override the `getGlobalSearchResultDetails()` method:

```php
public static function getGlobalSearchResultDetails(Model $record): array
{
    return [
        'Author' => $record->author->name,
        'Category' => $record->category->name,
    ];
}
```

In this example, the category and author of the record will be displayed below its title in the search result. However, the `category` and `author` relationships will be lazy-loaded, which will result in poor results performance. To [eager-load](https://laravel.com/docs/eloquent-relationships#eager-loading) these relationships, we must override the `getGlobalSearchEloquentQuery()` method:

```php
protected static function getGlobalSearchEloquentQuery(): Builder
{
    return parent::getGlobalSearchEloquentQuery()->with(['author', 'category']);
}
```

You may customise the record "title" displayed in global search results by overriding `getGlobalSearchResultTitle()` method:

```php
public static function getGlobalSearchResultTitle(Model $record): string
{
    return $record->name;
}
```

Global search results will link to the edit page of your resource, or the [view page](#view-page) if the user does not have [edit permissions](#authorization). To customize this, you may override the `getGlobalSearchResultUrl()` method and return a route of your choice:

```php
public static function getGlobalSearchResultUrl(Model $record): string
{
    return route('users.edit', ['user' => $record]);
}
```

## Simple (modal) resources

Sometimes, your resources are simple enough that you only want to manage records on one page, using modals to create, edit and delete records. Your resource has a "Manage" page, which is a List page with modals added. To generate a simple resource with modals:

```bash
php artisan make:filament-resource Customer --simple
```

Additionally, your resource will have no `getRelations()` method, as relation managers are only displayed on the Edit and View pages, which are not present in simple resources. Everything else is the same.

### Migrating to a simple resource

If you want to migrate from a normal resource to a simple resource, first create a ManageRecords page:

```bash
php artisan make:filament-page ManageCustomers --resource=CustomerResource --type=ManageRecords
```

You must register this new page in your resource's `getPages()` method, and remove the others:

```php
public static function getPages(): array
{
    return [
        'index' => Pages\ManageCustomers::route('/'),
    ];
}
```

Also, remove the `getRelations()` method from the resource.

Finally, you may remove the other page classes from the resource's `Pages` directory.

## Pages

Pages are classes that are associated with a resource. They are full-page [Livewire](https://laravel-livewire.com) components with a few extra utilities you can use with the admin panel.

Page class files are in the `/Pages` directory of your resource directory.

By default, resources are generated with three pages:

- List has a [table](#tables) for displaying, searching and deleting resource records. From here, you are able to access the create and edit pages. It is routed to `/`.
- Create has a [form](#forms) that is able to create a resource record. It is routed to `/create`.
- Edit has a [form](#forms) that is able to update a resource record, along with the [relation managers](#relations) registered to your resource. It is routed to `/{record}/edit`.

### View page

Filament also comes with a "view" page for resources. By default, this contains a form with all inputs disabled, allowing the user to access information without being able to edit it.

To create a new resource with a view page, you can use the `--view-page` flag:

```bash
php artisan make:filament-resource User --view-page
```

#### Adding a view page to an existing resource

If you want to add a view page to an existing resource, create a new page in your resource's `Pages` directory:

```bash
php artisan make:filament-page ViewUser --resource=UserResource --type=ViewRecord
```

You must register this new page in your resource's `getPages()` method:

```php
public static function getPages(): array
{
    return [
        'index' => Pages\ListUsers::route('/'),
        'create' => Pages\CreateUser::route('/create'),
        'view' => Pages\ViewUser::route('/{record}'),
        'edit' => Pages\EditUser::route('/{record}/edit'),
    ];
}
```

### Customizing data before saving

On create pages, you may define a `mutateFormDataBeforeCreate()` method to modify the form data before it is saved to the database:

```php
protected function mutateFormDataBeforeCreate(array $data): array
{
    $data['user_id'] = auth()->id();

    return $data;
}
```

On edit pages, you may do the same using the `mutateFormDataBeforeSave()` method:

```php
protected function mutateFormDataBeforeSave(array $data): array
{
    $data['last_edited_by_id'] = auth()->id();

    return $data;
}
```

### Customizing data before filling the form

On edit pages, you may define a `mutateFormDataBeforeFill()` method to modify the record data before it is filled into the form:

```php
protected function mutateFormDataBeforeFill(array $data): array
{
    $data['user_id'] = auth()->id();

    return $data;
}
```

### Customizing form redirects

You may specify a custom redirect URL for the Create and Edit pages by overriding the `getRedirectUrl()` method.

For example, the Create form can redirect back to the List page when it is submitted:

```php
protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('index');
}
```

### Lifecycle hooks

Hooks may be used to execute methods at various points within a page's lifecycle, like before a form is saved. To set up a hook, create a protected method on the page class with the name of the hook:

```php
protected function beforeSave(): void
{
    // ...
}
```

In this example, the code in the `beforeSave()` method will be called before the data in the form is saved to the database.

There are several available hooks for the create and edit pages:

```php
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    // ...

    protected function beforeFill(): void
    {
        // Runs before the form fields are populated with their default values.
    }

    protected function afterFill(): void
    {
        // Runs after the form fields are populated with their default values.
    }

    protected function beforeValidate(): void
    {
        // Runs before the form fields are validated when the form is submitted.
    }

    protected function afterValidate(): void
    {
        // Runs after the form fields are validated when the form is submitted.
    }

    protected function beforeCreate(): void
    {
        // Runs before the form fields are saved to the database.
    }

    protected function afterCreate(): void
    {
        // Runs after the form fields are saved to the database.
    }
}
```

```php
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    // ...

    protected function beforeFill(): void
    {
        // Runs before the form fields are populated from the database.
    }

    protected function afterFill(): void
    {
        // Runs after the form fields are populated from the database.
    }

    protected function beforeValidate(): void
    {
        // Runs before the form fields are validated when the form is saved.
    }

    protected function afterValidate(): void
    {
        // Runs after the form fields are validated when the form is saved.
    }

    protected function beforeSave(): void
    {
        // Runs before the form fields are saved to the database.
    }

    protected function afterSave(): void
    {
        // Runs after the form fields are saved to the database.
    }

    protected function beforeDelete(): void
    {
        // Runs before the record is deleted.
    }

    protected function afterDelete(): void
    {
        // Runs after the record is deleted.
    }
}
```

### Custom actions

"Actions" are buttons that are displayed on pages, which allow the user to run a Livewire method on the page or visit a URL.

On resource pages, actions are usually in 2 places: in the top right of the page, and below the form.

For example, you may add a new button action next to "Delete" on the edit page that runs the `impersonate()` Livewire method:

```php
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    // ...

    protected function getActions(): array
    {
        return array_merge(parent::getActions(), [
            Action::make('impersonate')->action('impersonate'),
        ]);
    }

    public function impersonate(): void
    {
        // ...
    }
}
```

Or, a new button next to "Save" below the form:

```php
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    // ...

    protected function getFormActions(): array
    {
        return array_merge(parent::getFormActions(), [
            Action::make('close')->action('saveAndClose'),
        ]);
    }

    public function saveAndClose(): void
    {
        // ...
    }
}
```

To view the entire actions API, please visit the [pages section](pages#actions).

### Custom views

For further customization opportunities, you can override the static `$view` property on any page to a custom view in your app:

```php
protected static string $view = 'filament.resources.users.pages.list-users';
```

### Custom Pages

Filament allows you to create completely custom pages for resources. To create a new page, you can use:

```bash
php artisan make:filament-page SortUsers --resource=UserResource --type=custom
```

This command will create two files - a page class in the `/Pages` directory of your resource directory, and a view in the `/pages` directory of the resource views directory.

You must register custom pages to a route in the static `getPages()` method of your resource:

```php
public static function getPages(): array
{
    return [
        // ...
        'sort' => Pages\SortUsers::route('/sort'),
    ];
}
```

Any [parameters](https://laravel.com/docs/routing#route-parameters) defined in the route's path will be available to the page class, in an identical way to [Livewire](https://laravel-livewire.com/docs/rendering-components#route-params).

To generate a URL for a resource route, you may call the static `getUrl()` method on the page class:

```php
SortUsers::getUrl($parameters = [], $absolute = true);
```

### Building widgets

Filament allows you to display widgets inside pages, below the header and above the footer.

You can use an existing [dashboard widget](dashboard), or create one specifically for the resource.

To get started building a resource widget:

```bash
php artisan make:filament-widget CustomerOverview --resource=CustomerResource
```

This command will create two files - a widget class in the `app/Filament/Resources/CustomerResource/Widgets` directory, and a view in the `resources/views/filament/resources/customer-resource/widgets` directory.

You must register the new widget in your resource's `getWidgets()` method:

```php
public static function getWidgets(): array
{
    return [
        Widgets\CustomerOverview::class,
    ];
}
```

To display a widget on a resource page, use the `getHeaderWidgets()` or `getFooterWidgets()` methods for that page:

```php
<?php
 
namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;

class ListCustomers extends ListRecords
{
    public static string $resource = CustomerResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            CustomerResource\Widgets\CustomerOverview::class,
        ];
    }
}
```

If you're using a widget on an Edit or View page, you may access the current record by defining a `$record` property on the widget class:

```php
use Illuminate\Database\Eloquent\Model;

public ?Model $record = null;
```

### Deleting pages

If you'd like to delete a page from your resource, you can just delete the page file from the `Pages` directory of your resource, and its entry in the `getPages()` method.

For example, you may have a resource with records that may not be created by anyone. Delete the `Create` page, and then remove it from `getPages()`:

```php
public static function getPages(): array
{
    return [
        'index' => Pages\ListCustomers::route('/'),
        'edit' => Pages\EditCustomer::route('/{record}/edit'),
    ];
}
```

## Authorization

For authorization, Filament will observe any [model policies](https://laravel.com/docs/authorization#creating-policies) that are registered in your app. The following methods are used:

- `create` is used to control creation of new records. It removes the "New" button from the "Index" page.
- `view` is used to control viewing of a record. If you have a [view page](#view-page), it prevents the "View" link from being displayed on the table, and prevents the user from visiting the View page.
- `viewAny` is used to completely disable resources and remove them from the navigation menu.
- `update` is used to control editing of a record. It prevents the "Edit" link from being displayed on the resource table, and prevents the user from visiting the Edit page.
- `delete` is used to prevent a record from being deleted. It removes the "Delete" button from the "Edit" page.
- `deleteAny` is used to prevent records from being bulk deleted. It removes the "Delete selected" bulk action from the resource table.

## Disabling global scopes

By default, Filament will observe all global scopes that are registered to your model. However, this may not be ideal if you wish to access, for example, soft deleted records.

To overcome this, you may override the base Eloquent query that Filament uses to fetch records in your resource class:

```php
public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()->withoutGlobalScopes();
}
```

Alternatively, you may remove specific global scopes:

```php
public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()->withoutGlobalScopes([ActiveScope::class]);
}
```

More information may be found in the [Laravel documentation](https://laravel.com/docs/eloquent#removing-global-scopes).

## Customization

### Customizing the label

A label for this resource is generated based on the name of the resource's model. You may customize it using the static `$label` property:

```php
protected static ?string $label = 'customer';
```

The plural version is generated based on the singular `$label`, which you may also override:

```php
protected static ?string $pluralLabel = 'customers';
```
