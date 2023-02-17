<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\RelationManagers;
use App\Models\Category;
use App\Models\Course;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('user_id')->label('Author'),
                        Forms\Components\Select::make('category_id')
                            ->options(Category::query()->pluck('name', 'id'))
                            ->searchable()
                            ->label('Kategori'),
                        Forms\Components\TextInput::make('title')
                            ->reactive()
                            ->afterStateUpdated(function (\Closure $set, $state) {
                                $set('slug', Str::slug($state));
                            })
                            ->label('Judul')
                            ->placeholder('Judul'),
                        Forms\Components\TextInput::make('slug')
                            ->disabled()
                            ->placeholder('Slug'),
                        Forms\Components\FileUpload::make('thumbnail'),
                        Forms\Components\TextInput::make('duration'),
                        Forms\Components\Textarea::make('description'),
                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->label('Price')

                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                ,
                Tables\Columns\TextColumn::make('duration')
                    ->label('Duration'),
                Tables\Columns\ImageColumn::make('thumbnail')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
