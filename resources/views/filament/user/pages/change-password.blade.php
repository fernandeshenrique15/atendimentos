<x-filament-panels::page>
    <h1>Trocar Senha</h1>
    <p>Por favor, altere sua senha no primeiro acesso.</p>

    <x-filament-panels::form wire:submit="save">
        {{ $this->form }}

        <div class="mt-4">
            <x-filament::button type="submit">
                Salvar Senha
            </x-filament::button>
        </div>
    </x-filament-panels::form>
</x-filament-panels::page>