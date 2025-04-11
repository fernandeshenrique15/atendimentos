<x-filament-panels::page>
    <h1>Editar Perfil</h1>

    <x-filament-panels::form wire:submit.prevent="save">
        {{ $this->form }}

        <div class="mt-4">
            <x-filament::button type="submit">
                Salvar
            </x-filament::button>
        </div>
    </x-filament-panels::form>
</x-filament-panels::page>