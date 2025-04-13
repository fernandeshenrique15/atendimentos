<x-filament-panels::page>
    <div class="space-y-6">
        <x-filament-panels::form>
            {{ $this->form }}
            <x-filament::button wire:click="applyFilters" class="mt-4 bg-red-600 text-white dark:text-gray-800 hover:bg-red-500 dark:hover:bg-red-400">
                Filtrar
            </x-filament::button>
        </x-filament-panels::form>
        <div>
            {{ $this->table }}
        </div>
    </div>
</x-filament-panels::page>