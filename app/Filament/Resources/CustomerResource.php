<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    // Optional: Group it in the sidebar (similar to "Staffing" in EmployeeResource)
    // protected static ?string $navigationGroup = 'CRM';
    
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Personal Information')
                    ->schema([
                        /*
                         * Only visible for Super Admin. Others automatically get their `instance_id`
                         * from the Auth user in the saving hook or in modifyQueryUsing (if you handle it that way).
                         */
                        BelongsToSelect::make('instance_id')
                            ->relationship('instance', 'name')
                            ->label('Instance')
                            ->visible(fn () => auth()->user()->hasRole('Super Admin'))
                            ->required(fn () => !auth()->user()->hasRole('Super Admin')),

                        TextInput::make('first_name')
                            ->label('First Name')
                            ->required()
                            ->maxLength(100),

                        TextInput::make('last_name')
                            ->label('Last Name')
                            ->required()
                            ->maxLength(100),

                        TextInput::make('middle_name')
                            ->label('Middle Name')
                            ->maxLength(100),

                        DatePicker::make('date_of_birth')
                            ->label('Date of Birth')
                            ->displayFormat('Y-m-d')
                            ->maxDate(now()),  // Prevent future dates

                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        TextInput::make('phone')
                            ->label('Phone')
                            ->maxLength(50),
                    ]),

                Section::make('Address Information')
                    ->schema([
                        TextInput::make('google_maps_link')
                            ->label('Google Maps Link')
                            ->url(),

                        TextInput::make('city')
                            ->label('City')
                            ->maxLength(255),

                        TextInput::make('zip_code')
                            ->label('ZIP Code')
                            ->maxLength(20),

                        TextInput::make('province')
                            ->label('Province')
                            ->maxLength(255),

                        TextInput::make('barangay')
                            ->label('Barangay')
                            ->maxLength(255),

                        TextInput::make('street')
                            ->label('Street')
                            ->maxLength(255),

                        TextInput::make('house_number')
                            ->label('House Number')
                            ->maxLength(100),

                        TextInput::make('landmark')
                            ->label('Landmark')
                            ->maxLength(100),

                        TextInput::make('country')
                            ->label('Country')
                            ->default('Philippines')
                            ->readOnly()
                            ->maxLength(100),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Optionally show instance in a column only for Super Admin
                TextColumn::make('instance.name')
                    ->label('Instance')
                    ->visible(fn () => auth()->user()->hasRole('Super Admin'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('first_name')
                    ->label('First Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('last_name')
                    ->label('Last Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('phone')
                    ->label('Phone')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('city')
                    ->label('City')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('province')
                    ->label('Province')
                    ->sortable()
                    ->searchable(),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $user = Auth::user();

                // If the user is not a Super Admin, limit to their instance only
                if ($user && !$user->hasRole('Super Admin')) {
                    $query->where('instance_id', $user->instance_id);
                }

                return $query;
            })
            ->filters([
                /*
                 * If you need the same instance filter for Super Admin, just like the EmployeeResource:
                 */
                SelectFilter::make('instance_id')
                    ->relationship('instance', 'name')
                    ->label('Instance')
                    ->visible(fn () => auth()->user()->hasRole('Super Admin')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
