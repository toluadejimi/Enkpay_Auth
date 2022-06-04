<?php

namespace App\Filament\Resources;

use App\Models\Pos;
use Filament\Resources\Form;
use App\Enums\DeviceTypeEnum;
use Filament\Resources\Table;
use App\Enums\DeviceStatusEnum;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use App\Filament\Resources\PosResource\Pages;
use Filament\Forms\Components\BelongsToSelect;

class PosResource extends Resource
{
    protected static ?string $label = 'POS';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Device';

    protected static ?string $model = Pos::class;

    protected static ?string $navigationLabel = 'POS Manager';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(static::getFormSchema());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(static::getTableColumns())
            ->filters([
                Filter::make('published_at')
                    ->form([
                        DatePicker::make('created_from')
                            ->placeholder(fn ($state): string => 'Dec 18, ' . now()->subYear()->format('Y')),
                        DatePicker::make('created_until')
                            ->placeholder(fn ($state): string => now()->format('M d, Y')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getFormSchema(): array
    {
        return [
            Grid::make(4)
                ->schema([
                    BelongsToSelect::make('user_id')
                        ->label(__('ASSIGN TO A USER:'))
                        ->searchable()
                        ->placeholder(__('Select user to assign to:'))
                        ->relationship('user', 'email')
                        ->required()
                        ->columnSpan(2),
                    Placeholder::make('updated_at')
                        ->label('Last modified at')
                        ->content(fn (?Pos $record): string => $record ? $record->updated_at->diffForHumans() : '-')
                        ->columnSpan(2),
                    TextInput::make('device_id')
                        ->label(__('DEVICE ID'))
                        ->placeholder(__('DEVICE ID'))
                        ->columnSpan(4),
                    Select::make('device_type')
                        ->label(__('DEVICE TYPE'))
                        ->options(DeviceTypeEnum::toArray())
                        ->required()
                        ->placeholder(__('Select device type'))
                        ->columnSpan(2),
                    Select::make('status')
                        ->label(__('STATUS'))
                        ->options(DeviceStatusEnum::toArray())
                        ->required()
                        ->placeholder(__('Select status'))
                        ->columnSpan(2),
                ])
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            TextColumn::make('user.email')
                ->searchable()
                ->sortable()
                ->label(__('USER')),
            TextColumn::make('device_id')
                ->label(__('DEVICE ID')),
            TextColumn::make('device_type')
                ->label(__('DEVICE TYPE')),
            TextColumn::make('status')
                ->label(__('STATUS')),
            TextColumn::make('created_at')
                ->label(__('Created Date'))
                ->date()
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPos::route('/'),
            'create' => Pages\CreatePos::route('/create'),
            'edit' => Pages\EditPos::route('/{record}/edit'),
        ];
    }
}
