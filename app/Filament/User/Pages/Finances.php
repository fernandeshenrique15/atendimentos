<?php

namespace App\Filament\User\Pages;

use App\Models\Appointment;
use App\Models\Expense;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Finances extends Page implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    protected static string $view = 'filament.user.pages.finances';
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Finanças';
    protected static ?string $title = 'Finanças';
    protected static ?string $slug = 'finances';

    public $filters = [
        'startDate' => null,
        'endDate' => null,
    ];

    public function mount(): void
    {
        $this->filters = [
            'startDate' => Carbon::now()->startOfMonth()->toDateString(),
            'endDate' => Carbon::now()->endOfMonth()->toDateString(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('startDate')
                    ->label('Data Inicial')
                    ->default(Carbon::now()->startOfMonth()->toDateString())
                    ->displayFormat('d/m/Y')
                    ->format('Y-m-d')
                    ->native(false)
                    ->required(),
                DatePicker::make('endDate')
                    ->label('Data Final')
                    ->default(Carbon::now()->endOfMonth()->toDateString())
                    ->displayFormat('d/m/Y')
                    ->format('Y-m-d')
                    ->native(false)
                    ->required(),
            ])
            ->statePath('filters');
    }

    public function applyFilters(): void
    {
        $this->dispatch('refreshTable');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(function () {
                return Appointment::where('user_id', Auth::id())
                    ->where('is_paid', true)
                    ->whereBetween('date', [$this->filters['startDate'], $this->filters['endDate']])
                    ->selectRaw('"id", "date", "service_type_id", "price", "is_paid", "client_id", \'Receita\' as record_type')
                    ->with(['serviceType', 'client'])
                    ->union(
                        Expense::where('user_id', Auth::id())
                            ->where('is_paid', true)
                            ->whereBetween('date', [$this->filters['startDate'], $this->filters['endDate']])
                            ->selectRaw('"id", "date", "expense_type_id", "price", "is_paid", NULL as client_id, \'Despesa\' as record_type')
                            ->with('expenseType')
                    );
            })
            ->columns([
                TextColumn::make('type')
                    ->label('Tipo')
                    ->getStateUsing(function ($record) {
                        return $record->record_type;
                    }),
                TextColumn::make('date')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Descrição')
                    ->getStateUsing(function ($record) {
                        return $record->record_type === 'Receita'
                            ? ($record->serviceType->description . ' - ' . $record->client->name)
                            : ($record->description);
                    }),
                TextColumn::make('price')
                    ->label('Valor')
                    ->money('BRL')
                    ->getStateUsing(function ($record) {
                        return $record->price;
                    })
                    ->summarize(Sum::make()
                        ->label('Total')
                        ->money('BRL')),
            ])
            ->filters([])
            ->actions([])
            ->bulkActions([])
            ->defaultSort('date', 'desc');
    }
}