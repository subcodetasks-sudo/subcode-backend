<x-filament-panels::page>
    <x-filament::section>
        <form wire:submit.prevent="submit">
            {{ $this->form }}

            <div class="flex justify-end py-4">
                <x-filament::button type="submit">
                    إرسال
                </x-filament::button>
            </div>
        </form>
    </x-filament::section>
</x-filament-panels::page>
