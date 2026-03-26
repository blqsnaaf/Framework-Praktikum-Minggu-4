<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JenisTransaksiResource\Pages;
use App\Filament\Resources\JenisTransaksiResource\RelationManagers;
use App\Models\JenisTransaksi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
// tambahan untuk komponen input form
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Radio;
// tambahan untuk komponen kolom
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\Grid;

class JenisTransaksiResource extends Resource
{
    protected static ?string $model = JenisTransaksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // 
                Radio::make('jenis_transaksi')
                    ->label('Jenis Transaksi')
                    ->options([
                        'Reimbursement' => 'Reimbursement',
                        'Pengembalian' => 'Pengembalian',
                    ])
                    ->required(),
                
                TextInput::make('keterangan')
                    ->label('Keterangan Transaksi')
                    ->required(),

                DatePicker::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->required(),

                FileUpload::make('foto_ktp')
                    ->label('upload e-ktp')
                    ->image()
                    ->directory('images')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            BadgeColumn::make('jenis_transaksi')
                ->label('Jenis Transaksi')
                ->colors([
                    'success' => 'Reimbursement',
                    'warning' => 'Pengembalian',
                ]),

            TextColumn::make('keterangan')
                ->label('Keterangan Transaksi')
                ->searchable()
                ->sortable(),

            TextColumn::make('tanggal_lahir')
                ->label('Tanggal Lahir')
                ->sortable(),

            ImageColumn::make('foto_ktp')
                ->label('upload e-ktp')
                ->size(50),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListJenisTransaksi::route('/'),
            'create' => Pages\CreateJenisTransaksi::route('/create'),
            'edit' => Pages\EditJenisTransaksi::route('/{record}/edit'),
        ];
    }
}
