<?php

namespace App\Livewire;

use App\Models\Appointment;
use Livewire\Component;

class Calendar extends Component
{
    public $events = [];
    public $selectedDate = null;
    public $appointments = [];
    public $showModal = false;

    public function mount()
    {
        $this->loadEvents();
    }

    public function loadEvents()
    {
        $this->events = Appointment::where('user_id', auth()->id())
            ->with('client')
            ->select('id', 'date', 'client_id')
            ->get()
            ->map(function ($appointment) {
                return [
                    'title' => $appointment->client?->name ?? 'Atendimento #' . $appointment->id,
                    'start' => $appointment->date,
                    'id' => $appointment->id,
                ];
            })
            ->toArray();
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;
        $this->appointments = Appointment::whereDate('date', $this->selectedDate)
            ->where('user_id', auth()->id())
            ->with(['client', 'serviceType'])
            ->get()
            ->map(function ($appointment) {
                return [
                    'id' => $appointment->id,
                    'date' => $appointment->date,
                    'title' => $appointment->client->name . '-' . $appointment->serviceType?->description,
                ];
            })
            ->toArray();

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->events = Appointment::where('user_id', auth()->id())
            ->with('client')
            ->select('id', 'date', 'client_id')
            ->get()
            ->map(function ($appointment) {
                return [
                    'title' => $appointment->client?->name ?? 'Atendimento #' . $appointment->id,
                    'start' => $appointment->date,
                    'id' => $appointment->id,
                ];
            })
            ->toArray();
    }

    public function render()
    {
        return view('livewire.calendar')->layout('layouts.app');
    }
}
