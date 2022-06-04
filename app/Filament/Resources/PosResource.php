<?php

namespace App\Filament\Resources;

use App\Enums\DeviceStatusEnum;
use App\Enums\DeviceTypeEnum;
use App\Models\Pos;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\PosResource\Pages;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use function Pest\Laravel\options;

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
            ->schema([
                Grid::make(4)
                    ->schema([
                        BelongsToSelect::make('user_id')
                            ->label(__('ASSIGN TO A USER:'))
                            ->searchable()
                            ->placeholder(__('Select user to assign to:'))
                            ->relationship('user', 'email')
                            ->required()
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
            ])
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPos::route('/'),
            'create' => Pages\CreatePos::route('/create'),
            'edit' => Pages\EditPos::route('/{record}/edit'),
        ];
    }
}
