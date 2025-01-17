<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;


class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Personal Information')
                    ->schema([
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
                            ->unique(ignoreRecord: true)  // Allow updates without unique conflicts
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
                //
            ])
            ->filters([
                //
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
